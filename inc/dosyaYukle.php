<?php
function dosyaYukle($resim_adi,$fiup) {
  if ($_FILES['catalog_tr']['name']) {
  //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////
    $isimyeni = md5(date("Ymdhis").rand(111111,999999));
    $uzanti = pathinfo($_FILES['catalog_tr']['name'], PATHINFO_EXTENSION);
    $new_name = $isimyeni.".".$uzanti;
    $dosya_tip = $_FILES['catalog_tr']['type'];
    if(($dosya_tip == "application/pdf") or ($dosya_tip == "application/vnd.ms-excel") or ($dosya_tip == "application/vnd.ms-word") or ($dosya_tip == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") or ($dosya_tip == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") or ($dosya_tip == "image/pjpeg") or ($dosya_tip == "image/jpeg") or ($dosya_tip == "image/JPEG") or ($dosya_tip == "image/png") or ($dosya_tip == "image/PNG") or ($dosya_tip == "image/gif")) 
    {
      $resimyukle = new Upload($_FILES['catalog_tr']);
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