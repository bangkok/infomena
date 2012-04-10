<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get image from DB and resize if need.
 * Other files output as is.
 *
 * @param unknown_type $t
 * @param unknown_type $f
 * @param unknown_type $id
 * @param unknown_type $x
 * @param unknown_type $y
 */
function create_image_resized($t, $f, $id, $x, $y, $contr)
{		
	$fs_dir = $_SERVER['DOCUMENT_ROOT'].'/admin/media/';
	$w_src = './img/wm.png';
	//$w_src = './img/design/pixel.gif';

	
	$CI =& get_instance();

	$i=0;
	$pri_key = '';
	$fields = $CI->db->field_data($t);
	foreach ($fields as $row)
	{
		if ($row->primary_key == 1)
		{
			if ($i == 0)
				$pri_key .= "`".$row->name."`='$id'";
			else
				$pri_key .= " AND `".$row->name."`='$id'";
			$i++;
		}
	}
	
	$query="SELECT * FROM `$t` WHERE $pri_key";
	$res = mysql_query($query);
	
	if(mysql_num_rows($res) == 0)
	{
	    echo "Нет файла!";
	}
	else
	{
	    $row = mysql_fetch_array($res);
		{
			$fnm=$f."_fnm";
			$ext = substr($row[$fnm], strrpos($row[$fnm], ".")+1);
	
			//print strtoupper($ext);
			if (
				(function_exists("ImageJpeg") && (strtoupper($ext)=="JPEG" || strtoupper($ext)=="JPG"))
				|| (strtoupper($ext)=="PNG" && function_exists("ImagePNG"))
				|| (strtoupper($ext)=="GIF" && function_exists("ImageGIF"))
				|| (strtoupper($ext)=="WBMP" && function_exists("ImageWBMP"))
				)
			{

				if (($x != '' || $y != ''))				
				{
//					$image="http://".$_SERVER['HTTP_HOST']."/images/$id.jpg";
					$image = $fs_dir.$row['flid'];
					$size = getimagesize ($image);
				}
			}
			
			if (($x != '' || $y != '') && function_exists("imagecopyresized"))
			{
				if ($x != '' && !$y != '')
				{
					$xm=$x;
					$ym=round($xm*$size[1]/$size[0]);
				}
				elseif (!$x != '' && $y != '')
				{
					$ym=$y;
					$xm=round($ym*$size[0]/$size[1]);
				}
				elseif ($x != '' && $y != '') // by >
				{
//					var_dump($size);
					$xt = floor($y*$size[0]/$size[1]);
					$yt = floor($x*$size[1]/$size[0]);
					
					if ($xt > $x)
					{
						$xm = $x;
						$ym = floor($xm*$size[1]/$size[0]);
					}
					else
					{
						$ym = $y;
						$xm = floor($y*$size[0]/$size[1]);
					}
				}				
//				elseif ($x != '' && $y != '')
//				{
//					$xm=$x;
//					$ym=$y;
//				}				
				header("Content-disposition: filename=$row[$fnm]");
				
				if ((strtoupper($ext)=="JPEG" || strtoupper($ext)=="JPG") && function_exists("ImageJpeg"))
				{
					header("Content-type: image/jpeg");
					$im = ImageCreateFromJPEG ($image);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					
					// Resample
					$im_pr = imagecreatetruecolor($xm, $ym);
					@imagecopyresampled($im_pr, $im, 0, 0, 0, 0, $xm+1, $ym, $size[0], $size[1]);
					
//					watermark($im_pr, $xm, $ym, "ric.ua");				
/*				
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
					Header("Vary: Content-ID");
					Header("Content-ID: ".md5($row[$fnm].$size."-".$xm.$ym));
					if (!isset($row['flex']))
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
*/
						
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");
						
					ImageJpeg ($im_pr);
				}
				elseif (strtoupper($ext)=="PNG" && function_exists("ImagePNG"))
				{
					header("Content-type: image/png");
					$im = ImageCreateFromPNG ($image);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					
					$im_pr = imagecreatetruecolor($xm, $ym);
					@imagecopyresampled($im_pr, $im, 0, 0, 0, 0, $xm+1, $ym, $size[0], $size[1]);
					
//					watermark($im_pr, $xm, $ym, "ric.ua");
	
/*					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
					Header("Vary: Content-ID");
					Header("Content-ID: ".md5($row[$fnm].$size."-".$xm.$ym));
					if (!isset($row['flex']))
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
*/
						
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");
						
					ImagePNG ($im_pr);
				}
				elseif (strtoupper($ext)=="GIF" && function_exists("ImageGIF"))
				{
					header("Content-type: image/png");
					$im = ImageCreateFromGIF ($image);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					
					$im_pr = imagecreatetruecolor($xm, $ym);
					@imagecopyresampled($im_pr, $im, 0, 0, 0, 0, $xm+1, $ym, $size[0], $size[1]);
					
//					watermark($im_pr, $xm, $ym, "ric.ua");
/*	
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
					Header("Vary: Content-ID");
					Header("Content-ID: ".md5($row[$fnm].$size."-".$xm.$ym));
					if (!isset($row['flex']))
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
*/

 					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");
						
						
					ImageGIF ($im_pr);
				}
				elseif (strtoupper($ext)=="WBMP" && function_exists("ImageWBMP"))
				{
					header("Content-type: image/vnd.wap.wbmp");
					$im = ImageCreateFromWBMP ($image);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);

					$im_pr = imagecreatetruecolor($xm, $ym);
					@imagecopyresampled($im_pr, $im, 0, 0, 0, 0, $xm+1, $ym, $size[0], $size[1]);
					
//					watermark($im_pr, $xm, $ym, "ric.ua");
	
/*	
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
					Header("Vary: Content-ID");
					Header("Content-ID: ".md5($row[$fnm].$size."-".$xm.$ym));
					if (!isset($row['flex']))
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//*/

					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");

						
						
					ImageWBMP ($im_pr);
				}
				else
				{
					if ($x != '' && !$y != '')
					{
						$xm=$x;
						$ym=$xm;
					}
					elseif (!$x != '' && $y != '')
					{
						$ym=$y;
						$xm=$ym;
					}
					elseif ($x != '' && $y != '')
					{
						$xm=$x;
						$ym=$y;
					}
					$im_pr = ImageCreate ($xm, $ym) or die ("Cannot Initialize new GD image stream");
					
					$background_color = imagecolorallocate ($im_pr, 255, 255, 255);
					$text_color = imagecolorallocate ($im_pr, 14, 14, 233);
					imagestring ($im_pr, 2, 5, 1, $row[$fnm], $text_color);
					imagestring ($im_pr, 2, 5, 12, ".".$ext, $text_color);
	
					header("Content-type: image/png");
					/*
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
					Header("Vary: Content-ID");
					Header("Content-ID: ".md5($row[$fnm].$size."-".$xm.$ym));
					if (!isset($row['flex']))
						header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
					*/
					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");
                  	
					ImagePNG ($im_pr);
				}
	
			}
			else
			{
				header("Content-disposition: filename=$row[$fnm]");
				switch (strtoupper($ext)) 
				{
					case "JPEG":
						header("Content-type: image/jpeg");
						break;
					case "JPG":
						header("Content-type: image/jpeg");
						break;
					case "PNG":
						header("Content-type: image/png");
						break;
					case "GIF":
						header("Content-type: image/gif");
						break;
					case "WBMP":
						header("Content-type: image/vnd.wap.wbmp");
						break;
					default:
						header("Content-type: application/octetstream");
				}
	
				if (isset($row['flex']))
					Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
				else
					Header("Cache-Control: public, must-revalidate, max-age=0");
 				header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
 				header("Content-Length: ".filesize($fs_dir.$row['flid']));
 				$exp = date("r", mktime()+$row['flex']);
 				header("Expires: ".$exp);
 				header("Pragma: cache");

/*
				if (isset($row['flex']))
					Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
				else
					Header("Cache-Control: public, must-revalidate, max-age=0");
				Header("Vary: Content-ID");
				Header("Content-ID: ".md5($row[$fnm].$row['flim_siz']));
				if (!isset($row['flex']))
					header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//*/


				if ((strtoupper($ext)=="JPEG" || strtoupper($ext)=="JPG") && function_exists("ImageJpeg"))
				{
					$size = getimagesize ($fs_dir.$row['flid']);
					$im = ImageCreateFromJPEG ($fs_dir.$row['flid']);
					ImageJpeg ($im);
					///print strtoupper($ext);				
				}
				elseif (strtoupper($ext)=="PNG" && function_exists("ImagePNG"))
				{
					$size = getimagesize ($fs_dir.$row['flid']);
					$im = ImageCreateFromPNG ($fs_dir.$row['flid']);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					ImagePNG ($im);
				}
				elseif (strtoupper($ext)=="GIF" && function_exists("ImageGIF"))
				{
					$size = getimagesize ($fs_dir.$row['flid']);
					$im = ImageCreateFromGIF ($fs_dir.$row['flid']);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					ImageGIF ($im);
				}
				elseif (strtoupper($ext)=="WBMP" && function_exists("ImageWBMP"))
				{
					$size = getimagesize ($fs_dir.$row['flid']);
					$im = ImageCreateFromWBMP ($fs_dir.$row['flid']);
					//$im = water($im, $w_src, 15, $size[0], $size[1]);
					ImageWBMP ($im);
				}
				else
					echo fread(fopen($fs_dir.$row['flid'], "r"), filesize($fs_dir.$row['flid']));
			
    /* 	
  	header("Cache-Control: public, must-revalidate, max-age=3600");
		header('Last-Modified: '.date("r", filemtime($path.$fileName.".".$fileExt)));
		header("Content-Length: ".filesize($path.$fileName.".".$fileExt));
		$exp = date("r", filemtime($path.$fileName.".".$fileExt)+3600);
		header("Expires: ".$exp);
		header("Pragma: cache");
    //*/			

//				echo base64_decode($row["$f"]);
			}
		}
	}

