<?include_once(APPPATH."libraries/core.php");


class Ajax extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->POST = $_POST;
	}

	function index()
	{	session_start();
		$this->lang->load('block',$this->db_session->userdata('lang'));
		$this->data['Block']['namekorzina']=$this->lang->line('blocknamekorzina');
		$this->load->file(APPPATH.'libraries/ajax/JsHttpRequest/JsHttpRequest.php', false);
		$JsHttpRequest = new JsHttpRequest("UTF-8");
		
		$method = $this->input->post('method');
		$param = $this->input->post('param');
//print"<br> ------------- ".$this->data['Block']['namekorzina'];
		if (method_exists($this, $method))
		{
			$this->$method($param);
		}
		else 
		{
			$this->sample($param);
		}		

		exit(); // any other output is not required and is conflicting with AJAX JsHtmlRequestor library
	
	}
function redblock(){
	$this->load->model('config_model');
	$this->data["authed"] = true;
	$this->data['MenuLeft'] = $this->config_model->getMenuByMarker('how_the_service_works_menu');
	$this->load->view('block/redblock',$this->data);
}
function convinfo(){
	$this->load->model('config_model');
	//$this->load->model('catalog_model');
  
    $content['fields']=$this->config_model->fields(); 
    $content['Valuta'] = $this->config_model->table('valuta');
	echo $this->load->view('ajax/conv',$content, true);
	//$this->load->view('ajax/conv',$content);
}
function valuta(){
	$_POST = $this->POST;
	$val = $this->input->post('val');
	$valuta1 = $this->input->post('valuta1');
	$valuta2 = $this->input->post('valuta2');
	$this->load->model('config_model');
	
	$curse1 = $this->config_model->table('cur_exchange',array('to'=>$valuta1));
	$curse2 = $this->config_model->table('cur_exchange',array('to'=>$valuta2));
	
	
	echo round($val * $curse1[0]->koef/$curse2[0]->koef, 2);
}
function curs($id=0){
	$id = $this->uri->segment(3);
	$this->load->model('config_model');
	$curs = $this->config_model->row('cur_exchange',array('to'=>$id));
	echo $curs->koef;
}
	
function register(){
	echo $this->load->view('ajax/register.php','',true);
}	
function catalog(){
	$this->load->model('config_model');
	$this->load->model('catalog_model');
	
	if(!empty($this->POST) && ($this->POST['predl']=='true' xor $this->POST['spros'] == 'true')){
		if($this->POST['predl'] == 'true') $conditions = array("type"=>'predl');
		elseif($this->POST['spros'] == 'true') $conditions = array("type"=>'spros');
	}else $conditions = '';
	
	if(!empty($conditions)) $content['Type'] = $conditions['type'];
	$content['Catalog'] = $this->catalog_model->getCatalog($conditions);
	echo $this->load->view('block/catalog',$content,true);
}
function test($p) {

	$res1=$p['id'];
	$res='true';
	
	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
	);
}

function checkusernickname($nickname=''){
	if(!$nickname) return false;
	$this->load->model('auth_model');
	$this->load->model('checks_model');
	if($user = $this->checks_model->getUserByNickname($nickname,'id'))
		echo "OK!";//$nickname." ".$user->id;
	//else echo "NO";
}
function checkusernickname2($nickname=''){
	if(!$nickname) {echo '<input type="text" name="asgmt" value="">'; return false;}
	$this->load->model('auth_model');
	$this->load->model('checks_model');
	$this->load->model('config_model');
	//$this->load->model('catalog_model');
	if($user = $this->checks_model->getUserByNickname($nickname,'id')){
		$member = $this->db_session->userdata('auth');
		$member = $this->auth_model->getUser($member['login']);
		$mypredl = $this->config_model->table("catalog", array("type"=>"predl", "user"=>$member->id, 'dl'=>'n'));
		$spros = $this->config_model->table("catalog", array("type"=>"spros", "user"=>$user->id, 'dl'=>'n'));
		$cat = array_merge($mypredl, $spros);
		$output='<select onchange="chengecat(this.value)" name="asgmt" style="width:125px">';
		foreach ($cat as $v) 
			$output .= '<option class="n" value="'.$v->id.'">'.$v->title.'</option>';
		echo $output .="</select><script type=\"text/javascript\">chengecat(false);</script>";
		
	}
	else echo '<input type="text" name="asgmt" value="">';
}
function chengecat($id){
	$this->load->model('auth_model');
	$this->load->model('config_model');
	$this->load->model('catalog_model');
	//$cat = $this->config_model->row("catalog", array("id"=>$id));
	//print_r($cat);
	//echo '<input type="text" name="info" value="'.$cat->price_info.'">';
	//$comis = ($this->config_model->getConfigName('comis',$this->data['lang']) / 100);
	$poles = array('catalog.id'=>$id);
	$cat = $this->catalog_model->Get($poles);
	echo json_encode($cat[0]);
	//echo '{"note":{"to":"Tove","from":"Jani","heading":"Reminder","body":"forget me this weekend!"}}';
}

