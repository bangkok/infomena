<script type="text/javascript" language="JavaScript"> 
/*<![CDATA[*/
//<!--
var ajaxDoing = false; // true if ajax requesting
var ajaxDebug = true;
var ajaxController = 'ajax'; // CI controller name
var ajaxMethod = null; // form, script, xml, null - AUTO
var ajaxTimeout = 60; // timeout sec
var ajaxQueue = new Array(); // Queue requests. Used if sync
var ajaxSync = false; // synchron / asynchron load queue // FIX

/** HTML block loader
* block - id block to output result & info about processing 
* method - php method
* param - php method param
* directLink - link for error. If '' - do not out
* arguments[4] - call back func
* arguments[5] - load info. If null or '' - do not out
* arguments[6] - timeout. If null or 0 get global
* arguments[7] - loader method. If null or '' set AUTO 
* arguments[8] - alternative block ID for loading information
* arguments[9]
* arguments[10]
*/
function doLoadH(block, method, param, directLink)
{   //alert(param);
	loadInfo = '<img src="/img/design/loader.gif">';
	
	timeout = ajaxTimeout;
	loadMethod = ajaxMethod;
	ajaxInfoBlock = block;
	callback = null;

	if (arguments[4] != null && arguments[4] != '') callback = arguments[4];
	if (arguments[5] != null && arguments[5] != '') loadInfo = arguments[5];
	if (arguments[6] != null && arguments[6] != 0) 	timeout = arguments[6];
	if (arguments[7] != null && arguments[7] != '') loadMethod = arguments[7];
	if (arguments[8] != null && arguments[8] != '') ajaxInfoBlock = arguments[8];
	setTimeout(function() { loader(block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock) }, 0);
	  
}

function loader(block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock)
{  
	var req = new JsHttpRequest();
	timerID = setTimeout(function() { loadTimeOutH( block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock)}, timeout * 1000);
	req.onreadystatechange = function()
	{
		if (req.readyState == 4)
		{   // alert(req.responseJS.HTML);
			if (req.responseJS.HTML != null)
			{//alert(req.responseJS.HTML);  
				// Write result to page element ($_RESULT become responseJS).
				$('#' + block).html(req.responseJS.HTML);
				if (callback != null)
				{
					eval(callback)(req.responseJS, block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock);
				}
			}
//			$('#' + ajaxInfoBlock).append().html("<div style=\"border: dashed 1px red\">" + req.status + "</div>");
            
			if (ajaxDebug && req.responseText != "")
			{
				// Write debug information too.
				
				$('#' + ajaxInfoBlock).append().html("<div style=\"border: dashed 0px red\">" + req.responseText + "</div>");
			}
			ajaxDoing = false; // for sync
			clearTimeout(timerID);
		}
	}
	// Allow caching (to avoid different server queries for 
	// identical input data). Caching is always disabled if
	// we are uploading a file.
	req.caching = false;
	// Prepare request object (automatically choose GET or POST).
	
	req.open(loadMethod, '<?=base_url()?>' + ajaxController, true);
	// Send data to backend.
	req.send( {'method': method, 'param':  param} );
	
	if (loadInfo != '')
		$('#' + ajaxInfoBlock).html(loadInfo);	
		 
}

function loadTimeOutH(block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock)
{   
	if (directLink != '')
		$('#' + ajaxInfoBlock).html("Error load by timeout! <a href=\"#\" onclick=\"doLoadH('" + block + "','" + method + "','" + param + "', '" + directLink + "', '" + callback + "', '" + loadInfo + "', " + timeout + ", '" + loadMethod + "', '" + ajaxInfoBlock + "');return false;\">Reload.</a> <a href=\"" + directLink + "\">Direct link</a>");
	if (callback != null)
	{
		eval(callback)(req.responseJS, block, method, param, directLink, callback, loadInfo, timeout, loadMethod, ajaxInfoBlock);
	}		
	 
}

//-->
/*]]>*/
</script> 