//	return array('word' => $word, 'time' => $now, 'image' => $img);
}
/*
function water($src_im, $w_src, $opacity = 15, $w, $h)
{
	
	if ($w >= 150 && $h >= 150)
	{
	///	print"<br> ------- ".$w_src; 
	//	print"<br> ------- ".ImageCreateFromPNG($w_src); 
		//$w_src = ImageCreateFromPNG($w_src);
//		print"<br> ------- ".$w_src; 
		$im_pr = $w_src;
		
		
	//	$im_pr = imagecreatetruecolor($w, 43);
	//	@imagecopyresampled($im_pr, $w_src, 0, 0, 0, 0, $w+1, 43, 360, 43);
	//	imagecopyresized  ( $im_pr  , $w_src  , 
	//	0  , 0  , 
	//	0  , 0  , 
	//	$w  , 43  , 
	//	360  , 43  );
	//	$im_pr = imagerotate  ( $w_src , 45  , 0 );
		
		$xoff = round( ($w / 2) - 75 );
		$yoff = round( ($h / 2) - 75 );
		/*
		imagecopymerge(
			$src_im, 
			$im_pr, 
			$xoff, $yoff, 
			0, 0, 
			150, 150, 
			$opacity);
			* /
	}
	     
	return $src_im;
}
*/


