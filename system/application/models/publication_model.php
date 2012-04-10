<?php
class Publication_model extends Model
{
   function __construct()
    {
        parent::Model();
      //  $this->db->query('SET NAMES cp1251');
    }


     /************************************************
     * recive news from base, ordered by  date,
     * if set $col, return $col count news, from $from 
     */
    function getPublic($table, $col = 0, $from = 0, $type='', $lang = 'all')
    {
        $this->db->orderby('date', 'desc');
        $this->db->select('*, date_format(date, \'%d.%m.%Y\') as dates',FALSE);
        $this->db->where('sleep','y');
        if(!empty($type)) $this->db->where('type', $type);
        if($lang!='no'&&$lang!='all')
        $this->db->where('lang',$lang);
        $this->db->orderby('date', 'desc');
        // if set count, then set limit
        if ($col != 0)   $this->db->limit($col, $from);
        $menu =  $this->db->get($table);
        return $menu->result();
    }    
    
    
    function getCnt($table, $type='', $lang='all')
    {
        $this->db->select('count(*) as cnt');
        $this->db->where('sleep','y');
        if(!empty($type)) $this->db->where('type', $type);
        if($lang!='no'&&$lang!='all')
        $this->db->where('lang',$lang);
        $result =  $this->db->get($table);
        $res =  $result->row();
        return $res->cnt;
    }     

