<?
class Config_model extends Model 
{ 
  function Config_model()  {   parent::Model();  }

  function getAllMenu($id=1,$lang='no',$auth='n')
  {
  	$group = 'guest';
  	if($auth=='y' && !empty($this->data['auth'])){
		if(isset($this->data['auth']['login'])){
			$this->db->where('login ',$this->data['auth']['login']);
			$query=$this->db->get('user_groups');	
			if($query->num_rows()>0){
				$result = $query->result();
				$group = $result[0]->group;
			}
  		}
	}
		
  	$menu=false;
    	$menu2=array();
    	$i=0;
    	if($lang!='no'&&$lang!='all'):
		$this->db->select("map.id as id, 
		                   map.link as link, 
		                   sites.name as name");
		$this->db->join('sites', 'sites.mapsite = map.id');
	    $this->db->where("sites.lang" , $lang);		
		endif;
		

		
		if($auth=='y'):
			$this->db->join('acl', 'acl.resource = map.resource');
			if($group=='member')
	    		$this->db->where("(acl.group = 'guest' OR acl.group = 'member')");
			else
				$this->db->where("acl.group" , 'guest');
	    		
		endif;
		
		if( !(isset($this -> data['ShowInvisiblePages']) && $this -> data['ShowInvisiblePages']) )
			$this->db->where("visible" , 'y');
		$this->db->where("sitemap" , 'y');
		//$this->db->where("upId" , $id);
		$this->db->orderby("map.upId" , 'asc');
		$this->db->orderby("map.sort" , 'desc');
		$this->db->orderby("map.id" , 'asc');
		$query=$this->db->get('map');

        $result = $query->result();
        
        
        foreach ($result as $row){
        	$LMap[$row->id] =	$row->upId;
        }
        $this->data['LMap'] = $LMap;
        //print_r($LMap);
        
        foreach ($result as $row){
        	$item['id'] = $row->id;
        	$item['upId'] = $row->upId;
        	$item['name'] = $row->title;
        	$item['link'] =	'/'.$row->link;
        	if ($item['link'] == '//') $item['link'] = '/';
        	//$item['level'] = 0;
    		
        	$CurTMapItem = &$TMap[$item['upId']][$item['id']];
            if(!isset($TMap[$item['id']])) $TMap[$item['id']] = NULL;
            
            //адресс массива елементов upId которых = id => ['id']['child']
        	$item['child'] = &$TMap[$item['id']];
       		if(isset($row->menu1) && $row->menu1=='y')// Для главного меню
        		{$item['sort'] = $row->msort1; $TMap[0][]=&$CurTMapItem;}
        	$item['dom'] = &$TMap[$item['upId']];

        	$CurTMapItem = $item;
        	//if ($CurTMapItem['link'] == '/news') $CurTMapItem['child'] = $this->getNewsMenu(&$CurTMapItem); // присоединить меню новостей
        	
        	if(isset($LMap[$item['upId']])){
        		$CurTMapItem['parent'] = &$TMap[$LMap[$item['upId']]][$item['upId']];

			$CurTMapItem['link'] = $CurTMapItem['parent']['link'].$CurTMapItem['link'];
			//$CurTMapItem['level'] = $CurTMapItem['parent']['level']+1;
        	}
         }
        
        $TMap = array_diff($TMap, array(NULL));	// Удалить все пустые(NULL) элементы
        	
       	$this->data['TMap'] = $TMap;
       	
       if ($id != 0)	return $TMap[$LMap[$id]][$id];
       else 			return $TMap;
  }
  function MakeLink(&$TMenuItem, $lang='no')
  {
  	if (!isset($TMenuItem)) return '';
  	$link = '';
 	if (isset($CurItem['parent'])) 
 		$link =  $this->MakeLink($TMenuItem['parent'], $lang);
 	$link .=$TMenuItem['link'];
   	return $link;
  }
   
function ExtendedMenu($table, $id=0)
{

	if(false && $lang!='no' && $lang!='all'):
	$this->db->select("map.id as id,
					   map.link as link,
					   sites.name as name");
	$this->db->join('sites', 'sites.mapsite = map.id');
	$this->db->where("sites.lang" , $lang);
	endif;

	$this->db->select("*, $table.id as id,
					   $table.upId as upId,
					   $table.name as name,
					   $table.title as title,
					   $table.sort as sort,
					   map.upId as mapUpId,
					   map.title as mapTitle
					   ");
	$this->db->join('map', "map.id = $table.mapId", 'left');
	$this->db->where("$table.visible" , 'y');
	$this->db->orderby("$table.upId" , 'asc');
	$this->db->orderby("$table.sort" , 'desc');
	$this->db->orderby("$table.id" , 'asc');
	$query=$this->db->get($table);

	$result = $query->result();

	foreach ($result as $row){
		$LMenu[$row->id] =	$row->upId;
	}

	foreach ($result as $row){
		$item['id'] = $row->id;
		$item['upId'] = $row->upId;
		$item['mapId'] = $row->mapId;
		$item['name'] = $row->name;
		$item['title'] = $row->title;
		$item['marker'] = $row->marker;
		$item['htmlid'] = $row->htmlid;
		$item['htmlclass'] = $row->htmlclass;
		if(isset($this->data['TMap'][$row->mapUpId][$row->mapId]['link']))
			$item['link'] =	$this->data['TMap'][$row->mapUpId][$row->mapId]['link'];
		else $item['link'] = $row->url;
		$item['url'] = $row->url;

		$CurTMenuItem = &$TMenu[$item['upId']][$item['id']];
		if(!isset($TMenu[$item['id']])) $TMenu[$item['id']] = NULL;

		//адресс массива елементов upId которых = id => ['id']['child']
		$item['child'] = &$TMenu[$item['id']];
		if(isset($row->menu1) && $row->menu1=='y')// Для главного меню
			{$item['sort'] = $row->msort1; $TMenu[0][]=&$CurTMenuItem;}
		$item['dom'] = &$TMenu[$item['upId']];

		$CurTMenuItem = $item;

		if(isset($LMenu[$item['upId']])){
			$CurTMenuItem['parent'] = &$TMenu[$LMenu[$item['upId']]][$item['upId']];
		}
	 }

	$TMenu = array_diff($TMenu, array(NULL));	// Удалить все пустые(NULL) элементы

	$this->data['LMenu'] = $LMenu;
	$this->data['TMenu'] = $TMenu;
	$LMarker = isset($this -> data['LMarker']) ? $this -> data['LMarker'] : $this -> makeLMarker();

	if( is_string($id) && !is_numeric($id) ) {

		if( isset($TMenu[ $LMenu[$LMarker[$id]] ][ $LMarker[$id] ]) ) {

			return $TMenu[ $LMenu[$LMarker[$id]] ][ $LMarker[$id] ];

		}
	}

	if ($id != 0){
		reset($TMenu[0]);
		for($i=1;$i<$id;$i++)next($TMenu[0]);
	}
   // print_r($TMenu[0]);
   if ($id != 0)	return current($TMenu[0]);
   else 			return $TMenu[0];
}

function getMenuByMarker($marker=null)
{
	$result = NULL;

	if ( !isset($this -> data['TMenu']) ) {

		$this -> ExtendedMenu('menu');

	}

	if( $marker && isset($this->data['TMenu'][ $this->data['LMenu'][$this->data['LMarker'][$marker][0]] ][ $this->data['LMarker'][$marker][0] ]) ) {

		$result =  $this->data['TMenu'][ $this->data['LMenu'][$this->data['LMarker'][$marker][0]] ][ $this->data['LMarker'][$marker][0] ];

	}

	return $result;
}

function menulink(&$menu, $id){
	//print_r($menu);
	//$markers= array('aboutmember'=>);
	foreach ($menu as &$item){
			if(/*!empty($item['marker']) && */!empty($item['link'])) $item['link'].= "/".$id;//$markers[$item['marker']];
	}
}
function makeLMarker()
{
	$table = 'menu';
	$this->db->select("id, marker");
	$this->db->where("visible" , 'y');
	$this->db->where("dl" , 'n');
	$this->db->where('marker != ""');

	$query=$this->db->get($table);

	$result = $query->result();

	foreach ($result as $row){
		$LMarker[$row->marker][] = $row->id;
	}

	return $this -> data['LMarker'] = $LMarker;
}
    function getText_log($link)
    { 
        $this->db->where('link', $link);
        $query = $this->db->get('text');
        
        if ($query->num_rows()>0)
        {
        	$result=$query->row();
        	return $result->text;
        }
        return '';
    }     
  
  
    function getText($id)
    {/*
        $result = false;
        $this->db->where('id', $id);
        $query = $this->db->get('map');
        $result=$query->row();
       
        
        $this->db->where('link', $result->link);
        $query = $this->db->get('text');
        //*/
    	
    	$this->db->where('mapid', $id);
        $query = $this->db->get('text');
    	
        if ($query->num_rows()>0)
        {
        	$result=$query->row();
//        print"<br>   ---------- ";
  //      print_r($result);
        	
        	
        	return $result->text;
        }
        return '';
    }   
  
  
     
function Get_Page($uri='',$router,$lang){
//	print"<br> --------- ".$this->uri->segment(1);
	  
  	  if($this->uri->segment(1)==''||$this->uri->segment(1)==$lang) $uri[1]='/';
  	  //print_r($router->fetch_class());
  	  
      //if(count($uri) == 0)          {$uri[0]='/';}
  	  
      //if(count($uri) == $k+1){
      //print"<br> ------- ".$k;
      //print"<br> ------- ".$this->uri->segment(1);
      //print"<br> ------- ".$uri[0];
      //print"<br> ------- ".$router->fetch_class();
     // print_r($uri);
        for($i = 1; isset($uri[$i]); $i++)
        {
        	//if($i==2&&isset($uri[$i-1])&&$uri[$i-1]=='/') $i
            $link = $uri[$i];
            //$query = "SELECT * FROM map WHERE link='".$link."' AND resource='".$router->fetch_class()."'";
       //print"<br>-------".$lang;
                
       if($lang!='no')     
         $this->db->select("map.id as id, 
		                   map.link as link, 
		                   sites.name as name,
		                   sites.html as html,
		                   sites.keywords as keywords,
		                   sites.description as description
		                   ");
        else   $this->db->select("*");
       
         
        if($lang!='no')	$this->db->join('sites', 'sites.mapsite = map.id');
        //$this->db->where("visible" , 'y');
        
		$this->db->where("link" , $link);
		if(isset($page['id'])) {
			$this->db->where("upId" , $page['id']);//echo $page['id'];
		}
		
	//	if($lang!='no')	$this->db->where("lang" , $lang);
		//echo ' ',$router->fetch_class();
		$this->db->where("resource" , $router->fetch_class());
        $result=$this->db->get('map');            
        //$result = $result->result();
            
            //$result = $this->db->query($query);
            if ($result->num_rows()>0)
            {   $page = $result->row_array();
            }
        }
        
    if (!empty($page)) return $page;
        else           show_404();
       //}
}        
     
     


function getPathById($id,$lang)
    {
        $path = array();
        
        $flag = true;
        $curr_id = $id;
        while($curr_id != 1 && $flag)
          { if($lang!='no'){
          	      $this->db->select("map.id as id, map.upId as upId, map.link as link, sites.name as name, sites.lang as lang");
          	      $this->db->join('sites', 'sites.mapsite = map.id');
          	      $this->db->where("lang" , $lang);
               }
            else  $this->db->select("*");
            
            
            //$this->db->where("visible" , 'y');
            $this->db->where("map.id" , $curr_id);
            $this->db->orderby("sort" , 'asc');
            $record = $this->db->get('map');      

           if ($record->num_rows()>0)
            {
                $record = $record->row();
                $curr_id = $record->upId;
                $elem='';
                if($lang!='no')
                     $elem['name'] = $record->name;
                else $elem['name'] = $record->title;
                
                $elem['link']="/";if($record->link!='/') $elem['link'] .= $record->link;
                
                
                $this->db->where("visible" , 'y');
                $this->db->where("map.upId" , $curr_id);
                $record2 = $this->db->get('map');      

                if($record2->num_rows()>0){
                   $record2 = $record2->result();
                   $p=array();
                   foreach($record2 as $r):
                     $p['name']=$r->title;
                     $p['link']='/';
                     if($r->link!='/')
                     $p['link'] .= $r->link;
                     
                     $elem['child'][]=$p;
                   endforeach;
                }
             
                
                if (!empty($path))
                {
                  foreach ($path as &$v)
                    {
               	       if($record->link!='/') 
                                     $v['link'] = "/".$record->link.$v['link'];
                       if(!empty($v['child']))              
                       foreach($v['child'] as &$v2):
                           $v2['link'] = "/".$record->link.$v2['link'];
                       endforeach;
                                     
                                     //print"<br> ---- ".$v['link'];
                    }
                }
            array_unshift($path, $elem);
            //print"<br>-------<br>";
            //print_r($path);
            
            }
            else 
            {
                $flag = false;
            }
        }
        /*
        foreach ($path as &$v)
         {
          $v['link'] = '/'.$v['link'];
         }

        if($this->uri->segment(2)){
        	$this->db->where('link', '/');
        $record = $this->db->get('map');
        $record = $record->row();
        if($lang!='no')
             $elem['name'] = $record->name;
        else $elem['name'] = $record->title;

        $elem['link'] = $record->link;
        /*
        $elem['name']='Главная';
        $elem['link']='/';
        * /
        array_unshift($path, $elem);
        
        }*/
        return $path;
    }


   function getTitle($path,$title)
    {
        $Title='';
        if($title!='') $Title.=" ".$title." | ";
        foreach ($path as $p):
         if($p['link']!='/'&&$this->uri->segment(2)!=''||$this->uri->segment(2)==''):
           $Title.=" ".$p['name'];
           if(end($path)!=$p)  $Title.=" &raquo; ";
         endif;  
        endforeach;
        return $Title; 
    }
             
     
     
     
     
function fields(){
	$this->CI = get_instance();
	$this->lang->load('forma',$this->db_session->userdata('lang'));
    // $this->CI->lang->load('forma');	
     return $this->CI->lang->language;
}


function auth(){
	$this->CI =& get_instance();
     $this->CI->lang->load('auth');	
     return $this->CI->lang->language;
}

     
     
     
     
 
  function getConfig()
    {
        $result = false;
        $query = $this->db->get('config');
        if ($query->num_rows()>0)
        {
            foreach ($query->result() as $r):
                $result[$r->name]=$r->value;
            endforeach;
        }
        return $result;
    }
    
    
  function isLang()
    {
        $result = false;
        $query = $this->db->get('lang');
        if ($query->num_rows()>0)
        {
            foreach ($query->result() as $l):
               if($this->uri->segment(1)==$l->lang) $result=true;
            endforeach;
        }
        return $result;
    }
    
  function Lang()
    {
    	$this->db->orderby('sort','asc');
        $query = $this->db->get('lang');
        return $query->result();
    }
    
    
    
    
    
    
 function LinkNoLang()
    {
        return preg_replace("/\/".$this->uri->segment(1)."/","",$_SERVER["REQUEST_URI"]);
    }
    

    
    
   function getConfigName($name,$lang='no')
    {
        $result = false;
        $this->db->where('name', $name);
        if($lang != 'no'&&$lang != 'all')
        $this->db->where('lang', $lang);
        $query = $this->db->get('config');
        if ($query->num_rows()>0)
        {
            $result = $query->row();
            $result = $result->value;
        }
        return $result;
    }

    function table($table, $conditions = array(), $sort = array()){
		if(is_array($conditions))
    	foreach ($conditions as $key=>$val)
			$this->db->where($key, $val);
		if(is_array($sort))
    	foreach ($sort as $key=>$val)
			$this->db->order_by($key, $val);
		if($query = $this->db->get($table))
			return $query->result();  
		return false;
    }
    function row($table, $conditions = array()){
    	//$this->db->select("$table.*");
		if(is_array($conditions))
    	foreach ($conditions as $key=>$val)
			$this->db->where($key, $val);
		if($query = $this->db->get($table))
			return $query->row();  
		return false;
    }
    function value($table, $pole='id', $conditions = array()){
		if(is_array($conditions))
    	foreach ($conditions as $key=>$val)
			$this->db->where($key, $val);
		if($query = $this->db->get($table))
			$row = $query->row(); 
		if(isset($row->$pole)) 
			return $row->$pole;
		return false;    	
    }
    function cnt($table, $conditions = array()){
    	$this->db->from($table);
		if(is_array($conditions))
    	foreach ($conditions as $key=>$val)
			$this->db->where($key, $val);
		return  $this->db->count_all_results();
    }
// =========================================   
//* 
function sendMsg($name, $mail, $txt){
	
$name = mb_convert_encoding($name, 'cp1251', 'utf8');

require_once APPPATH."libraries/swift/Swift.php";
require_once APPPATH."libraries/swift/Swift/Connection/SMTP.php";

$A_SMTP = "localhost";
$A_SMTP_port = "25";
$A_SMTP_user = "";
$A_SMTP_pass = "";
$A_language = "ru";

  

$mail2=explode(",", $mail);
//print_r($mail2);
foreach ($mail2 as $mail1):
//print"<br> --- ".$mail1;

$A_admin_mail = $mail1;
$A_admin_mail_CC = array($mail1);
//$A_admin_mail_CC =array($A_admin_mail);
//$A_admin_mail_CC = explode(",", $mail);
//$pieces = explode(" ", $pizza);

$A_admin_mail_From = $mail1;
$A_admin_mail_From = 'info@infomena.com';


try {

   $smtp = new Swift_Connection_SMTP($A_SMTP,$A_SMTP_port);
   $smtp->setUsername($A_SMTP_user);
   $smtp->setpassword($A_SMTP_pass);
   $swift = new Swift($smtp);
   $message = new Swift_Message($name);
   $message->attach(new Swift_Message_Part($txt, "text/html", "base64", "UTF-8"));
   $message->headers->setLanguage($A_language);
   $recipients = new Swift_RecipientList();

   
   $recipients->addTo($A_admin_mail);
   
   foreach ($A_admin_mail_CC AS $val)
       $recipients->addCc($val);

   $swift->send($message,$recipients, $A_admin_mail_From);
   $data['error']="Сообщение отослано.";
   if($mail1==end($mail2))
   return true;
  } 
        
catch (Swift_ConnectionException $e) {
   $data['error']="Cообщение не может быть отправлено."
   ." Пожалуйста, сообщите администратору сервиса по адресу<br />"
   ." <a href=\""
   .$A_admin_mail."\">"
   .$A_admin_mail."</a>"
   .'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was a problem communicating with SMTP: " . $e->getMessage().']</div>';
   return false;
  } 
        
catch (Swift_Message_MimeException $e) {
  $data['error']="Cообщение не может быть отправлено."
   ." Пожалуйста, сообщите администратору сервиса по адресу<br />"
   ." <a href=\""
   .$A_admin_mail."\">"
   .$A_admin_mail."</a>"
   .'<div style="padding-top: 10px; font-weight: normal; font-size: 0.8em;"> ['."There was an unexpected problem building the email:" . $e->getMessage().']</div>';
   return false;
  }
endforeach;  
}
//*/
/*
function sendMsg($name, $mail, $txt){
$name = mb_convert_encoding($name, 'koi8-r', 'utf8');

$result = true;
$mail2=explode(",", $mail);
foreach ($mail2 as $mail1):

$mail1 = trim($mail1);
$A_admin_mail = $mail1;
$A_admin_mail_CC = array($mail1);
$A_admin_mail_From = $mail1;

$headers  =   'MIME-Version: 1.0' . "\r\n";
	$headers   .= 'Content-type: text/plain; 
			charset= utf8' . "\r\n";
	$headers .= 
		'From: ' .$name.' <info@'.str_replace("www.","",getenv("HTTP_HOST")).'>'. "\r\n";
@$result = $result && mail($A_admin_mail,$name , $txt, $headers);
endforeach; 
return $result;
}
//*/
// =========================================






	
	
	

}    

?>