/**
 * Get image/file from DB and output to stream
 * Without any changes!
 *
 * @param unknown_type $t
 * @param unknown_type $f
 * @param unknown_type $id
 */
function create_image_clean($t, $f, $id)
{		
	$fs_dir = $_SERVER['DOCUMENT_ROOT'].'/adm/media/';

	$CI =& get_instance();

	$i=0;
	$pri_key = '';
	$fields = $CI->db->field_data($t);
	foreach ($fields as $row)
	{
		if ($row->primary_key == 1)
		{
			if ($i == 0)
				$pri_key .= "`".$row->name."`='$id'";
			else
				$pri_key .= " AND `".$row->name."`='$id'";
			$i++;
		}
	}
	
	$query="SELECT * FROM `$t` WHERE $pri_key";
	$res = mysql_query($query);
	
	if(mysql_num_rows($res) == 0)
	{
	    echo "��� �����!";
	}
	else
	{
	    $row = mysql_fetch_array($res);
		{
			$fnm=$f."_fnm";
			$ext = substr($row[$fnm], strrpos($row[$fnm], ".")+1);
	
			header("Content-disposition: filename=$row[$fnm]");
			switch (strtoupper($ext)) 
			{
				case "JPEG":
					header("Content-type: image/jpeg");
					break;
				case "JPG":
					header("Content-type: image/jpeg");
					break;
				case "PNG":
					header("Content-type: image/png");
					break;
				case "GIF":
					header("Content-type: image/gif");
					break;
				case "WBMP":
					header("Content-type: image/vnd.wap.wbmp");
					break;
				default:
					header("Content-type: application/octetstream");
			}

					if (isset($row['flex']))
						Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
					else
						Header("Cache-Control: public, must-revalidate, max-age=0");
          header('Last-Modified: '.date("r", filemtime($fs_dir.$row['flid'])));
          header("Content-Length: ".filesize($fs_dir.$row['flid']));
          $exp = date("r", mktime()+$row['flex']);
          header("Expires: ".$exp);
          header("Pragma: cache");		
/*
			if (isset($row['flex']))
				Header("Cache-Control: public, must-revalidate, max-age=".$row['flex']);
			else
				Header("Cache-Control: public, must-revalidate, max-age=0");
			Header("Vary: Content-ID");
			Header("Content-ID: ".md5($row[$fnm].$row['flim_siz']));
			if (!isset($row['flex']))
				header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//*/			
				
			$fs_dir = $_SERVER['DOCUMENT_ROOT'].'/adm/media/';
			echo fread(fopen($fs_dir.$row['flid'], "r"), filesize($fs_dir.$row['flid']));				
				
//			echo base64_decode($row["$f"]);
		}
	}
}