 function getPublicBlock($table,$kol,$lang='all'){
        $this->db->where('sleepblock','y');
        $this->db->where('sleep', 'y');
        if($lang!='all'&&$lang!='no')
        	$this->db->where('lang',$lang);
        $this->db->select('*, date_format(date, \'%d.%m.%Y\') as dates',FALSE);
        $this->db->orderby('date', 'desc');
        $this->db->limit($kol);
        $result =  $this->db->get($table);
        //return  $result->row();
        return  $result->result();
        
    }
    
    
function  getPublicById($id,$table,$lang='all')
    {
        $this->db->where('id', $id);
        $this->db->where('sleep', 'y');
        if($lang!='no'&&$lang!='all')
        $this->db->where('lang',$lang);
        $this->db->select('*, date_format(date, \'%d.%m.%Y\') as dates',FALSE);
        $result =  $this->db->get($table);
        //print_r($result);
        return  $result->row();
    }  
     
function getNewsBlock($table,$kol,$lang='all'){
        $this->db->where('sleepblock','y');
        $this->db->where('anonsblock','n');
        $this->db->where('sleep', 'y');
        if($lang!='all'&&$lang!='no')
        $this->db->where('lang',$lang);
        $this->db->select('*, date_format(date, \'%d.%m.%Y\') as dates',FALSE);
        $this->db->orderby('date', 'desc');
        $this->db->limit($kol);
        $result =  $this->db->get($table);
        //return  $result->row();
        return  $result->result();
        
    }   
    
function getAnonsBlock($table,$kol,$lang='all'){
        $this->db->where('sleepblock','y');
        $this->db->where('anonsblock','y');
        $this->db->where('sleep', 'y');
        if($lang!='all'&&$lang!='no')
        $this->db->where('lang',$lang);
        $this->db->select('*, date_format(date, \'%d.%m.%Y\') as dates',FALSE);
        $this->db->orderby('date', 'desc');
        $this->db->limit($kol);
        $result =  $this->db->get($table);
        //return  $result->row();
        return  $result->result();
        
    }
    
function getAnyBlock($table,$kol,$lang='all'){
        $this->db->where('sleepblock','y');
        if($lang!='all'&&$lang!='no')
        	$this->db->where('lang',$lang);
        $this->db->orderby('id', 'desc');
        if(!empty($kol)) $this->db->limit($kol);
        $result =  $this->db->get($table);
        //return  $result->row();
        return  $result->result();
        
}   
 /*   
    
    
    function get_last_news($limit)
    {
        $query = $this->db->query("SELECT nwid, nwan, nwnp, nwcl, nwc2, DATE_FORMAT(nwpb, '%d') AS nwdd, DATE_FORMAT(nwpb, '%m') AS nwmm, DATE_FORMAT(nwpb, '%y') AS nwyy FROM rnnw WHERE nwsh='y' AND dl='n' ORDER BY nwpb DESC LIMIT ".$limit);
        return $query->result();
    }

    function get_last_news_week()
    {
        //$result = $this->db->query("SELECT nwid, nwan, nwnp, nwcl, nwc2, DATE_FORMAT(nwpb, '%d') AS nwdd, DATE_FORMAT(nwpb, '%m') AS nwmm, DATE_FORMAT(nwpb, '%y') AS nwyy FROM rnnw WHERE nwsh='y' AND dl='n' AND date_add(nwpb, INTERVAL 1 WEEK)>=NOW() ORDER BY nwpb DESC");
        
        $result = $this->db->query("SELECT id, title, anons, image_id, content, DATE_FORMAT(date_news, '%d') AS nwdd, DATE_FORMAT(date_news, '%m') AS nwmm, DATE_FORMAT(date_news, '%y') AS nwyy FROM news WHERE sleep='y' ORDER BY date_news DESC");
        return $result->result();
    }

  function get_last_news_date($y,$m,$d)
    {
        //$result = $this->db->query("SELECT nwid, nwan, nwnp, nwcl, nwc2, DATE_FORMAT(nwpb, '%d') AS nwdd, DATE_FORMAT(nwpb, '%m') AS nwmm, DATE_FORMAT(nwpb, '%y') AS nwyy FROM rnnw WHERE nwsh='y' AND dl='n' AND date_add(nwpb, INTERVAL 1 WEEK)>=NOW() ORDER BY nwpb DESC");
//                             AND nwyy='".$y."'
//                      AND nwmm='".$m."' 
//                      AND nwdd='".$d."' 

       //print $y;
        $result = $this->db->query("SELECT id, title, anons, image_id, content, 
                  DATE_FORMAT(date_news, '%d') AS nwdd, 
                  DATE_FORMAT(date_news, '%m') AS nwmm, 
                  DATE_FORMAT(date_news, '%y') AS nwyy 
                  FROM news 
                  WHERE sleep='y' 
                  AND date_news LIKE '%".$y."-".$m."-".$d."%'
                  ORDER BY date_news DESC");
      //  print_r($result->result());
        return $result;
    }
    
    
    
  
  
    
 function getNewsDate($col = 0, $from = 0, $y = '', $m = '', $d = '')
    {
        $this->db->orderby('date_news', 'desc');
        $this->db->select('*, date_format(date_news, \'%d.%m.%Y\') as date');
                   $str=$y."-".$m;
        if($d!='') 
            $str.="-".$d;
            $this->db->like('date_news',$str);
        // if set count, then set limit
        if ($col != 0)   $this->db->limit($col, $from);
        $menu =  $this->db->get('news');
        if($menu->num_rows()>0) return $menu->result();
        else                    return false;   
    }
    
   

    
    
    
    
    
    
    
    
    

    function get_cal($p)
    {
        if ($p[1]=='last' || $p[1]=='')
        $yyyy=date("Y");
        else
        $yyyy=$p[1];

        if ($p[2]=='last' || $p[2]=='')
        $mm=date("m");
        else
        $mm=$p[2];

        $res['yyyy'] = $yyyy;

        if ($p[3] != '')
        {
            $query = $this->db->query("SELECT COUNT(nwpb) AS ctyprev FROM rnnw WHERE DATE_FORMAT('".($yyyy-1)."-".$mm."-01', '%Y')=DATE_FORMAT(nwpb, '%Y') AND nwc2='".$p[3]."'");
        }
        else
        {
            $query = $this->db->query("SELECT COUNT(nwpb) AS ctyprev FROM rnnw WHERE DATE_FORMAT('".($yyyy-1)."-".$mm."-01', '%Y')=DATE_FORMAT(nwpb, '%Y')");
        }
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $res['ctyprev'] = $row->ctyprev;
        }


        if ($p[3] != '')
        {
            $query = $this->db->query("SELECT COUNT(nwpb) AS ctynewxt FROM rnnw WHERE DATE_FORMAT('".($yyyy+1)."-".$mm."-01', '%Y')=DATE_FORMAT(nwpb, '%Y') AND nwc2='".$p[3]."'");
        }
        else
        {
            $query = $this->db->query("SELECT COUNT(nwpb) AS ctynewxt FROM rnnw WHERE DATE_FORMAT('".($yyyy+1)."-".$mm."-01', '%Y')=DATE_FORMAT(nwpb, '%Y')");
        }
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $res['ctynewxt'] = $row->ctynewxt;
        }

        for ($i=1; $i <= 12; $i++)
        {
            if ($p[3] != '')
            {
                $query = $this->db->query("SELECT COUNT(nwpb) AS ctm FROM rnnw WHERE DATE_FORMAT('".$yyyy."-".$i."-01', '%Y%m')=DATE_FORMAT(nwpb, '%Y%m') AND nwc2='".$p[3]."'");
            }
            else
            {
                $query = $this->db->query("SELECT COUNT(nwpb) AS ctm FROM rnnw WHERE DATE_FORMAT('".$yyyy."-".$i."-01', '%Y%m')=DATE_FORMAT(nwpb, '%Y%m')");
            }
            if ($query->num_rows() > 0)
            {
                $row = $query->row();

                $ctm[$i] = $row->ctm;
            }
        }
        $res['ctm'] = $ctm;

        return $res;
    }

    function get_np_cal($p)
    {
        if ($p[2]=='last' || $p[2]=='')
        $yyyy=date("Y");
        else
        $yyyy=$p[2];

        if ($p[3]=='last' || $p[3]=='')
        $mm=date("m");
        else
        $mm=$p[3];

        $res['yyyy'] = $yyyy;
        $res['mm'] = $mm;

        $query = $this->db->query("SELECT COUNT(agdt) AS ctyprev FROM rnag, rnnp WHERE DATE_FORMAT('".($yyyy-1)."-".$mm."-01', '%Y')=DATE_FORMAT(agdt, '%Y') AND npnb=agid");
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $res['ctyprev'] = $row->ctyprev;
        }


        $query = $this->db->query("SELECT COUNT(agdt) AS ctynewxt FROM rnag, rnnp WHERE DATE_FORMAT('".($yyyy+1)."-".$mm."-01', '%Y')=DATE_FORMAT(agdt, '%Y') AND npnb=agid");
        if ($query->num_rows() > 0)
        {
            $row = $query->row();

            $res['ctynewxt'] = $row->ctynewxt;
        }

        for ($i=1; $i<=12; $i++)
        {
            $query = $this->db->query("SELECT COUNT(agdt) AS ctm FROM rnag, rnnp WHERE DATE_FORMAT('".$yyyy."-".$i."-01', '%Y%m')=DATE_FORMAT(agdt, '%Y%m') AND npnb=agid");
            if ($query->num_rows() > 0)
            {
                $row = $query->row();

                $ctm[$i] = $row->ctm;
            }
        }

        $res['ctm'] = $ctm;

        return $res;
    }
*/
 
 
 
}

?>
