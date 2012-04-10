<?
/*
############################################################
IMG_RESIZE - GD webi.ru
Для работы требуется библиотека GD

Функции для пропорционального изменения размера рисунков.
Данная функция обрабатывает JPG, GIF, PNG и BMP, на выходе всегда получается JPG.
Отличительная особенность этой библиотечки является в том, что она умеет обрабатывать картинки формата BMP.
На момент созднания этой функции GD не умела работать с рисунками BMP, не путайте пожалуйста с WBMP.

Кто является создателем функции обработки BMP выяснить не удалось.
К остальным частям функции приложили свои руки многие программисты, в том числе и я (webi.ru), улучшил и упростил использование.
Пример использования :

include("img_resize.php");
img_resize("1.jpg", "2.jpg", 150, 200,  70, 0xFFFFF0, 0);

// открывает картинку 1.jpg и сохраняет ее с новыми размерами в 2.jpg
// 150, 200 ширина и высота новой картинки
// 70 качество нового изображения в процентах
// 0xFFFFF0 цвет фона(если рисунок полуится меньше)
// 0 включить/выключить создание размера изображения, строго по размерам, Если включить, тогда размер изображения всегда будет
таким, как заявлен, а лишнее будет заполняться фоном. Экспериментируйте. 


############################################################
*/


