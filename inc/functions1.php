<?php

if ($_POST[submit] == "AboneOl") {
    $name   = mysqli_real_escape_string($_POST[name]);
    $email   = mysqli_real_escape_string($_POST[email]);

    $query_string8        = "SELECT * FROM bulletin WHERE email = '$email'";
    $query_string8_calistir   = mysqli_query($connect, $query_string8);
    $query8         = mysqli_num_rows($connect, $query_string8_calistir);

    if ($query8 >= 1) {
         $message = "Sistemde zaten bu mail adresi ile bir kayıt var!..";
         echo "<script type='text/javascript'> alert('$message'); window.location = '".$_SERVER['REQUEST_URI']."';</script>";
    }
    else{
        $query_string9      = "INSERT into bulletin (status, name, email) values('1', '$name', '$email')";
         // echo $query_string9;
         $query_string9_calistir = mysqli_query($connect, $query_string9);
         $message = "Bülten kaydınız başarıyla oluşturuldu";
         echo "<script type='text/javascript'> alert('$message'); window.location = '".$_SERVER['REQUEST_URI']."';</script>";
    }
}

// Hangi sayfaya yorum yapıldığını anlamak için hangi butona tıklandıgına bakıyoruz
if ($_POST[submit] == "HaberYorumYap") {
    $item_id = $_GET[id];
    insertcomment("news_comments" , $item_id);
}
else if ($_POST[submit] == "YaziYorumYap") {
    $item_id = $_GET[id];
    insertcomment("corner_posts_comments" , $item_id);
}
else if ($_POST[submit] == "RoportajYorumYap") {
    $item_id = $_GET[id];
    insertcomment("interviews_comments" , $item_id);
}
else if ($_POST[submit] == "FikirYorumYap") {
    $item_id = $_GET[id];
    insertcomment("ideas_comments" , $item_id);
}
else if ($_POST[submit] == "iletisimFormu") {
    formcontact();
}

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
    $user_control = mysqli_num_rows($connect, $usercontrol_calistir);

    return $user_control;
}

//Reklam alanının durumunu dolu yada boş olarak güncelleyen kod
function area_status_update($areaid)
{
   global $connect;
        $area_count        = "select * from ads where ad_area_id = '$areaid'";
        $area_count_calistir   = mysqli_query($connect, $area_count);
        $areacount = mysqli_num_rows($connect, $area_count_calistir);

        $area_specs        = "select * from ad_areas where id = '$areaid'";
        $area_specs_calistir   = mysqli_query($connect, $area_specs);
        $area_spec = mysqli_fetch_object($area_specs_calistir);

        $a_type = $area_spec->type;
        if ($areacount >= $a_type) {
            $sorgu8      = "update ad_areas set availability = '0' where id = '$areaid'";
            // echo $sorgu8;
        }
        else{
            $sorgu8      = "update ad_areas set availability = '1' where id = '$areaid'";
        }
            
            $sorgu8_calistir = mysqli_query($connect, $sorgu8);  
}

