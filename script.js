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

