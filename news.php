<!--     <?php if ($_GET[action] == "delete") {
       // remove_featured_pool($_GET[id], 4);

        $sil_sorgu     = "delete from news where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        //header("Location: ?page=news&ok=delete");
        }           
    ?>  -->         
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Haberler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=news&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=news" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Başlık</th>                                    
                            <th>Kategori</th>
                            <th>Okunma</th>
                            <th>Tarih</th>
                            <th>Sliderda</th>
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id,title,category_id, read_count, create_date, slider_show ,image, status from news order by create_date DESC LIMIT 0,300";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  

                        <?php 
                        //category_id den kategori adını buluyoruz
                        $sorgu2 ="SELECT title from categories where category_id = $query1->category_id";
                        // echo $sorgum;
                        $sorgu2_calistir = mysqli_query($connect, $sorgu2);
                        $sorgu2_sonuc = mysqli_fetch_object($sorgu2_calistir);
                        ?>
                        <tr role="row" class="odd">
                            <td><?=$query1->id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  
                            </td>
                            <td class="center"><?=$query1->title?></td>
                            <td class="center"><?=$sorgu2_sonuc->title?></td>
                            <td class="center"><?=$query1->read_count ?></td>
                            <td class="center"><?=$query1->create_date ?></td>
                            <td class="center">
                            <?php if ($query1->slider_show == "1") { ?>
                                <span class="tag tag-success">Evet</span>
                            <?php } ?>
                            <?php if ($query1->slider_show == "0") { ?>
                                <span class="tag tag-danger">Hayır</span>
                            <?php } ?>                                  
                            </td>

                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>

                            <td class="center">
                                <a class="btn btn-info" href="?page=news&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <!-- <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=news&action=delete&id=<?=$query1->id;?>'>Evet</a>">
                                    <i class="fa fa-trash-o "></i> 
                                </a> -->
                            </td>
                        </tr>
                       <?php } ?>
                   </tbody>
                </table>
            </div>
        </div>
    <?php } ?> <!-- !action-->
    <?php 
    if ($_GET[action] == "add") {  
        if ($_POST[submit] == "Ekle") {

            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = 9999 ;
            $featured   = mysqli_real_escape_string($connect, $_POST[featured]);
            $slider_show   = mysqli_real_escape_string($connect, $_POST[slider_show]);
            $category_id   = mysqli_real_escape_string($connect, $_POST[category_id]);
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $short_text   = mysqli_real_escape_string($connect, $_POST[short_text]);
            $text   = mysqli_real_escape_string($connect, $_POST[text]);
            $video_url   = mysqli_real_escape_string($connect, $_POST[video_url]);
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);
            $location_type   = mysqli_real_escape_string($connect, $_POST[location_type]);
            $reporter   = mysqli_real_escape_string($connect, $_POST[reporter]);
            $author   = $user_information->id; 
            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
               // $thumb_name = 'thumb_'.$new_name;
               // $image = new SimpleImage();
               // $image->load('http://kocaelifikir.com/images/upload/'.$new_name);
               // $image->resizeToWidth(300);
               // $image->save('../images/upload/'.$thumb_name);
            }
            if ($_FILES[resim2][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name2 = resimYukleSur($_FILES[resim2][name],$fiup);
                        $resim_3 = ",image_sur";
                        $resim_4 = ", '$new_name2'";
               // $thumb_name = 'thumb_'.$new_name;
               // $image = new SimpleImage();
               // $image->load('http://kocaelifikir.com/images/upload/'.$new_name);
               // $image->resizeToWidth(300);
               // $image->save('../images/upload/'.$thumb_name);
            }
         if ($_FILES[catalog_tr][name]) {
                //////////////////////////////////////////   DOSYA UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                    $file_new_name = dosyaYukle($_FILES[catalog_tr][name],$fiup);
                    $dosya_1 = ",catalog_tr";
                    $dosya_2 = ", '$file_new_name'";
            }    

            $query_string1      = "insert into news (status, ordering, featured, slider_show, location_type, category_id, title, short_text, text, video_url, tags, author, reporter $resim_1 $resim_3 $dosya_1) 
            values('$status', '$ordering', '$featured', '$slider_show', '$location_type', '$category_id', '$title', '$short_text', '$text', '$video_url', '$tags', '$author', '$reporter' $resim_2 $resim_4 $dosya_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            if ($location_type != 1 && $status == 1) {
            $category_type = 1; // Havuza eklenecek kategori tipi "Haber"
            add_featured_pool($sonid,$location_type,$category_type);
            }
            header("Location: ?page=news&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Haberler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=news" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=news&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Durum</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "0")) {?><option value="0" >Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                <?php if ($_POST[status] == "1"){?><option value="0">Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                            </select>
                       </div>
                       <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Sliderda</label>
                            <select class="form-control" id="exampleSelect1" name="slider_show">
                                <?php if ((!$_POST[slider_show]) or ($_POST[slider_show] == "1")) {?><option value="1" selected>Evet</option><option value="0" >Hayır</option><?php } ?>
                                <?php if ($_POST[slider_show] == "0")              {?><option value="1">Evet</option><option value="0" selected>Hayır</option><?php } ?>
                            </select>
                       </div>
                       <!-- <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Slider Yanında</label>
                            <select class="form-control" id="exampleSelect1" name="featured">
                                <?php if ((!$_POST[featured]) or ($_POST[featured] == "1")) {?><option value="1">Evet</option><option value="0" selected>Hayır</option><?php } ?>
                                <?php if ($_POST[featured] == "0")              {?><option value="1">Evet</option><option value="0" selected>Hayır</option><?php } ?>
                            </select>
                       </div> -->
                       <div class="form-group col-xs-12 col-sm-3 col-md-3" id="location_selector">
                            <label for="exampleSelect1">Giriş Tipi</label>
                            <select class="form-control" id="exampleSelect1" name="location_type">
                                <?php
                                    // Kategoriler DB' den çekilir.
                                $count9 = 1;
                                $sorgu9        = "SELECT * from location_types where status = 1 order by id";
                                $sorgu_calistir9   = mysqli_query($connect, $sorgu9);
                                while ($locations = mysqli_fetch_object($sorgu_calistir9)) { ?>
                                <option value="<?=$locations->id ?>" <?php if ($count9 == 1) { echo "selected"; } ?> ><?=$locations->title ?></option>
                                <?php 
                                $count9++;
                                } ?>
                            </select>
                       </div>
                       <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Muhabir<span class="text-danger">*</span></label>
                            <select class="form-control" name="reporter" id="exampleSelect1">
                                <option value="0" selected>Muhabir seçiniz...</option>
                               <?php
                                    $query2_string        = "SELECT * FROM reporters WHERE status = 1 ORDER BY name ";
                                    $query2_string_calistir   = mysqli_query($connect, $query2_string);
                                    while ($query2 = mysqli_fetch_object($query2_string_calistir)) {
                                    ?>                              
                                      <option value="<?=$query2->id?>"><?=$query2->name ?></option>
                                <?php } ?>

                            </select>
                       </div>
                      
                        <div class="form-group col-xs-12">
                            <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id" id="exampleSelect1" required>
                                <option value="0" selected disabled>Kategori Seçiniz...</option>
                                <?php
                                    // Kategoriler DB' den çekilir.
                                    $sorgu        = "SELECT * from categories where main_category_id = 0 order by title";
                                    $sorgu_calistir   = mysqli_query($connect, $sorgu);
                                    while ($cat_x = mysqli_fetch_object($sorgu_calistir)) {
                                        $sorgu_y        = "SELECT * from categories where main_category_id = $cat_x->category_id order by title";
                                        $sorgu_y_calistir   = mysqli_query($connect, $sorgu_y);
                                        $sub_cat =mysqli_num_rows($sorgu_y_calistir);   
                                    ?>      
                                    <option value="<?=$cat_x->category_id?>" <?php if($sub_cat >= 1 ){?> disabled <?php } ?>><?=$cat_x->title?></option>
                                    <?php                   
                                    $sorgu_z        = "SELECT * from categories where main_category_id = $cat_x->category_id order by title";
                                    $sorgu_z_calistir   = mysqli_query($connect, $sorgu_z);
                                    while ($cat_z = mysqli_fetch_object($sorgu_z_calistir)) {
                                    ?>                              
                                      <option value="<?=$cat_y->category_id?>">&raquo; <?=$cat_z->title?></option>
                                    <?php } ?>
                                <?php }?>
                            </select>
                       </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?=$_POST[title];?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kısa Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="short_text"><?=$_POST[short_text];?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=$_POST[text];?></textarea>

                        </div>
                       <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Video (Youtube video kodu eklenmelidir. Örn.: eKQUP2el3zU)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="video_url" value="<?=$_POST[video_url];?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (aralarına virgül ',' yazınız. Örn.: kocaeli,haber,sitesi )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=$_POST[tags];?>" required>
                        </div>


                          <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Dosya</label>
                             <div class="controls">
                                <input class="form-control" type="file" name="catalog_tr">
                            </div>
                          </div>                                                                                                                                            



                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Resmi (Çoklu görsel eklemek için önce bu bilgileri kaydedin!..)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Ekle">EKLE</button>
                        </div>
                    </div>
               </form>
            </div>
        </div>
    <?php } ?>
     <?php 
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {
            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = 9999 ;
            $featured   = mysqli_real_escape_string($connect, $_POST[featured]);
            $hot_news   = mysqli_real_escape_string($connect, $_POST[hot_news]);
            $slider_show   = mysqli_real_escape_string($connect, $_POST[slider_show]);
            $location_type   = mysqli_real_escape_string($connect, $_POST[location_type]);
            $category_id   = mysqli_real_escape_string($connect, $_POST[category_id]);
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $short_text   = mysqli_real_escape_string($connect, $_POST[short_text]);
            $short_text   = str_replace('\r\n', '', $short_text);
            $text   = mysqli_real_escape_string($connect, $_POST[text]);
            $text   = str_replace('\r\n', '', $text);
            $video_url   = mysqli_real_escape_string($connect, $_POST[video_url]);
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);
            $reporter   = mysqli_real_escape_string($connect, $_POST[reporter]);
            $author   = $user_information->id; 

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
                
               // $thumb_name = 'thumb_'.$new_name;
               // $image = new SimpleImage();
               // $image->load('http://kocaelifikir.com/images/upload/'.$new_name);
               // $image->resizeToWidth(300);
               // $image->save('../images/upload/'.$thumb_name);
            }
            if ($_FILES[resim2][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name2 = resimYukleSur($_FILES[resim2][name],$fiup);
               
                $resim2 = ", image_sur = '$new_name2'";

               // $thumb_name = 'thumb_'.$new_name;
               // $image = new SimpleImage();
               // $image->load('http://kocaelifikir.com/images/upload/'.$new_name);
               // $image->resizeToWidth(300);
               // $image->save('../images/upload/'.$thumb_name);
            }
            if ($_FILES[catalog_tr][name]) {
                //////////////////////////////////////////   DOSYA UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $file_new_name = dosyaYukle($_FILES[catalog_tr][name],$fiup);
                $dosya = ", catalog_tr = '$file_new_name'";
            }        

            $sorgu      = "update news set 
            status = '$status', 
            ordering = '$ordering', 
            featured = '$featured', 
            hot_news = '$hot_news', 
            slider_show = '$slider_show', 
            location_type = '$location_type', 
            category_id = '$category_id', 
            title = '$title',
            short_text = '$short_text', 
            text = '$text', 
            video_url = '$video_url',
            tags = '$tags',
            author = '$author',
            reporter = '$reporter'
            $resim $resim2 $dosya where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            if ($location_type != 1) {
            $category_type = 1; // Havuza eklenecek kategori tipi "Haber"
            add_featured_pool($_GET[id],$location_type,$category_type);
            }
            else if($status == 0){
                remove_featured_pool($_GET[id], 1);
            }

            header("Location: ?page=news&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM news WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Haberler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=news&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=news" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=news&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Durum<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ($query2->status == "1") {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($query2->status == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
                       </div>
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Sliderda<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="slider_show">
                                <?php if ($query2->slider_show == "0") { ?> <option value="0" selected>Hayır</option> <option value="1" >Evet</option> <?php } ?>
                                <?php if ($query2->slider_show == "1") { ?> <option value="0">Hayır</option> <option value="1" selected>Evet</option> <?php } ?>
                            </select>
                       </div>
                     <!--    <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Slider Yanında<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="featured">
                                <?php if ($query2->featured == "0") { ?> <option value="0" selected>Hayır</option> <option value="1" >Evet</option> <?php } ?>
                                <?php if ($query2->featured == "1") { ?> <option value="0">Hayır</option> <option value="1" selected>Evet</option> <?php } ?>
                            </select>
                       </div> -->
                         <div class="form-group col-xs-12 col-sm-3 col-md-3" id="location_selector">
                            <label for="exampleSelect1">Giriş Tipi</label>
                            <select class="form-control" id="exampleSelect1" name="location_type">
                                <?php
                                    // Kategoriler DB' den çekilir.
                                $sorgu9        = "SELECT * from location_types where status = 1 order by id";
                                $sorgu_calistir9   = mysqli_query($connect, $sorgu9);
                                while ($locations = mysqli_fetch_object($sorgu_calistir9)) { ?>
                                <option value="<?=$locations->id ?>" <?php if ($locations->id == $query2->location_type) { echo "selected"; } ?> ><?=$locations->title ?></option>
                                <?php } ?>
                            </select>
                       </div>
                       <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Muhabir<span class="text-danger">*</span></label>
                            <select class="form-control" name="reporter" id="exampleSelect1">
                                <option value="0" <?php if ($query2->reporter == 0 ): ?> selected <?php endif ?>>Muhabir seçiniz...</option>

                                <?php
                                    $query3_string        = "SELECT * FROM reporters WHERE status = 1 ORDER BY name";
                                    $query3_string_calistir   = mysqli_query($connect, $query3_string);
                                    while ($query3 = mysqli_fetch_object($query3_string_calistir)) {
                                    ?>                              
                                      <option value="<?=$query3->id?>"<?php if ($query3->id == $query2->reporter): ?> selected <?php endif ?>><?=stripslashes($query3->name)?></option>
                                <?php }?>

                            </select>
                       </div>
                       <?php if ($query2->location_type == 2) { ?>
                       
                       <div class="form-group col-xs-12" id="surMansetPhoto">
                            <label for="example-color-input" class=" col-form-label">Sürmanşet Fotoğrafı (Habere kapak fotoğrafı girmeyi unutmayın!..)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim2">
                            <p><img src="../images/upload/<?=$query2->image_sur?>" width="200px" ></p>

                        </div>
                       <?php } ?>
                       

                       
                        <div class="form-group col-xs-12">
                            <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id" id="exampleSelect1">
                                <?php
                                // Kategoriler DB' den çekilir.
                                    $sorgu        = "SELECT * from categories where main_category_id = 0 order by title";
                                    $sorgu_calistir   = mysqli_query($connect, $sorgu);
                                    while ($cat_x = mysqli_fetch_object($sorgu_calistir)) {
                                        $sorgu_y        = "SELECT * from categories where main_category_id = $cat_x->category_id order by title";
                                        $sorgu_y_calistir   = mysqli_query($connect, $sorgu_y);
                                        $sub_cat =mysqli_num_rows($sorgu_y_calistir);   
                                    ?>      
                                    <option value="<?=stripslashes($cat_x->category_id)?>"  <?php if($sub_cat >= 1 ){?> disabled <?php }else{ if ($cat_x->category_id == $query2->category_id){ echo " selected "; }  }?> ><?=stripslashes($cat_x->title)?></option>
                                    <?php                   
                                    $sorgu_z        = "SELECT * from categories where main_category_id = $cat_x->category_id order by title";
                                    $sorgu_z_calistir   = mysqli_query($connect, $sorgu_z);
                                    while ($cat_z = mysqli_fetch_object($sorgu_z_calistir)) {
                                    ?>                              
                                      <option value="<?=$cat_z->category_id?>"<?php if ($cat_z->category_id == $query2->category_id): ?> selected <?php endif ?>>&raquo; <?=stripslashes($cat_z->title)?></option>
                                    <?php } ?>
                                <?php }?>

                            </select>
                       </div>
                       
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" id="example-text-input" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->title))?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kısa Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="short_text"><?=stripslashes($query2->short_text)?></textarea>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=stripslashes($query2->text)?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Video (Youtube video kodu eklenmelidir. Örn.: eKQUP2el3zU)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="video_url" id="example-text-input" value="<?=stripslashes($query2->video_url)?>">
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (aralarına virgül ',' yazınız. Örn.: kocaeli,haber,sitesi )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="tags" id="example-text-input" value="<?=stripslashes($query2->tags)?>" required>
                        </div>

                          <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Dosya </label>
                            <input class="form-control" type="file" name="catalog_tr">
                            <?php if($query2->catalog_tr != ''){ ?>
                            <br>
                            <p class="document-area"><a target="_blank" href="/images/upload/<?=$query2->catalog_tr?>" title="Dosyayı İndir">Mevcut dosya <i class="fa fa-download"></i></a> <span title="Dosyayı Sil" class="remove-doc" style="padding-left: 10px;"> <i class="fa fa-remove"></i></span></p>
                            <?php } ?>
                        </div>

                         <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="../images/upload/<?=$query2->image?>" width="200px" ></p>

                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>


                <hr>
                              <!-- Çoklu Görsel Yükleme Betiği -->
                                <?php
                                $islem = $_GET['pp_action'];
                                switch($islem){
                                case "": 
                                ?>
                                    <form method="post" action="?page=news&action=edit&id=<?=$_GET['id']?>&pp_action=upload" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label class="control-label" for="focusedInput">İçerik Görselleri (CTRL tuşu ile birden fazla görsel yükleyebilirsiniz)</label>
                                        <div class="controls">
                                        <span class="btn btn-default btn-file">
                                            <input name="imagesUpload[]" type="file" min="1" max="3" multiple />
                                        </span>                                     
                                            <input class="btn btn-success" type="submit" value="Gönder">
                                        </div>
                                    </div>                                      
                                    </form>
                                    <hr>                
                                <label class="control-label" for="focusedInput">İçerik Görsellerini Sıralayın (Görseli sürükleyip bırakarak sıralamayı değiştirebilirsiniz)</label>
                                    <div class="form-group">    </div>              
                                    <button class="btn btn-success product-save">Sıralamayı Kaydet</button>      
                                    <div id="response2"></div>
                                    
                                <div class="row">

                                    <ul class="sortable-2">
                                    <?php

                                    $select = "SELECT * FROM news_pictures WHERE product_id = $_GET[id] ORDER by picture_ordering"; // select every element in the table in order by order column
                                    $perform = mysqli_query($connect,  $select ); //perform selection query

                                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                                        $id = $array['picture_id'];
                                        $title = $array['title'];
                                        $photo_name = $array['picture_path'];
                                        ?>
                                            <li id='item-<?php echo $id ?>' class="text-center"><img src="../images/upload/<?php echo $photo_name ?>" alt=""><br><?php echo $title ?>
                                            <a class="btn btn-danger" href="?page=news&action=edit&id=<?=$_GET[id]?>&pp_action=resim_sil&picture_id=<?=$array['picture_id']?>" style="width:100%">Sil</a></li>

                                        <?php
                                      }

                                    ?>
                                    </ul>   
                                                
                                </div>                                  

                                <?php
                                break;

                                case "upload"://upload string deðiþken deðerimiz
                                $img_target = "../images/upload/"; //Resmin yükleneceði yer
                                foreach ($_FILES["imagesUpload"]["error"] as $upload => $error) {//Foreach döngüsü kurarak toplu seçimde array olaran gelen resimleri alýyoruz
                                    if ($error == UPLOAD_ERR_OK) {//Resim seçilmiþ ve hata yok ise upload yap
                                        $img_source = $_FILES["imagesUpload"]["tmp_name"][$upload];
                                        $isimyeni = md5(date("Ymdhis").rand(111111,999999));
                                        $img_name = $isimyeni.$_FILES["imagesUpload"]["name"][$upload];
                                        
                                        move_uploaded_file($img_source,$img_target.'/'.$img_name);
                                        
                                        $query = mysqli_query($connect, "INSERT INTO news_pictures (picture_path, product_id) VALUES ('$img_name', '$_GET[id]')");
                                        header("Location: ?page=news&action=edit&id=$_GET[id]&ok=edit");
                                    }else{//Resim seçilmemiþ ve hata var ise
                                        header("Location: ?page=news&action=edit&id=$_GET[id]&ok=error");
                                    }
                                }
                                break;

                                case "resim_sil":
                                $id = $_GET['picture_id'];
                                $silincek_resim = mysqli_query($connect, "SELECT * FROM news_pictures WHERE picture_id=$id");
                                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                                $sil = mysqli_query($connect, "DELETE FROM news_pictures WHERE picture_id=$id");

                                if($sil){
                                header("Location: ?page=news&action=edit&id=$_GET[id]&ok=delete");
                                @unlink($silincek_resim_yeni['picture_id']); 
                                }else{
                                header("Location: ?page=news&action=edit&id=$_GET[id]&ok=error");

                                }
                                break;
                                }
                                ?>                                  




            </div>
        </div>
    <?php } ?>