// kategoriye göre haber çekme fonksiyonu
function habercek($catid, $limstart, $limfinish)
{
    global $connect;
    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND location_type = 1 AND category_id = $catid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function maltihabercek($limstart, $limfinish)
{
    global $connect;
    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND location_type = 4 ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function benzerhabercek($haberid, $limstart, $limfinish)
{
    global $connect;
    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND id != $haberid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function haberdetaycek($id)
{
    global $connect;
    $haber_query_string = "SELECT * FROM news WHERE status = 1 AND id = $id";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}

// kategorideki haber sayısını bulma fonksiyonu
function habersayisi($catid)
{
    global $connect;
    $haber_query_string = "SELECT id FROM news WHERE status = 1 AND category_id = $catid";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    $haber_query_count = mysqli_num_rows($connect, $haber_query_run);
    return $haber_query_count;
}



// kategoriye göre haber çekme fonksiyonu
function arananhabercek($keyword, $limstart, $limfinish)
{
    global $connect;
    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND (title LIKE '%$keyword%' OR text LIKE '%$keyword%' OR tags LIKE '%$keyword%') ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}

// kategorideki haber sayısını bulma fonksiyonu
function arananhabersayisi($keyword)
{
    global $connect;
    $haber_query_string = "SELECT id FROM news WHERE status = 1 AND (title LIKE '%$keyword%' OR text LIKE '%$keyword%' OR tags LIKE '%$keyword%')";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    $haber_query_count = mysqli_num_rows($connect, $haber_query_run);
    return $haber_query_count;
}

// kategoriye göre haber çekme fonksiyonu
function arsivhabercek($archivedate, $limstart, $limfinish)
{
    global $connect;
    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND create_date LIKE '%$archivedate%' ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}

// kategorideki haber sayısını bulma fonksiyonu
function arsivhabersayisi($archivedate)
{
    global $connect;
    $haber_query_string = "SELECT id FROM news WHERE status = 1 AND create_date LIKE '%$archivedate%'";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    $haber_query_count = mysqli_num_rows($connect, $haber_query_run);
    return $haber_query_count;
}




// Haberin kategorisini çekme fonksiyonu
function haberkategoribul($catid)
{
    global $connect;
    $kategori_query_string = "SELECT category_id,title FROM categories WHERE category_id = $catid";
    $kategori_query_run = mysqli_query($connect, $kategori_query_string);
    return $kategori_query_run;
}
function roportajcek($limstart, $limfinish)
{
    global $connect;
    $roportaj_query_string = "SELECT id,title, text, create_date, read_count, image FROM interviews WHERE status = 1 ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $roportaj_query_run = mysqli_query($connect, $roportaj_query_string);
    return $roportaj_query_run;
}
function roportajdetaycek($id)
{
    global $connect;
    $roportaj_query_string = "SELECT * FROM interviews WHERE status = 1 AND id = $id";
    $roportaj_query_run = mysqli_query($connect, $roportaj_query_string);
    return $roportaj_query_run;
}
// kategorideki haber sayısını bulma fonksiyonu
function roportajsayisi()
{
    global $connect;
    $roportaj_query_string = "SELECT id FROM interviews WHERE status = 1";
    $roportaj_query_run = mysqli_query($connect, $roportaj_query_string);
    $roportaj_query_count = mysqli_num_rows($connect, $roportaj_query_run);
    return $roportaj_query_count;
}
function benzerroportajcek($roportajid, $limstart, $limfinish)
{
    global $connect;
    $roportaj_query_string = "SELECT id,title, text, create_date, read_count, image FROM interviews WHERE status = 1 AND id != $roportajid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $roportaj_query_run = mysqli_query($connect, $roportaj_query_string);
    return $roportaj_query_run;
}
function fikirlericek($limstart, $limfinish)
{
    global $connect;
    $fikir_query_string = "SELECT id,title, text, create_date, read_count, image FROM ideas WHERE status = 1 ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $fikir_query_run = mysqli_query($connect, $fikir_query_string);
    return $fikir_query_run;
}

function fikircek($featured, $limstart, $limfinish)
{
    global $connect;
    $fikir_query_string = "SELECT id,title, text, create_date, read_count, image FROM ideas WHERE status = 1 AND featured = $featured AND location_type = 1 ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $fikir_query_run = mysqli_query($connect, $fikir_query_string);
    return $fikir_query_run;
}
function fikirdetaycek($id)
{
    global $connect;
    $fikir_query_string = "SELECT * FROM ideas WHERE status = 1 AND id = $id";
    $fikir_query_run = mysqli_query($connect, $fikir_query_string);
    return $fikir_query_run;
}
// kategorideki haber sayısını bulma fonksiyonu
function fikirsayisi()
{
    global $connect;
    $fikir_query_string = "SELECT id FROM ideas WHERE status = 1";
    $fikir_query_run = mysqli_query($connect, $fikir_query_string);
    $fikir_query_count = mysqli_num_rows($connect, $fikir_query_run);
    return $fikir_query_count;
}
function benzerfikircek($fikirid, $limstart, $limfinish)
{
    global $connect;
    $fikir_query_string = "SELECT id,title, text, create_date, read_count, image FROM ideas WHERE status = 1 AND id != $fikirid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $fikir_query_run = mysqli_query($connect, $fikir_query_string);
    return $fikir_query_run;
}
// Reklam çekme fonksiyonu
function reklambul($adareaid)
{
    global $connect;
    $adv_query_string = "SELECT id, title,link, image, ad_area_id FROM ads WHERE status = 1 AND ad_area_id = $adareaid ORDER BY ordering, create_date DESC";
    $adv_query_run = mysqli_query($connect, $adv_query_string);
    return $adv_query_run;
}

// Reklam alanı durumu kontrol fonksiyonu
function reklamalanikontrol($adareaid)
{
    global $connect;
    $area_query_string = "SELECT status FROM ad_areas WHERE id = $adareaid";
    $area_query_run = mysqli_query($connect, $area_query_string);
    $area_status = mysqli_fetch_object($area_query_run);

    return $area_status->status;
}

function encokokunanbugun()
{
    global $connect;
    $bugun = date("Y-m-d");

    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND create_date >= '$bugun' ORDER BY read_count DESC, create_date DESC LIMIT 4";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function encokokunanbuhafta()
{
    global $connect;
    $haftaninIlkGunu = date('Y-m-d H:i:s', strtotime('Last Monday', time()));

    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND create_date >= '$haftaninIlkGunu' ORDER BY read_count DESC, create_date DESC LIMIT 4";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function encokokunanbuay()
{
    global $connect;
    $ayinIlkGunu = date("Y-m-d H:i:s", mktime(0, 0, 0, date("m"), 1, date("Y")));

    $haber_query_string = "SELECT id,title,category_id, short_text, create_date, read_count, image FROM news WHERE status = 1 AND create_date >= '$ayinIlkGunu' ORDER BY read_count DESC, create_date DESC LIMIT 4";
        $haber_query_run = mysqli_query($connect, $haber_query_string);
    return $haber_query_run;
}
function yazarlarcek($limstart, $limfinish)
{
    global $connect;
    $writer_query_string = "SELECT id, name, email , picture , text FROM writers WHERE status = 1 ORDER BY name LIMIT $limstart,$limfinish";
    $writer_query_run = mysqli_query($connect, $writer_query_string);
    return $writer_query_run;
}
function yazarsayisi()
{
    global $connect;
    $writer_query_string = "SELECT id FROM writers WHERE status = 1";
    $writer_query_run = mysqli_query($connect, $writer_query_string);
    $writer_query_count = mysqli_num_rows($connect, $writer_query_run);
    return $writer_query_count;
}

function yazardetaycek($writerid)
{
    global $connect;
    $writer_query_string = "SELECT id, name, email , picture , text FROM writers WHERE status = 1 AND id = $writerid";
    $writer_query_run = mysqli_query($connect, $writer_query_string);
    return $writer_query_run;
}
function koseyazilari($writerid, $limstart, $limfinish)
{
    global $connect;
    $corner_post_query_string = "SELECT id,title, create_date, read_count FROM corner_posts WHERE status= 1 AND author_id = $writerid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $corner_post_query_run = mysqli_query($connect, $corner_post_query_string);

    return $corner_post_query_run;
}
function koseyazisidetaycek($postid)
{
    global $connect;
    $corner_post_query_string = "SELECT id,title,author_id, text, create_date, read_count FROM corner_posts WHERE status= 1 AND id = $postid";
    $corner_post_query_run = mysqli_query($connect, $corner_post_query_string);

    return $corner_post_query_run;
}
function benzerkoseyazilari($writerid,$postid, $limstart, $limfinish)
{
    global $connect;
    $corner_post_query_string = "SELECT id,title, create_date, read_count FROM corner_posts WHERE status= 1 AND author_id = $writerid AND id != $postid ORDER BY create_date DESC LIMIT $limstart,$limfinish";
    $corner_post_query_run = mysqli_query($connect, $corner_post_query_string);

    return $corner_post_query_run;
}
function koseyazisisayisi($writerid)
{
    global $connect;
    $haber_query_string = "SELECT id FROM corner_posts WHERE status = 1 AND author_id = $writerid";
    $haber_query_run = mysqli_query($connect, $haber_query_string);
    $haber_query_count = mysqli_num_rows($connect, $haber_query_run);
    return $haber_query_count;
}
function insertcomment($table_name,$item_id){

global $connect;
    $name   = mysqli_real_escape_string(strip_tags($_POST[name]));
    $email   = mysqli_real_escape_string(strip_tags($_POST[email]));
    $comment   = mysqli_real_escape_string(strip_tags($_POST[comment]));
    $parent_comment   = mysqli_real_escape_string($_POST[parent_comment]);

    
    $add_comment_string      = "INSERT into $table_name (status, item_id, parent_comment, name, email, comment) values('0', '$item_id', '$parent_comment', '$name', '$email', '$comment')";
    // echo $add_comment_string;
    $add_comment_string_run = mysqli_query($connect, $add_comment_string);
    $message = "Yorumunuz için teşekkür ederiz. Editörlerimiz tarafından onaylandıktan sonra hemen yayınlanacaktır.";
    echo "<script type='text/javascript'> alert('$message'); window.location = '".$_SERVER['REQUEST_URI']."';</script>";
}

function yorumsayisi($table_name,$comment_item_id)
{
    global $connect;
    $comment_query_string = "SELECT id FROM $table_name WHERE status = 1 AND item_id = $comment_item_id";
    $comment_query_run = mysqli_query($connect, $comment_query_string);
    $comment_query_count = mysqli_num_rows($connect, $comment_query_run);
    return $comment_query_count;
}
function formcontact(){

global $connect;
    $name   = mysqli_real_escape_string(strip_tags($_POST[form_name]));
    $lname   = mysqli_real_escape_string(strip_tags($_POST[form_lastname]));
    $email   = mysqli_real_escape_string(strip_tags($_POST[form_email]));
    $subject   = mysqli_real_escape_string(strip_tags($_POST[form_subject]));
    $message   = mysqli_real_escape_string(strip_tags($_POST[form_message]));
    
    $add_contact_string      = "INSERT into contact_messages (status, name, lname, email, subject, message) values('0', '$name', '$lname', '$email', '$subject', '$message')";
    // echo $add_comment_string;
    $add_contact_string_run = mysqli_query($connect, $add_contact_string);
    $message = "İlginiz için teşekkür ederiz. Mesajınıza en kısa sürede yanıt verilecektir.";
    echo "<script type='text/javascript'> alert('$message'); window.location = '".$_SERVER['REQUEST_URI']."';</script>";
}
function metasettings($settingsid)
{
    global $connect;
    $settings_query_string = "SELECT * FROM settings WHERE status= 1 AND id = $settingsid";
    $settings_query_run = mysqli_query($connect, $settings_query_string);

    return $settings_query_run;
}  
function add_featured_pool($item_id,$location_type,$category_type){
    
    global $connect;
    $pool_select        = "SELECT * from featured_pool where category_type = '$category_type' and item_id = $item_id";
    
    $pool_select_calistir   = mysqli_query($connect, $pool_select);
    $pool_select_sonuc = mysqli_num_rows($connect, $pool_select_calistir);
    $pool_select_icerik = mysqli_fetch_object($pool_select_calistir);

    // return $pool_select_sonuc;
    if ($pool_select_sonuc == 0 ) {
        $add_featured_pool = "INSERT into featured_pool (status, category_type, item_id, area_ordering, location_type) values('0', '$category_type', '$item_id', '9999', '$location_type')"; 
        $add_featured_pool_run = mysqli_query($connect, $add_featured_pool);
    }
    else{
        if ($pool_select_icerik->location_type == $location_type) {
           
        }
        else{
             $edit_featured_pool = "UPDATE featured_pool SET status = '0' , location_type = '$location_type' where category_type = $category_type AND item_id = '$item_id'"; 
             $edit_featured_pool_run = mysqli_query($connect, $edit_featured_pool);
        }
      
    }
}
function remove_featured_pool($item_id,$category_type){

global $connect;
    $delete = "DELETE FROM featured_pool WHERE item_id = '$item_id' AND category_type = $category_type"; // MYSQL query that: Update in db_table Order with value $order where rows id equals $item. $item is the number in index.php file: item-3.
    $delete_run = mysqli_query($connect,  $delete ); //perform the delete

    if ($category_type == 1 ) {
        $edit_news = "UPDATE news SET location_type = '1' where id = '$item_id'"; 
        $edited_news = mysqli_query($connect, $edit_news);
    }
    if ($category_type == 2 ) {
        $edit_news = "UPDATE interviews SET location_type = '1' where id = '$item_id'"; 
        $edited_news = mysqli_query($connect, $edit_news);
    }
    if ($category_type == 3 ) {
        $edit_news = "UPDATE corner_posts SET location_type = '1' where id = '$item_id'"; 
        $edited_news = mysqli_query($connect, $edit_news);
    }
    if ($category_type == 4 ) {
        $edit_news = "UPDATE ideas SET location_type = '1' where id = '$item_id'"; 
        $edited_news = mysqli_query($connect, $edit_news);
    }

   
}


?>