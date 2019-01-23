<?php
function resimYukle($resim_adi,$fiup) {
  if ($_FILES['resim']['name']) {
                            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
    $isimyeni = md5(date("Ymdhis").rand(111111,999999));
    $uzanti = pathinfo($_FILES['resim']['name'], PATHINFO_EXTENSION);
    $new_name = $isimyeni.".".$uzanti;
    $dosya_tip = $_FILES['resim']['type'];
    if(($dosya_tip == "image/jpeg") or ($dosya_tip == "image/pjpeg") or ($dosya_tip == "image/jpeg") or ($dosya_tip == "image/JPEG") or ($dosya_tip == "image/png") or ($dosya_tip == "image/PNG") or ($dosya_tip == "image/gif")) {
    $resimyukle = new Upload($_FILES['resim']);
    if ($resimyukle->uploaded) {
      // save uploaded image with no changes
      $resimyukle->file_new_name_body   = $isimyeni;
      $resimyukle->file_new_name_ext = $uzanti;
      $resimyukle->Process("$fiup");
     
      return $new_name;
    }
}
}

}

function resimYukle2($resim_adi,$fiup) {
  if ($_FILES['resim2']['name']) {
                                //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
        $isimyeni = md5(date("Ymdhis").rand(111111,999999));
        $uzanti = pathinfo($_FILES['resim2']['name'], PATHINFO_EXTENSION);
        $new_name = $isimyeni.".".$uzanti;
        $dosya_tip = $_FILES['resim2']['type'];
        if(($dosya_tip == "image/jpeg") or ($dosya_tip == "image/pjpeg") or ($dosya_tip == "image/JPEG") or ($dosya_tip == "image/png") or ($dosya_tip == "image/PNG") or ($dosya_tip == "image/gif")) {
        $resimyukle = new Upload($_FILES['resim2']);
        if ($resimyukle->uploaded) {
          // save uploaded image with no changes
          $resimyukle->file_new_name_body   = $isimyeni;
          $resimyukle->file_new_name_ext = $uzanti;
          $resimyukle->Process("$fiup");
          return $new_name;
      }
    }
  }
}

function resimYukle3($resim_adi,$fiup) {
  if ($_FILES['resim3']['name']) {
                            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
    $isimyeni = md5(date("Ymdhis").rand(111111,999999));
    $uzanti = pathinfo($_FILES['resim3']['name'], PATHINFO_EXTENSION);
    $new_name = $isimyeni.".".$uzanti;
    $dosya_tip = $_FILES['resim3']['type'];
    if(($dosya_tip == "image/jpeg") or ($dosya_tip == "image/pjpeg") or ($dosya_tip == "image/jpeg") or ($dosya_tip == "image/JPEG") or ($dosya_tip == "image/png") or ($dosya_tip == "image/PNG") or ($dosya_tip == "image/gif")) {
    $resimyukle = new Upload($_FILES['resim3']);
    if ($resimyukle->uploaded) {
      // save uploaded image with no changes
      $resimyukle->file_new_name_body   = $isimyeni;
      $resimyukle->file_new_name_ext = $uzanti;
      $resimyukle->Process("$fiup");
      return $new_name;
    }
}
}

}

?>