/**
 * FIXME!!!
 *
 * @param unknown_type $im_pr
 * @param unknown_type $xm
 * @param unknown_type $ym
 * @param unknown_type $text
 */
function _watermark($im_pr, $xm, $ym, $text)
{
	global $HTTP_HOST;
	
	if ($xm > 99)
	{
		$white = ImageColorAllocate($im_pr, 255, 255, 255);
		$red = ImageColorAllocate($im_pr, 33, 33, 155);
		if ($HTTP_HOST == 'realnest.loc')
		{
			$fontname = 'D:/vhosts/ric/PHP/img/micross.ttf';
		}
		else
		{
			$fontname = '/var/www/vhosts/ric/htdocs/img/micross.ttf';
		}
		$size = 10;				
		@list($llx, $lly, $lrx, $lry, $urx, $ury, $ulx, $uly) = imageTTFbbox($size, 0, $fontname, $text);

		imagettftext(
			$im_pr,
			$size,
			0, 
			$xm - abs($urx) - 8,
			$ym - abs($lry) - 7,
			$white,
			$fontname,
			$text);
		imagettftext(
			$im_pr,
			$size,
			0, 
			$xm - abs($urx) - 7,
			$ym - abs($lry) - 8,
			$white,
			$fontname,
			$text);
		imagettftext(
			$im_pr,
			$size,
			0, 
			$xm - abs($urx) - 9,
			$ym - abs($lry) - 8,
			$white,
			$fontname,
			$text);
		imagettftext(
			$im_pr,
			$size,
			0, 
			$xm - abs($urx) - 8,
			$ym - abs($lry) - 9,
			$white,
			$fontname,
			$text);
		imagettftext(
			$im_pr,
			$size,
			0, 
			$xm - abs($urx) - 8,
			$ym - abs($lry) - 8,
			$red,
			$fontname,
			$text);
	}
}

