<!--
<div align="center">
			<img src="/admin/uploads/152" style="float: left; margin-right: 10px; max-width:600px" id="thumbnail" alt="Create Thumbnail" />
			<div style="float:left; position:relative; overflow:hidden; width:100px; height:100px;">
				<img src="/admin/uploads/152" style="position: relative;" alt="Thumbnail Preview" />

			</div>
			<br style="clear:both;"/>
			<form name="thumbnail" action="/jquery/image_upload_crop.php" method="post">
				<input type="hidden" name="x1" value="" id="x1" />
				<input type="hidden" name="y1" value="" id="y1" />
				<input type="hidden" name="x2" value="" id="x2" />
				<input type="hidden" name="y2" value="" id="y2" />
				<input type="hidden" name="w" value="" id="w" />
				<input type="hidden" name="h" value="" id="h" />

				<input type="submit" class="button" name="upload_thumbnail" value="Save Thumbnail" id="save_thumb" />
			</form>
		</div>
	<hr />
		<h2>Upload Photo</h2>
	<p>NOTE: The upload part has been disabled for security reasons, please use the image provided to test the crop function</p>
	<form name="photo" enctype="multipart/form-data" action="/jquery/image_upload_crop.php" method="post">
	Photo <input type="file" name="image" size="30" disabled="disabled" /> <input type="submit" name="upload" value="Upload" disabled="disabled" class="button" />

	</form>
	-->
<?php

    $page_content='';
	if (isset($_REQUEST['gocrop']))
		{
			$pos=(int)$_REQUEST['pos'];
			$filename=addslashes($_REQUEST['img']);
			$arr=explode('.',$filename);
								$typ=$arr[1];
								$src='../temp_images/'.$filename;
								$src2='../catalog_images/'.$filename;
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
								mysql_query("INSERT INTO ".TBLPRE."cat_img (`pos`,`img`) VALUES ('$pos','$filename')") or die(mysql_error());
								unlink($src);
				$page_content.="<h1>Картинка обработана</h1>
								<script language=\"JavaScript\">
									alert('bed');
									$('#img_box').load('/ajax_features/update_img_box.php?pos=$pos');
									alert('good');
								</script>";				
		} else
		{
			$url=addslashes($_REQUEST['img']);
			//$imgcod=addslashes($_REQUEST['imgcod']);
			$pos=(int)$_REQUEST['pos'];
			$page_content.="<div id='but_close'><img src='/images/close_button.png'></div>
							<table cellspacing=0 cellpadding=2 border=0 id='regf'>
							<tr><td><img src='/images/slogo.png'></td><td align=left><span class='head'>Обработка картинки</span></td></tr>
							</table>
							<form method='post' id='crop_form'>
							<table align=center cellspacing=0 cellpadding=2 border=0 style=\"margin:10px auto;\">
							<tr><td  align=center><div id='ajax_canvas' style=\"text-align:left;position:relative;\"><img id='canvas' src='/admin/uploads/152' style='width:400px'></div></td></tr>
							<tr><td><input type=button id='go_but' value=''></td></tr>
							</table>
							<input type=hidden name=img value=$url >
							<input type=hidden name=gocrop value=true>
							<input type=hidden id='x1' name='x1' />
							<input type=hidden id='y1' name='y1' />
							<input type=hidden id='x2' name='x2' />
							<input type=hidden id='y2' name='y2' />
							<input type=hidden name='imgcod' value='$imgcod'>
							<input type=hidden name='pos' value='$pos'>
								<script language=\"JavaScript\">
								    $('#but_close').click($.unblockUI);
									$('#go_but').click(function(){
										query = $(\"#crop_form\").serialize();
										$.post('/ajax_features/crop_pos_image.php',query,function(data){
										$('#ajax').html(data);
										$('#but_close').click($.unblockUI);
										});
									});	
										function updateCoords(img,selection)
										{
											$('#x1').val(selection.x1);
											$('#y1').val(selection.y1);
											$('#x2').val(selection.x2);
											$('#y2').val(selection.y2);
										};
									$('#canvas').imgAreaSelect({ x1:0,y1:0,x2:240,y2:140,parent:'#ajax_canvas',aspectRatio: '1:1',resizable: false,zIndex:9999, onSelectChange: updateCoords });	
									</script>
							</form>
							";
		}
	echo $page_content;	
?>