function imagebmp($img,$file="",$RLE=0)
{
	$ColorCount=imagecolorstotal($img);
	$Transparent=imagecolortransparent($img);
	$IsTransparent=$Transparent!=-1;
	if($IsTransparent) $ColorCount--;
	if($ColorCount==0) {$ColorCount=0; $BitCount=24;};
	if(($ColorCount>0)and($ColorCount<=2)) {$ColorCount=2; $BitCount=1;};
	if(($ColorCount>2)and($ColorCount<=16)) { $ColorCount=16; $BitCount=4;};
	if(($ColorCount>16)and($ColorCount<=256)) { $ColorCount=0; $BitCount=8;};
	$Width=imagesx($img);
	$Height=imagesy($img);
	$Zbytek=(4-($Width/(8/$BitCount))%4)%4;
	if($BitCount<24) $palsize=pow(2,$BitCount)*4;
	$size=(floor($Width/(8/$BitCount))+$Zbytek)*$Height+54;
	$size+=$palsize;
	$offset=54+$palsize;
	$ret = 'BM';                      
	$ret .= int_to_dword($size);    
	$ret .= int_to_dword(0);       
	$ret .= int_to_dword($offset);     
	$ret .= int_to_dword(40);       
	$ret .= int_to_dword($Width);       
	$ret .= int_to_dword($Height);       
	$ret .= int_to_word(1);       
	$ret .= int_to_word($BitCount);      
	$ret .= int_to_dword($RLE);       
	$ret .= int_to_dword(0);       
	$ret .= int_to_dword(0);       
	$ret .= int_to_dword(0);       
	$ret .= int_to_dword(0);       
	$ret .= int_to_dword(0);       
	$CC=$ColorCount;
	$sl1=strlen($ret);
	if($CC==0) $CC=256;
	if($BitCount<24)
	{
		$ColorTotal=imagecolorstotal($img);
		if($IsTransparent) $ColorTotal--;
		for($p=0;$p<$ColorTotal;$p++)
		{
			$color=imagecolorsforindex($img,$p);
			$ret.=inttobyte($color["blue"]);
			$ret.=inttobyte($color["green"]);
			$ret.=inttobyte($color["red"]);
			$ret.=inttobyte(0); 
		};
		$CT=$ColorTotal;
		for($p=$ColorTotal;$p<$CC;$p++)
		{
			$ret.=inttobyte(0);
			$ret.=inttobyte(0);
			$ret.=inttobyte(0);
			$ret.=inttobyte(0); 
		};
	};
	if($BitCount<=8)
	{
		for($y=$Height-1;$y>=0;$y--)
		{
			$bWrite="";
			for($x=0;$x<$Width;$x++)
			{
				$color=imagecolorat($img,$x,$y);
				$bWrite.=decbinx($color,$BitCount);
				if(strlen($bWrite)==8)
				{
					$retd.=inttobyte(bindec($bWrite));
					$bWrite="";
				};
			};
			if((strlen($bWrite)<8)and(strlen($bWrite)!=0))
			{
				$sl=strlen($bWrite);
				for($t=0;$t<8-$sl;$t++)
				$sl.="0";
				$retd.=inttobyte(bindec($bWrite));
			};
			for($z=0;$z<$Zbytek;$z++)
			$retd.=inttobyte(0);
		};
	};
	if(($RLE==1)and($BitCount==8))
	{
		for($t=0;$t<strlen($retd);$t+=4)
		{
			if($t!=0)
			if(($t)%$Width==0)
			$ret.=chr(0).chr(0);

			if(($t+5)%$Width==0)
			{
				$ret.=chr(0).chr(5).substr($retd,$t,5).chr(0);
				$t+=1;
			}
			if(($t+6)%$Width==0)
			{
				$ret.=chr(0).chr(6).substr($retd,$t,6);
				$t+=2;
			}
			else
			{
				$ret.=chr(0).chr(4).substr($retd,$t,4);
			};
		};
		$ret.=chr(0).chr(1);
	}
	else
	{
		$ret.=$retd;
	};
	if($BitCount==24)
	{
		for($z=0;$z<$Zbytek;$z++)
		$Dopl.=chr(0);

		for($y=$Height-1;$y>=0;$y--)
		{
			for($x=0;$x<$Width;$x++)
			{
				$color=imagecolorsforindex($img,ImageColorAt($img,$x,$y));
				$ret.=chr($color["blue"]).chr($color["green"]).chr($color["red"]);
			}
			$ret.=$Dopl;
		};

	};
	if($file!="")
	{
		$r=($f=fopen($file,"w"));
		$r=$r and fwrite($f,$ret);
		$r=$r and fclose($f);
		return $r;
	}
	else
	{
		echo $ret;
	};
};
function imagecreatefrombmp($file)
{
	global  $CurrentBit, $echoMode;

	$f=fopen($file,"r");
	$Header=fread($f,2);

	if($Header=="BM")
	{
		$Size=freaddword($f);
		$Reserved1=freadword($f);
		$Reserved2=freadword($f);
		$FirstByteOfImage=freaddword($f);

		$SizeBITMAPINFOHEADER=freaddword($f);
		$Width=freaddword($f);
		$Height=freaddword($f);
		$biPlanes=freadword($f);
		$biBitCount=freadword($f);
		$RLECompression=freaddword($f);
		$WidthxHeight=freaddword($f);
		$biXPelsPerMeter=freaddword($f);
		$biYPelsPerMeter=freaddword($f);
		$NumberOfPalettesUsed=freaddword($f);
		$NumberOfImportantColors=freaddword($f);

		if($biBitCount<24)
		{
			$img=imagecreate($Width,$Height);
			$Colors=pow(2,$biBitCount);
			for($p=0;$p<$Colors;$p++)
			{
				$B=freadbyte($f);
				$G=freadbyte($f);
				$R=freadbyte($f);
				$Reserved=freadbyte($f);
				$Palette[]=imagecolorallocate($img,$R,$G,$B);
			};
			if($RLECompression==0)
			{
				$Zbytek=(4-ceil(($Width/(8/$biBitCount)))%4)%4;

				for($y=$Height-1;$y>=0;$y--)
				{
					$CurrentBit=0;
					for($x=0;$x<$Width;$x++)
					{
						$C=freadbits($f,$biBitCount);
						imagesetpixel($img,$x,$y,$Palette[$C]);
					};
					if($CurrentBit!=0) {freadbyte($f);};
					for($g=0;$g<$Zbytek;$g++)
					freadbyte($f);
				};

			};
		};


		if($RLECompression==1) 
		{
			$y=$Height;

			$pocetb=0;

			while(true)
			{
				$y--;
				$prefix=freadbyte($f);
				$suffix=freadbyte($f);
				$pocetb+=2;

				$echoit=false;

				if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
				if(($prefix==0)and($suffix==1)) break;
				if(feof($f)) break;

				while(!(($prefix==0)and($suffix==0)))
				{
					if($prefix==0)
					{
						$pocet=$suffix;
						$Data.=fread($f,$pocet);
						$pocetb+=$pocet;
						if($pocetb%2==1) {freadbyte($f); $pocetb++;};
					};
					if($prefix>0)
					{
						$pocet=$prefix;
						for($r=0;$r<$pocet;$r++)
						$Data.=chr($suffix);
					};
					$prefix=freadbyte($f);
					$suffix=freadbyte($f);
					$pocetb+=2;
					if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
				};

				for($x=0;$x<strlen($Data);$x++)
				{
					imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
				};
				$Data="";

			};

		};


		if($RLECompression==2) 
		{
			$y=$Height;
			$pocetb=0;


			while(true)
			{
				
				$y--;
				$prefix=freadbyte($f);
				$suffix=freadbyte($f);
				$pocetb+=2;

				$echoit=false;

				if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
				if(($prefix==0)and($suffix==1)) break;
				if(feof($f)) break;

				while(!(($prefix==0)and($suffix==0)))
				{
					if($prefix==0)
					{
						$pocet=$suffix;

						$CurrentBit=0;
						for($h=0;$h<$pocet;$h++)
						$Data.=chr(freadbits($f,4));
						if($CurrentBit!=0) freadbits($f,4);
						$pocetb+=ceil(($pocet/2));
						if($pocetb%2==1) {freadbyte($f); $pocetb++;};
					};
					if($prefix>0)
					{
						$pocet=$prefix;
						$i=0;
						for($r=0;$r<$pocet;$r++)
						{
							if($i%2==0)
							{
								$Data.=chr($suffix%16);
							}
							else
							{
								$Data.=chr(floor($suffix/16));
							};
							$i++;
						};
					};
					$prefix=freadbyte($f);
					$suffix=freadbyte($f);
					$pocetb+=2;
					if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
				};

				for($x=0;$x<strlen($Data);$x++)
				{
					imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
				};
				$Data="";

			};

		};


		if($biBitCount==24)
		{
			$img=imagecreatetruecolor($Width,$Height);
			$Zbytek=$Width%4;

			for($y=$Height-1;$y>=0;$y--)
			{
				for($x=0;$x<$Width;$x++)
				{
					$B=freadbyte($f);
					$G=freadbyte($f);
					$R=freadbyte($f);
					$color=imagecolorexact($img,$R,$G,$B);
					if($color==-1) $color=imagecolorallocate($img,$R,$G,$B);
					imagesetpixel($img,$x,$y,$color);
				}
				for($z=0;$z<$Zbytek;$z++)
				freadbyte($f);
			};
		};
		return $img;

	};


	fclose($f);


};

