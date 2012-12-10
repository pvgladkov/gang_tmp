<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Upload your file</title>
	<link href="style_progress.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.0/jquery.js" type="text/javascript"></script>
	<script>

		$(document).ready(function() { 

			var show_bar = 0;
			$('input[type="file"]').click(function(){
				show_bar = 1;
			});

			$("#form1").submit(function(){

				if (show_bar === 1) { 
					$('#upload_frame').show();
					function set () {
						$('#upload_frame').attr('src','upload_frame.php?up_id=<?php echo $up_id; ?>');
					}
					setTimeout(set);
				}
			});
		});
	</script>
</head>

<body>
	
	<h1>Загрузка файлов </h1>

	<div>

		<span class="notice"> <?=$sMessage?></span>

		<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">

			Название видео:<br/> 
			<input type="text" name="title"/> <br/>

			Комментарий:<br/> 
			<textarea name="comment"></textarea> </te><br/>

			<input type="hidden" name ="id" value="<?=$sUserHash?>">

			Выберите файл<br />

			<!--APC hidden field-->
			<input type="hidden" name="APC_UPLOAD_PROGRESS" id="progress_key" value="<?php echo $up_id; ?>"/>
			<!---->

			<input name="file" type="file" id="file" size="30"/>

			<!--Include the iframe-->
			<br />
			<iframe id="upload_frame" name="upload_frame" frameborder="0" border="0" src="" scrolling="no" scrollbar="no" > </iframe>
			<br />
			<!---->

			<input name="Submit" type="submit" id="submit" value="Submit" />
		</form>
	</div>

</body>
</html>