function select($p) {
//*
	if(is_numeric($p['id'])){ 
		$this->load->model('config_model');

		$CUR = $this->config_model->getCategoriesMenu();
		$CUR = $this->data['TCat'][$this->data['LCat'][$p['id']]] [$p['id']];
		
		$data['CUR'] = $CUR;
		//$data['id'] = $p['id'];
		//$data['upId'] = $p['name'];
		
		$res1 = $this->load->view('ajax/select.php', $data, true);
//*/
		$res= 'true';
	}else{
		$res= 'false';
		$res1 = '';
	}

	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
	);
	
}

	function upload(){
		//print_r($this->data['auth']);
		$this->load->model('auth_model');
		$uploadDir = 'admin/uploads/'; //папка для хранения файлов
	 
		$allowedExt = array('jpg', 'jpeg', 'png', 'gif');
		$maxFileSize = 2 * 1024 * 1024; //1 MB

		//если получен файл
		if (isset($_FILES)&& !empty($_FILES)) {
		    //проверяем размер и тип файла
		    $ext = end(explode('.', strtolower($_FILES['Filedata']['name'])));
		    if (!in_array($ext, $allowedExt)) {
		        return;
		    }
		    if ($maxFileSize < $_FILES['Filedata']['size']) {
		        return;
		    }
		    if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
		        $fileName = $uploadDir.$_FILES['Filedata']['name'];
		        //если файл с таким именем уже существует…
		        if (file_exists($fileName)) {
		            //…добавляем текущее время к имени файла
		            $nameParts = explode('.', $_FILES['Filedata']['name']);
		            $nameParts[count($nameParts)-2] .= time();
		            $fileName = $uploadDir.implode('.', $nameParts);
		        }
		        //move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileName);
		        
		        $this->load->helper('img_resize');
		        $foto = $_FILES['Filedata'];
				$size = getimagesize($foto['tmp_name']);
				if($size[0] > 800 || $size[1] > 800)
					img_resize($foto['tmp_name'], $foto['tmp_name'], 800, 800,  100, 0xFFFFFF, 0);
					//img_resize($foto['tmp_name'], $foto['tmp_name'], 800, 800,  100, 0xFFFFFF, 0);
		        
				$session_id = end($this->uri->segment_array());
				$this->db->where('session_id',$session_id);
				$query = $this->db->get('ci_sessions');
				$result = $query->row();
				
				$str = explode(":\"login\"",$result->session_data);
				$str = explode("\"",$str[1]);
				$str = $str[1];
				$user=$this->auth_model->getUser($str);
				//$foto = $_FILES['Filedata'];
				
				$u->user = $user->login;
				$u->file_name = $_FILES['Filedata']['name'];
				$u->type= $this->POST['type'];

				$this->db->insert('tempfiles', $u);
				$id = mysql_insert_id();
				$fileName =  $uploadDir.$id;
		        move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileName);		
		        
				$pos = $this->POST['pos'];
		        echo'<table class="temp-images"><tr><td><img src="/uploads/'.$id.'.jpg" alt="'.$_FILES['Filedata']['name'].'" class="upimg" id="upimg'.$id.'" onclick="return ajaxFileUpload('.$id.');"/></td><td style="vertical-align:middle;text-align:right">
		        <a href="#" onclick="return ajaxFileUpload('.$id.');">Редактировать</a>
		        <a href="/ppage/my_bussines/del/'.$id.'" onclick="delimg(\''.$id.'\','.$pos.');return false;">Отменить<a/></td></td></table><div class="br"></div>';

		    }
		}
	}
	function upload_avatar(){
		//print_r($this->data['auth']);
		$this->load->model('auth_model');
		$uploadDir = 'admin/uploads/'; //папка для хранения файлов
	 
		$allowedExt = array('jpg', 'jpeg', 'png', 'gif');
		$maxFileSize = 2 * 1024 * 1024; //1 MB

		//если получен файл
		if (isset($_FILES)&& !empty($_FILES)) {
		    //проверяем размер и тип файла
		    $ext = end(explode('.', strtolower($_FILES['Filedata']['name'])));
		    if (!in_array($ext, $allowedExt)) {
		        return;
		    }
		    if ($maxFileSize < $_FILES['Filedata']['size']) {
		        return;
		    }
		    if (is_uploaded_file($_FILES['Filedata']['tmp_name'])) {
		        $fileName = $uploadDir.$_FILES['Filedata']['name'];
		        //если файл с таким именем уже существует…
		        if (file_exists($fileName)) {
		            //…добавляем текущее время к имени файла
		            $nameParts = explode('.', $_FILES['Filedata']['name']);
		            $nameParts[count($nameParts)-2] .= time();
		            $fileName = $uploadDir.implode('.', $nameParts);
		        }
		        //move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileName);
		        
		        $this->load->helper('img_resize');
		        $foto = $_FILES['Filedata'];
				$size = getimagesize($foto['tmp_name']);
				if($size[0] > 800 || $size[1] > 800)
					img_resize($foto['tmp_name'], $foto['tmp_name'], 800, 800,  100, 0xFFFFFF, 0);
		        
				$session_id = end($this->uri->segment_array());
				$this->db->where('session_id',$session_id);
				$query = $this->db->get('ci_sessions');
				$result = $query->row();
				
				$str = explode(":\"login\"",$result->session_data);
				$str = explode("\"",$str[1]);
				$str = $str[1];
				$user=$this->auth_model->getUser($str);
				//$foto = $_FILES['Filedata'];
				
				$u->user = $user->login;
				$u->file_name = $_FILES['Filedata']['name'];
				$u->type= $this->POST['type'];

				$this->db->insert('tempfiles', $u);
				$id = mysql_insert_id();
				$fileName =  $uploadDir.$id;
		        move_uploaded_file($_FILES['Filedata']['tmp_name'], $fileName);		
		        
				$pos = $this->POST['pos'];
		        echo'<table class="temp-avatar"><tr><td><img src="/uploads/'.$id.'.jpg" alt="'.$_FILES['Filedata']['name'].'" class="upimg" id="upimg'.$id.'" onclick="return ajaxFileUpload('.$id.');"/>
		        <a href="#" onclick="return ajaxFileUpload('.$id.');">Редактировать</a>
		        </td></td></table><div class="br"></div>';

		    }
		}
	}


