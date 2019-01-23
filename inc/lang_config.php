<?php 
session_start();
$selected_lang = $_GET['lang'];

if ($selected_lang == '') { //dil seçimi yapıldı mı yapılmadı mı? - Hayır.

	if ($_SESSION['lang'] == '') { //Daha eskiden yapılmışmıydı ? - Hayır
		$_SESSION['lang'] = 'tr'; //Siteye ilk defa giriş yapıldı default lang seçildi.
	}
}
else{ // - Evet.
	if ($selected_lang == 'tr' || $selected_lang == 'en') {//manuel olarak url e farklı dil yazılmasın diye bu iki dil ile sınırlandırıldı
		$_SESSION['lang'] = $selected_lang; //Yeni dil seçimi session a aktarıldı.
	}
	else{
		$_SESSION['lang'] = 'tr'; //Yeni dil seçimi session a aktarıldı.
	}
}

$lang = $_SESSION['lang'] ; //Sessiondaki dil değişkene aktarıldı.

include 'lang/lang_'.$lang.'.php';
include 'lang/functions_'.$lang.'.php';
?>
