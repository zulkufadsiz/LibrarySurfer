<?php

function permalink($seflink)
{
$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö', 'ç', 'ş', 'ğ', 'ü', 'ö', 'ı', '+', '#', '?', '!', ':', ';', '&', '=', '.');
$replace = array('c', 's', 'g', 'u', 'i', 'o', 'c', 's', 'g', 'u', 'o', 'i', 'plus', 'sharp', '-', '-', '-', '-', '-', '');
$seflink = strtolower(str_replace($find, $replace, $seflink));
$seflink = preg_replace("@[^A-Za-z0-9\-_\.\+]@i", ' ', $seflink);
$seflink = trim(preg_replace('/\s+/', ' ', $seflink));
$seflink = str_replace(' ', '-', $seflink);
return $seflink;
}
function searchpermalink($seflink)
{
$find = array('Ç', 'Ş', 'Ğ', 'Ü', 'İ', 'Ö');
$replace = array('ç', 'ş', 'ğ', 'ü', 'i', 'ö');
$seflink = strtolower(trim(str_replace($find, $replace, $seflink)));
$seflink = str_replace(' ', '-', $seflink);
return $seflink;
}

function dateformat($currentdate)
{
$newdate = date("d-m-Y", strtotime($currentdate));
return $newdate;
}

function dateformat1($currentdate)
{
$newdate = date("Y-m-d H:i", strtotime($currentdate));
return $newdate;
}

function dateformat2($currentdate)
{
// date("d-m-Y", strtotime($currentdate));

$gunler = array(
    'Pazartesi',
    'Salı',
    'Çarşamba',
    'Perşembe',
    'Cuma',
    'Cumartesi',
    'Pazar'
    );
 
$aylar = array(
    'Ocak',
    'Şubat',
    'Mart',
    'Nisan',
    'Mayıs',
    'Haziran',
    'Temmuz',
    'Ağustos',
    'Eylül',
    'Ekim',
    'Kasım',
    'Aralık'
    );
 
$ay = $aylar[date('m' , strtotime($currentdate)) - 1];
$gun = $gunler[date('w' , strtotime($currentdate)) - 1];
 
return date('d ' , strtotime($currentdate)). $ay . date(' Y ',strtotime($currentdate)) . $gun;
}

function dateformat3($currentdate)
{
$aylar = array(
    'Ocak',
    'Şubat',
    'Mart',
    'Nisan',
    'Mayıs',
    'Haziran',
    'Temmuz',
    'Ağustos',
    'Eylül',
    'Ekim',
    'Kasım',
    'Aralık'
    );
 
$ay = $aylar[date('m' , strtotime($currentdate)) - 1];
 
return date('d ' , strtotime($currentdate)). $ay . date(' Y ',strtotime($currentdate));
}
function dateformat4($currentdate)
{
$aylar = array(
    'Ocak',
    'Şubat',
    'Mart',
    'Nisan',
    'Mayıs',
    'Haziran',
    'Temmuz',
    'Ağustos',
    'Eylül',
    'Ekim',
    'Kasım',
    'Aralık'
    );
 
$ay = $aylar[date('m' , strtotime($currentdate)) - 1];
 
return date('d ' , strtotime($currentdate)). $ay . date(' Y ',strtotime($currentdate)) . date(' H:i ',strtotime($currentdate));
}

function currentdate()
{
    $gunler = array(
    'Pazartesi',
    'Salı',
    'Çarşamba',
    'Perşembe',
    'Cuma',
    'Cumartesi',
    'Pazar'
);
 
$aylar = array(
    'Ocak',
    'Şubat',
    'Mart',
    'Nisan',
    'Mayıs',
    'Haziran',
    'Temmuz',
    'Ağustos',
    'Eylül',
    'Ekim',
    'Kasım',
    'Aralık'
);
 
$ay = $aylar[date('m') - 1];
$gun = $gunler[date('N') - 1];
 
return date('j ') . $ay . date(' Y ') . $gun;
}

//veritabanından kullanıcı varmı kontrolü
function usercontrol($email)
{
    $uid = $_GET[id];
    if ($_GET[page] == "users") {
        if (empty($uid)) {
            $usercontrol        = "select * from users where email = '$email'";
        }
        else{
            $usercontrol        = "select * from users where email = '$email' and id != $uid";
        }
    }
    else if ($_GET[page] == "profile") {
            $usercontrol        = "select * from users where email = '$email' and id != $user_id";
    }
    else if ($_GET[page] == "writers") {
         if (empty($uid)) {
            $usercontrol        = "select * from writers where email = '$email'";
        }
        else{
            $usercontrol        = "select * from writers where email = '$email' and id != $uid";
        }
    }
    else if ($_GET[page] == "reporters") {
       if (empty($uid)) {
            $usercontrol        = "select * from reporters where email = '$email'";
        }
        else{
            $usercontrol        = "select * from reporters where email = '$email' and id != $uid";
        }
    }
    $usercontrol_calistir   = mysqli_query($connect, $usercontrol);
    $user_control = mysqli_num_rows($usercontrol_calistir);

    return $user_control;
}
    
?>