function crop_pos_image(){
    $page_content='';
    $id = $this->uri->segment(3);
	if (isset($_REQUEST['gocrop']))
		{
			//$pos=(int)$_REQUEST['pos'];
/*
			$filename=addslashes($_REQUEST['img']);
			$arr=explode('.',$filename);
								//$typ=$arr[1];
								$typ = 'jpg';
								$src='admin/uploads/'.$filename;
								$src2='admin/uploads/'.$filename;
								$targ_w=240;
								$targ_h=140;
								$x1=(int)$_REQUEST['x1'];
								$y1=(int)$_REQUEST['y1'];
								$x2=(int)$_REQUEST['x2'];
								$y2=(int)$_REQUEST['y2'];
								$jpeg_quality='95';
								switch ($typ)
								{
									case 'jpg':
										{
											$img_r = imagecreatefromjpeg($src);
											$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
											imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1,$targ_w,$targ_h,$targ_w,$targ_h);
											imagejpeg($dst_r,$src2,$jpeg_quality);
											break;
										}
									case 'png':
										{
											$img_r = imagecreatefrompng($src);
											$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
											imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1,$targ_w,$targ_h,$targ_w,$targ_h);
											imagepng($dst_r,$src2,$jpeg_quality);
											break;
										}
									case 'gif':
										{
											$img_r = imagecreatefromjgif($src);
											$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
											imagecopyresampled($dst_r,$img_r,0,0,$x1,$y1,$targ_w,$targ_h,$targ_w,$targ_h);
											imagegif($dst_r,$src2,$jpeg_quality);
											break;
										}
								}
								//mysql_query("INSERT INTO ".TBLPRE."cat_img (`pos`,`img`) VALUES ('$pos','$filename')") or die(mysql_error());
								//unlink($src);
		*/
	$_POST = $this->POST;
	$this->load->helper('upload_crop');
	
	//print_r($_POST);
	//$max_file = "3"; 							// Maximum file size in MB
	//$max_width = "500";							// Max width allowed for the large image
	$thumb_width = "500";						// Width of thumbnail image
	$thumb_height = "250";						// Height of thumbnail image
	$filename=addslashes($_REQUEST['img']);
	$thumb_image_location='admin/uploads/'.$filename;
	$large_image_location='admin/uploads/'.$filename;
	
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
if($x1!=''&&$x2!=''&&$y1!=''&&$y2!=''&&$w!=''&&$h!=''){
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);	}	
				$page_content.="Изображение обработано";
		} else
		{
			$size = getimagesize('admin/uploads/'.$id);
			//$url=addslashes($_REQUEST['img']);
			//$imgcod=addslashes($_REQUEST['imgcod']);
			//$pos=(int)$_REQUEST['pos'];
			$page_content.="<div id='but_close'><img src='/images/close_button.png'></div>
							<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head'>Обработка изображения</span></td></tr>
							</table>
							<form method='post' id='crop_form' action=\"/ppage/my_bussines/upload_crop\">
							<table align=center cellspacing=0 cellpadding=2 border=0 style=\"margin:10px auto;\">
							<tr><td  align=center><div id='ajax_canvas' style=\"text-align:left;position:relative;\"><img id='canvas' src='/uploads/$id.jpg/".rand()."' ></div></td></tr>
							<tr><td><input type=button id='go_but' value=''></td></tr>
							</table>
							<input type=hidden name=img value=$id >
							<input type=hidden name=gocrop value=true>
							<input type=hidden id='x1' name='x1' />
							<input type=hidden id='y1' name='y1' />
							<input type=hidden id='x2' name='x2' />
							<input type=hidden id='y2' name='y2' />
							<input type=hidden id='w'  name='w'  />
							<input type=hidden id='h'  name='h'  />

								<script language=\"JavaScript\">
								    $('#but_close').click($.unblockUI);
									$('#go_but').click(function(){
										query = $(\"#crop_form\").serialize();
										$.post('/ajax/crop_pos_image',query,function(data){
											$.growlUI(data, '');
											imgname = $('#upimg$id').attr('src','/uploads/$id.jpg/".rand()."');
											
											//$('#ajax').html(data);
											//$('#but_close').click($.unblockUI);
										
										});
									});	
									$('#go_but').click($.unblockUI);
									
										function updateCoords(img,selection)
										{
											$('#x1').val(selection.x1);
											$('#y1').val(selection.y1);
											$('#x2').val(selection.x2);
											$('#y2').val(selection.y2);
											$('#w').val(selection.width);
											$('#h').val(selection.height);
										};
									$('#canvas').imgAreaSelect({ x1:0,y1:0,x2:".$size[0].",y2:".$size[0]/2 .", parent:'#ajax_canvas',aspectRatio: '2:1',zIndex:9999, onSelectChange: updateCoords });	
									</script>
							</form>
							";
		}
	echo $page_content;		
	
}
function crop_pos_image_avatar(){
    $page_content='';
    $id = $this->uri->segment(3);
	if (isset($_REQUEST['gocrop']))
		{
	$_POST = $this->POST;
	$this->load->helper('upload_crop');
	
	//print_r($_POST);
	//$max_file = "3"; 							// Maximum file size in MB
	//$max_width = "500";							// Max width allowed for the large image
	$thumb_width = "100";						// Width of thumbnail image
	$thumb_height = "150";						// Height of thumbnail image
	$filename=addslashes($_REQUEST['img']);
	$thumb_image_location='admin/uploads/'.$filename;
	$large_image_location='admin/uploads/'.$filename;
	$x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
if($x1!=''&&$x2!=''&&$y1!=''&&$y2!=''&&$w!=''&&$h!=''){
	//Scale the image to the thumb_width set above
	$scale = $thumb_width/$w;
	$cropped = resizeThumbnailImage($thumb_image_location, $large_image_location,$w,$h,$x1,$y1,$scale);	}	
				$page_content.="Изображение обработано";				
		} else
		{
			//$url=addslashes($_REQUEST['img']);
			//$imgcod=addslashes($_REQUEST['imgcod']);
			//$pos=(int)$_REQUEST['pos'];
			$page_content.="<div id='but_close'><img src='/images/close_button.png'></div>
							<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head'>Обработка изображения</span></td></tr>
							</table>
							<form method='post' id='crop_form' action=\"#\">
							<table align=center cellspacing=0 cellpadding=2 border=0 style=\"margin:10px auto;\">
							<tr><td  align=center><div id='ajax_canvas' style=\"text-align:left;position:relative;\"><img id='canvas' src='/uploads/$id.jpg/".rand()."' ></div></td></tr>
							<tr><td><input type=button id='go_but' value=''></td></tr>
							</table>
							<input type=hidden name=img value=$id >
							<input type=hidden name=gocrop value=true>
							<input type=hidden id='x1' name='x1' />
							<input type=hidden id='y1' name='y1' />
							<input type=hidden id='x2' name='x2' />
							<input type=hidden id='y2' name='y2' />
							<input type=hidden id='w'  name='w'  />
							<input type=hidden id='h'  name='h'  />

								<script language=\"JavaScript\">
								    $('#but_close').click($.unblockUI);
									$('#go_but').click(function(){
										query = $(\"#crop_form\").serialize();
										$.post('/ajax/crop_pos_image_avatar',query,function(data){
											$.growlUI(data, '');
											imgname = $('#upimg$id').attr('src','/uploads/$id.jpg/".rand()."');
											
											//$('#ajax').html(data);
											//$('#but_close').click($.unblockUI);
										
										});
									});	
									$('#go_but').click($.unblockUI);
									
										function updateCoords(img,selection)
										{
											$('#x1').val(selection.x1);
											$('#y1').val(selection.y1);
											$('#x2').val(selection.x2);
											$('#y2').val(selection.y2);
											$('#w').val(selection.width);
											$('#h').val(selection.height);
										};
									$('#canvas').imgAreaSelect({ x1:0,y1:0,x2:100,y2:150, parent:'#ajax_canvas',aspectRatio: '2:3',zIndex:9999, onSelectChange: updateCoords });	
									</script>
							</form>
							";
		}
	echo $page_content;		
	
}
function korzina($p) {

	$res1='';
	$res='true';
$this->load->model('products_model');

//$this->db_session->set_userdata('basket','');
$this->data['basket']=$this->db_session->userdata('basket');
//print_r($this->data['basket']);


if(!isset($this->data['basket'])||!is_array($this->data['basket'])):
  $this->data['basket'][0]['name']=$this->products_model->GetProduct ($p['id']);
  $this->data['basket'][0]['kol']=1;
else:
  for($i=0;;$i++):
     //print"<br><br>111 --- ".$this->data['basket'][$i]['name'][0]->id;
     //print"<br> --- ".$p['id'];
  
     if(!isset($this->data['basket'][$i]['name'])) break;
       if($this->data['basket'][$i]['name'][0]->id==$p['id']) {break;}
  endfor;
///  print"<br>i ------- ".$i;
 // $i++;
  $this->data['basket'][$i]['name']=$this->products_model->GetProduct ($p['id']);
  if(isset($this->data['basket'][$i]['kol'])) $this->data['basket'][$i]['kol']++;
  else $this->data['basket'][$i]['kol']=1;
  
endif;  
    $this->db_session->set_userdata('basket',$this->data['basket']);
    //print_r($this->data);
	$res1=$this->load->view('korzina2.inc.php',$this->data);
	
	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
);
	
	
}
	
	
function filtrclass2($p) {
	//print"<br> ------------- ";
	$res1='';
	$res='true';
	
	$this->load->model('products_model');
    if(isset($p['id'])&&$p['id']!='all'):
       $this->data['filtrklass2'] = $this->products_model->GetProduct('no',$p['id'],'no','no','no','asc','no','no','no','no');
       $this->data['filtrklass2_sel']='all';
       $this->data['filtrklass1_sel']=$p['id'];
    endif;
   
   
    $p1=array();
    $p1[0]=$p['id'];
           
       $this->data['filtrfirms'] = $this->products_model->GetProduct('no',$p1,'yes','no','no','asc','no','no','no','no');
       $this->data['filtrfirms'] = $this->products_model->GetProductFirms($this->data['filtrfirms']);
       $this->data['filtrfirms_sel']='all';	 
       $res1=$this->load->view('phpfiles/filtrklass2.php', $this->data);
   
   
   
   
   
	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
);
}