// ����� ������ �� ������
//class ImageText
//{
//    public $text;
//    public $image;
//    public $view_line = false;
//
//    public function toPolyline($coordinates)
//    {
//        $coordinates = unserialize($coordinates);
//
//        $nFont = 5;
//        $x = 500;
//        $y = 500;
//
//        $xFont = imagefontwidth($nFont);
//        $yFont = imagefontheight($nFont);
//        $imgChar = imagecreatetruecolor($xFont, $yFont);
//        $img = imagecreatetruecolor($x,$y);
//
//        $colBG = imagecolorallocate($img, 255, 255, 255);
//        $colBGchar = imagecolorallocate($imgChar, 255, 255, 255);
//        $colFGchar = imagecolorallocate($imgChar, 0, 0, 0);
//
//        imagefilledrectangle($img, 0, 0, $x, $y, $colBG);
//
//        $length = count($coordinates);
//        $length--;
//        for ($i = 0; $i < $length; $i++)
//        {
//            $X1 = $coordinates[$i][0];
//            $Y1 = $coordinates[$i][1];
//
//            $X2 = $coordinates[$i+1][0];
//            $Y2 = $coordinates[$i+1][1];
//
//            $length_segment = floor(sqrt(abs($X1 - $X2) * abs($X1 - $X2) + abs($Y1 - $Y2) * abs($Y1 - $Y2)));
//
//            $count_char = $length_segment / $xFont;
//            if ($count_char < 1)
//            {
//                continue;
//            }
//            else
//            {
//                $count_char = floor($count_char);
//            };
//
//            $imgChar = imagecreatetruecolor($xFont*$count_char, $yFont);
//
//            $alfaRad = atan(abs(($Y1 - $Y2)/($X1 - $X2)));
//            if ($Y1 > $Y2)
//            {
//                $alfaRad = - $alfaRad;
//            };
//            $alfaDeg = rad2deg($alfaRad);
//
//            if ($this->text == '') {break;};
//            $sub_text = substr($this->text,0,$count_char);
//            $this->text = substr_replace($this->text,'',0,$count_char);
//
//            imagefilledrectangle($imgChar, 0, 0, $xFont*$count_char, $yFont, $colBGchar);
//            imagestring($imgChar, $nFont, 0, 0, $sub_text, $colFGchar);
//
//            $imgTemp = imagerotate($imgChar,-$alfaDeg,$colBGchar);
//            $xTemp = imagesx($imgTemp);
//            $yTemp = imagesy($imgTemp);
//
//            $xBase = $X1 + cos($alfaRad) * $xFont;
//            $yBase = $Y1 + sin($alfaRad) * $xFont;
//
//            $Xn = $xBase;
//            $Yn = $yBase - cos($alfaRad)*$yFont;
//
//            imagecopy($img, $imgTemp,$Xn,$Yn,0,0,$xTemp, $yTemp);
//
//            if ($this->view_line)
//            {
//                imageline($img,$X1,$Y1,$X2,$Y2,$colFGchar);
//            };
//        };
//        $this->image = $img;
//        return true;
//    }
//};
//
//$img = new ImageText();
//$arr = Array (
//    Array(0,100),
//    Array(100,120),
//    Array(200,130),
//    Array(500,180)
//);
//
//$arr = 'a:4:{i:0;a:2:{i:0;i:0;i:1;i:100;}i:1;a:2:{i:0;i:100;i:1;i:120;}i:2;a:2:{i:0;i:200;i:1;i:130;}i:3;a:2:{i:0;i:500;i:1;i:180;}}';
//if (isset($_GET['arr']))
//{
//    $arr = $_GET['arr'];
//};
//
//$img->text = 'Text to polyline. Text to polyline. Text to polyline. Text to polyline.';
//$img->view_line = true;
//$img -> toPolyline($arr);
//
//header("Content-type: image/jpeg");
//imagejpeg($img->image);


?>
