<?php 

include('inc/SimpleImage.php');

$resimler = array("");
	$count = 1;
	while ($count <= 152) {
		$resim = $resimler[$count];
		$thumb_name = 'thumb_'. $resim;
		$image = new SimpleImage();
		$image->load('http://kocaelifikir.com/images/upload/'.$resim);
		$image->resizeToWidth(300);
		$image->save('../images/upload/'.$thumb_name);
	$count++;
	}
	
?>