function filtrfirms($p) {
	$res1='';
	$res='true';
	
	$this->load->model('products_model');
	//print_r($p);
	$this->data['filtrfirms'] = $this->products_model->GetProduct('no',$p,'yes','no','no','asc','no','no','no','no');
	//print_r($this->data['filtrfirms']);
    $this->data['filtrfirms'] = $this->products_model->GetProductFirms($this->data['filtrfirms']);
    
    //print_r($this->data['filtrfirms']);
    $this->data['filtrfirms_sel']='all';	 
    $res1=$this->load->view('phpfiles/filtrfirms.php', $this->data);
    
    
	
   /* if(isset($p['id'])&&$p['id']!='all'):
       $this->load->model('products_model');
       $this->data['filtrclass3'] = $this->products_model->GetProduct($p['id'],'no','no','no','asc','no','no');
       $this->data['filtrklass3_sel']='all';
       //$res1=$this->load->view('phpfiles/filtrklass3.php', $this->data);
       
    endif;*/
	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
);
}


function avtoriz($p) {
	$res1='';
	$res='true';
	
	$this->load->model('auth_model');
	  if ($p["login"] == "" || $p["pass"] == "" || !$this->auth_model->isUser($p["login"], $p["pass"])):
	   //$res1=header("location: /auth/login");
	   //$_POST['feed']='on';
	  else:
	    $users=$this->auth_model->getUser($p["login"]);
		$user["login"] = $users->login;
		$user["pass"] = $users->password;
		$user["fio"] = $users->name;
		$user["mail"] = $users->email;
		$user["phone"] = $users->phone;
		$user["logDate"] = date("Y-m-d H:i:s");
		
		$this->db_session->set_userdata('auth',$user);
		$this->data["auth"]= $user;
	  endif;
	  $res1=$this->load->view('blockavtor.inc.php', $this->data);
	  
	$GLOBALS['_RESULT'] = array(
	"HTML"   => $res1,
	"result" => $res
);
}















	
	/**
	 * Sample ajax method
	 *
	 * @param unknown_type $a
	 */
	function sample($str = 'Hello world. Привет.')
	{
//		.print_r($this->uri->uri_string(), true)
		if (!is_string($str))
			$data['text'] = "<pre>".print_r($str, true)."</pre>";
		else
			$data['text'] = $str;
		sleep(2);
		
		$string = $data['text'];
		
		$GLOBALS['_RESULT'] = array(
			"HTML"   => $string
		);
	}
	
	function accessDeny()
	{
		$this->load->file(APPPATH.'libraries/ajax/JsHttpRequest/JsHttpRequest.php', false);
		
		$JsHttpRequest = new JsHttpRequest("UTF-8");
		
		$user = $this->db_session->userdata('user');
		
		$string = "Доступ <strong>".$user["username"]."</strong> к странице запрещен.";

		$GLOBALS['_RESULT'] = array(
			"HTML"   => $string
		);
		exit;
	}
	
	// hack for set params
	/*
	function _remap($m)
	{
		$p = $this->input->post('param');
			
		unset($_POST);
		$_POST = null;
		
		$this->$m($p);
		exit();
	}	
	*/
	
}
?>