function freadbyte($f)
{
	return ord(fread($f,1));
};

function freadword($f)
{
	$b1=freadbyte($f);
	$b2=freadbyte($f);
	return $b2*256+$b1;
};


function freadlngint($f)
{
	return freaddword($f);
};

function freaddword($f)
{
	$b1=freadword($f);
	$b2=freadword($f);
	return $b2*65536+$b1;
};



function RetBits($byte,$start,$len)
{
	$bin=decbin8($byte);
	$r=bindec(substr($bin,$start,$len));
	return $r;

};

$CurrentBit=0;
function freadbits($f,$count)
{
	global $CurrentBit,$SMode;
	$Byte=freadbyte($f);
	$LastCBit=$CurrentBit;
	$CurrentBit+=$count;
	if($CurrentBit==8)
	{
		$CurrentBit=0;
	}
	else
	{
		fseek($f,ftell($f)-1);
	};
	return RetBits($Byte,$LastCBit,$count);
};



function RGBToHex($Red,$Green,$Blue)
{
	$hRed=dechex($Red);if(strlen($hRed)==1) $hRed="0$hRed";
	$hGreen=dechex($Green);if(strlen($hGreen)==1) $hGreen="0$hGreen";
	$hBlue=dechex($Blue);if(strlen($hBlue)==1) $hBlue="0$hBlue";
	return($hRed.$hGreen.$hBlue);
};

