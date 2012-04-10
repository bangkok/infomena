<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');


class MY_Router extends CI_Router 
{
	var $add = array();
	var $start_level = 1;

	function MY_Router()
	{
		//parent::CI_Router();

		$this->config =& load_class('Config');
		$this->uri =& load_class('URI');
		$this->add = $this->getAdditionRoute();
		$this->_set_routing();
		log_message('debug', "Router Class Initialized");
	}

	/*
	 *  Merget $route with $this->add
	 */
	function _set_routing()
	{		
		// Are query strings enabled in the config file?
		// If so, we're done since segment based URIs are not used with query strings.
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
			}
			
			return;
		}
		
		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);
		
		$this->routes = array_merge($this->routes, $this->add);

		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);	
		
		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();
	
		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			if ($this->default_controller === FALSE)
			{
				show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
			}
		
			$this->set_class($this->default_controller);
			$this->set_method('index');
			$this->_set_request(array($this->default_controller, 'index'));
			
			// re-index the routed segments array so it starts with 1 rather than 0
			$this->uri->_reindex_segments();
			
			log_message('debug', "No URI present. Default controller set.");
			return;
		}
		unset($this->routes['default_controller']);
		
		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();
		
		// Compile the segments into an array
		$this->uri->_explode_segments();
		
		// Parse any custom routing that may exist
		$this->_parse_routes();		
		
		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();
	}
		
	/**
	 * Additional route rules from site map table.
	 *
	 * @return Array
	 */
	function getAdditionRoute()
	{
		$p = 'p'; // separator parameter string
		$def = 'main'; // default controller-template
		$max_deep_level = 3; // maximum deep level for calculate controller-template
		$template = 'main';
		
		require_once(BASEPATH.'database/DB'.EXT);
		$mdb = DB('', FALSE);

		if (!isset($mdb)) return array();
		
		// get template for link (link -> to controller)
		$cnt = 0; // parameter level
		$id = 1;
		
//		phpinfo();
		
		$uri = $_SERVER["REQUEST_URI"];//$this->_get_uri_string();
		
//		var_dump($uri);
//------------ убираем язык ------
//$this->load->helper('url');
        //   print_r($this->uri);
       $query = $mdb->query("SELECT COUNT(*) FROM lang");
       
		if($query)
		{
			$query = $mdb->get('lang');
			if ($query->num_rows()>0)
                   {foreach ($query->result() as $l):
                      if(stristr($_SERVER["REQUEST_URI"], "/".$l->lang)) 
                      {
                      	 //$uri=strstr($_SERVER["REQUEST_URI"],"/".$l->lang);
                      	 $uri=preg_replace("/\/".$l->lang."/","",$_SERVER["REQUEST_URI"]);
                      	 
                      	 //print"<br> ----- ".$_SERVER["REQUEST_URI"];
                      	 //print"<br> ----- ".$l->lang;
                      	 //print"<br> ----- ".$uri;
                      	 //print_r(preg_replace("/\/".$l->lang."/","",$_SERVER["REQUEST_URI"]));
                      }
                    endforeach;
                   }
                   
			if($uri == '') $uri = '/';
			//print"<br> ----- ".$uri;
		}
		//print_r($uri);
//------------

//		if ($uri == 'JsHttpRequest') // ajax library
//		{
//			$route['JsHttpRequest'] = 'ajax';
//			return $route;
//		}
		if ($uri == '/') $uri = '/'.$def.'/';
		$uri = trim($uri, "/");
		$uri = explode("/", $uri);
//print_r($uri);
		$query = $mdb->query('SELECT COUNT(*) FROM map');
		if(!$query)
		{
			return array('.*' => "/error/index");
		}
		//print_r($uri);
		for ($i = 0; $i < count($uri); $i++)
		{
			if ($uri[$i] == $p) // more levels is parameters
			{
				break;
			}
			if ($i < $max_deep_level && $uri[$i] !== FALSE)
			{
			    $val = $uri[$i];
			    
				//if ($i == 0&&)
					//$query = $mdb->getwhere('map', array('link' => '/', 'upId' => 1, 'visible' => 'y'));
				//else
				if($val=='main') $val='/';
					//$query = $mdb->getwhere('map', array('link' => $val, 'upId' => $id, 'visible' => 'y'));
					$query = $mdb->getwhere('map', array('link' => $val, 'upId' => $id, 'sitemap' => 'y'));
					//print_r($mdb->getwhere('map'));
					//print"<br>11 ----- ".$query;
					
				if($query)
					$result = $query->result();
					//print_r($query);
				//	print"<br>val ----- ".$val;
				//	print"<br>id ----- ".$id;
					
					
					//print_r($result);
				if (isset($result) && is_array($result) && count($result) > 0)
				{
					$cnt++;
					if ($result[0]->resource != "")
					{
						$template = $result[0]->resource;
						$id = $result[0]->id;
					}
					else // default for not founded into DB 
					{
						$template = 'main';
						
						if ($result[0]->id != '')
							$id = $result[0]->id;
						else
							$id = 0;
					}
				}
				else // more levels is parameters
				{
					break;
				}
			}
		}		
		
		//print"<br> ----- ".$template;
		// 
		$uri = $_SERVER["REQUEST_URI"];//$this->_get_uri_string();
		$route = array();
		
		if ($uri == '/') $uri = '/'.$def.'/';
		$uri = trim($uri, "/");
		$uri = explode("/", $uri);
				
		$regex = $uri[0];
		for ($i = 1; $i < $cnt; $i++)
		{
			$regex .= "/".$uri[$i];
		}
		$this->start_level = $cnt;
		
		if ($regex != $template)
		{
			if ($cnt < count($uri))
				$route[$regex.'/(.*)'] = $template."/$1";
			 
			else 
				$route[$regex] = $template;
				
			//var_dump($route);
//print_r($route);
		}

//		$mdb = null;
//var_dump($route);
		
		return $route;
	}
	
}

?>