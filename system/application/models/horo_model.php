<?
class Horo_model extends Model 
{ 
  function Horo_model()  {   parent::Model();   
  
		$this->data['Horo']['defoult_settings'] = array(
        				'enabled' =>	'n',	
        				'ARIES' =>	'n', 
					'TAURUS' =>	'n', 
					'GEMINI' =>	'n', 
					'CANCER' =>	'n', 
					'LEO' =>	'n', 
					'VIRGO' =>	'n', 
					'LIBRA' =>	'n', 
					'SCORPIO' =>	'n', 
					'SAGITTARIUS'=>	'n', 
					'CAPRICORN' =>	'n', 
					'AQUARIUS' =>	'n', 
					'PISCES' =>	'n'
				);
  
  
  }
   

  function download_horo($file, $lang='no'){
		
		if(!$xml = @implode("", file($file))) 
	  return false;

		$xml_parser = xml_parser_create();
		xml_parse_into_struct($xml_parser,$xml,$vals,$index);
		xml_parser_free($xml_parser);

		//$horo['date'] =  $vals[$index['DATE'][0]]['attributes']['TODAY'];
		$horo['date'] = date('Y-m-d');
		$horo['lang'] = $lang;
		foreach($index['TODAY'] as $i){
 			$horo[$vals[$i-1]['tag']] = trim($vals[$i]['value']);
		}
		
		$this->db->insert('horo', $horo);
		
	  return $horo;
	}
	
  function get_horo($date, $login='', $lang='no'){
		
		if($lang != 'no')
			$this->db->where('lang', $lang);
		$this->db->where('date', $date);		
		$query = $this->db->get('horo');
		$result = $query->row_array();
		if(!$result){		
			$file =  'http://img.ignio.com/r/export/utf/xml/daily/com.xml';
			$result = $this->download_horo($file);
			if(!$result) 
	  return false;
		}
		unset($result['id']);unset($result['date']);unset($result['lang']);
		
		if(!$login) 
	  return $result;
		if($settings = $this->get_user_settings($login)){
			foreach($result as $key => $str)
				if(!(isset($settings[$key]) && $settings[$key] == 'y'))
					unset($result[$key]);
		}else return false;
	  return $result;
	}
	
  function get_user_settings($login){
		
		$this->db->where('login', $login);		
		$query = $this->db->get('user_horo');
		$result = $query->row_array();
		unset($result['login']);
	  return $result;
	}
	
  function set_user_settings($login, $settings=''){
		
		$this->db->where('login', $login);		
		$query = $this->db->get('user_horo');
				
		if($query && $query->num_rows()){
			$this->db->where('login', $login);
			$this->db->update('user_horo', $settings);

		}else{
			$values = array_merge(array('login'=>$login), $settings);
			$this->db->insert('user_horo', $values);
		}
	}
	
  function send_horo_mail($login, $date=''){
	
		$message='';
		if(!$date) $date = date('Y-m-d');		
		if($horo = $this->get_horo($date, $login))
			foreach($horo as $key => $str)
				$message.= "\n".$this->lang->line($key)."\n".$str."\n";
				
		if(!empty($message)){
			$user = $this->auth_model->getUser($login);
			$message = "Здравствуйте, ".$user->name.".\nВаш гороскоп на ".$date.":\n".$message;
			$name= $_SERVER['HTTP_HOST']." | Horoscope";
	  return $this->config_model->sendMsg($name, $user->email, $message);
		}
	  return false;	
	}
	
  function send_horo_mail_all_users($date=''){
		if(!$date) $date = date('Y-m-d');
		
		$this->db->select('login');
		$this->db->where('enabled', 'y');
		$query = $this->db->get('user_horo');
		$result = $query->result_array();

		$res=true;
		foreach($result as $user)
			$res = $res && $this->send_horo_mail($user['login'], $date);
	  return $res;
	}
	

}    

?>