function int_to_dword($n)
{
	return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
}
function int_to_word($n)
{
	return chr($n & 255).chr(($n >> 8) & 255);
}


function decbin8($d)
{
	return decbinx($d,8);
};

function decbinx($d,$n)
{
	$bin=decbin($d);
	$sbin=strlen($bin);
	for($j=0;$j<$n-$sbin;$j++)
	$bin="0$bin";
	return $bin;
};

function inttobyte($n)
{
	return chr($n);
};






/*##############################################################################
Функция img_resize(): генерация thumbnails
Параметры:
$src             - имя исходного файла
$dest            - имя генерируемого файла
$width, $height  - ширина и высота генерируемого изображения, в пикселях
Необязательные параметры:
$rgb             - цвет фона, по умолчанию - белый
$quality         - качество генерируемого JPEG, по умолчанию - максимальное (100)
$fon             - указывает, если картинка получается меньше указанных размеров, тогда заполнить избыток фоном.
#################################################################################*/
function img_resize($src, $dest, $width, $height,  $quality=100, $rgb=0xFFFFFF, $fon=0)
{
	if (!file_exists($src)) return false;

	$size = getimagesize($src);

	if ($size === false) return false;
	$quality=(int)$quality; // приводим качество к инту, чтобы не было проблем
	$width=(int)$width;     // тоже и с размерами
	$height=(int)$height;

	// если качество меньше 1 или больше 99, тогда ставим его 100
	if($quality<1 OR $quality>99)
	{
		$quality=100;
	}


	// если вдруг не пришла высота или ширина, тогда размеры будем оставлять как размеры самой картинки, без уменьшения
	if(!$width OR !$height)
	{
		$width=$size[0];
		$height=$size[1];
	}

	// если реальная ширина и высота рисунка меньше, чем размеры до которых надо уменьшить,
	// тогда уменьшаемые размеры станут равны реальным размерам, чтобы не произошло увеличение
	if($size[0]<$width AND $size[1]<$height)
	{
		$width=$size[0];
		$height=$size[1];
	}



	// Определяем исходный формат по MIME-информации, предоставленной
	// функцией getimagesize, и выбираем соответствующую формату
	// imagecreatefrom-функцию.
	$format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));

	$icfunc = "imagecreatefrom" . $format;

	if (!function_exists($icfunc)) return false;

	$x_ratio = $width / $size[0];
	$y_ratio = $height / $size[1];

	$ratio       = min($x_ratio, $y_ratio);
	$use_x_ratio = ($x_ratio == $ratio);

	$new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
	$new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
	$new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
	$new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);


	$isrc = $icfunc($src);

	if($fon)
	{
		$idest = imagecreatetruecolor($width, $height); // так создается картинка узаканного размера, а все где картинки нет, заполнится фоном. чтобы так создавать картинку, нижнюю строку надо удалить, а с этой снять комментарии
	}
	else
	{
		$new_left    = 0; 
	    $new_top     = 0; 
		$idest = imagecreatetruecolor($new_width, $new_height);
	}

	imagefill($idest, 0, 0, $rgb);
	imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, $new_width, $new_height, $size[0], $size[1]);

	imagejpeg($idest, $dest, $quality);

	imagedestroy($isrc);
	imagedestroy($idest);

	return true;

}
################################################################
?>