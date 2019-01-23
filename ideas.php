<?php 
session_start();
include 'inc/session.php'; ?>
    <?php if ($_GET[action] == "delete") {
        remove_featured_pool($_GET[id], 4);

        $sil_sorgu     = "DELETE FROM ideas WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
       

        header("Location: ?page=ideas&ok=delete");
        }           
    ?>          
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Fikirler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=ideas&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=ideas" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block list-data-table">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Başlık</th>
                            <th>Okunma</th>
                            <th>Tarih</th>
                            <th>Öne Çıkar</th>
                            <th>Kapak Fotğrafı</th>
                            <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query1_string        = "SELECT id, status, title, read_count, create_date, featured, image FROM ideas ORDER BY create_date DESC";
                        $query1_string_calistir   = mysqli_query($connect, $query1_string);
                        while ($query1 = mysqli_fetch_object($query1_string_calistir)) {
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
                            <td><?=$query1->read_count?></td>
                            <td><?=$query1->create_date?></td>
                            <td class="center">
                            <?php if ($query1->featured == "1") { ?>
                                <span class="tag tag-success">Evet</span>
                            <?php } ?>
                            <?php if ($query1->featured == "0") { ?>
                                <span class="tag tag-danger">Hayır</span>
                            <?php } ?>                                  

                            </td>
                           <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=ideas&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                    <a href="javascript:;"  class="btn btn-danger " data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-trigger="focus hover" title="Sil ?" data-content="<a class='btn btn-danger' href='?page=ideas&action=delete&id=<?=$query1->id;?>'>Evet</a>"><i class="fa fa-trash-o "></i> </a>

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
                $featured   = mysqli_real_escape_string($connect, $_POST[featured]);
                 $location_type   = mysqli_real_escape_string($connect, $_POST[location_type]);

                $title   = mysqli_real_escape_string($connect, $_POST[title]);
                $text   = mysqli_real_escape_string($connect, $_POST[text]);
                $tags   = mysqli_real_escape_string($connect, $_POST[tags]);

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
            }

           $query1_string      = "INSERT INTO ideas (status, featured, location_type, tags, title, text $resim_1 $resim_3) 
            VALUES('$status', '$featured', '$location_type', '$tags', '$title', '$text' $resim_2 $resim_4)";
            // echo $query1_string;
            $query1_string_calistir = mysqli_query($connect, $query1_string);
            
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;             
            // echo $kategori_sorgu;     
            if ($location_type != 1 && $status == 1) {
            $category_type = 4; // Havuza eklenecek kategori tipi "fikir"
            add_featured_pool($sonid,$location_type,$category_type);
            }        

            header("Location: ?page=ideas&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
            }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Fikirler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=ideas" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=ideas&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);" id="validate">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-4 col-md-4">
                            <label for="exampleSelect1">Durum<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "1")) {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($_POST[status] == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
                       </div>
                       <div class="form-group col-xs-12 col-sm-4 col-md-4">
                            <label for="exampleSelect1">Öne Çıkar<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="featured">
                                <?php if ((!$_POST[featured]) or ($_POST[featured] == "1")) {?>
                                    <option value="1" selected>Evet</option>
                                    <option value="0">Hayır</option>
                                <?php } ?>
                                <?php if ($_POST[featured] == "0"){?>
                                    <option value="1">Evet</option>
                                    <option value="0" selected>Hayır</option>
                                <?php } ?>
                            </select>
                       </div>
                        <div class="form-group col-xs-12 col-sm-4 col-md-4" id="location_selector">
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
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?=$_POST[title];?>" required>
                        </div>
                        
                       <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=$_POST[text];?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (aralarına virgül ',' yazınız. Örn.: kocaeli,haber,sitesi )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=$_POST[tags];?>" required>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Resmi<span class="text-danger">*</span></label>
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
            $featured   = mysqli_real_escape_string($connect, $_POST[featured]);
            $location_type   = mysqli_real_escape_string($connect, $_POST[location_type]);
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);
            $text   = mysqli_real_escape_string($connect, $_POST[text]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";

               //  $thumb_name = 'thumb_'.$new_name;
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
            $query1_string      = "UPDATE ideas SET 
            status = '$status', 
            featured = '$featured', 
            location_type = '$location_type', 
            title = '$title',
            text = '$text',
            tags = '$tags'
            $resim $resim2 WHERE id = '$_GET[id]'";
            // echo $query1_string;
            $query1_string_calistir = mysqli_query($connect, $query1_string);

            if ($location_type != 1) {
            $category_type = 4; // Havuza eklenecek kategori tipi "Haber"
                add_featured_pool($_GET[id],$location_type,$category_type);
            }
            else if($status == 0){
                remove_featured_pool($_GET[id], 4);
            }

            header("Location: ?page=ideas&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM ideas WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Fikirler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=ideas&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=ideas" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=ideas&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);" id="validate">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-4 col-md-4">
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
                       <div class="form-group col-xs-12 col-sm-4 col-md-4">
                            <label for="exampleSelect1">Öne Çıkar<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="featured">
                                <?php if ($query2->featured == "1") {?>
                                    <option value="1" selected>Evet</option>
                                    <option value="0">Hayır</option>
                                <?php } ?>
                                <?php if ($query2->featured == "0"){?>
                                    <option value="1">Evet</option>
                                    <option value="0" selected>Hayır</option>
                                <?php } ?>
                            </select>
                       </div>
                        <div class="form-group col-xs-12 col-sm-4 col-md-4" id="location_selector">
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
                       <?php if ($query2->location_type == 2) { ?>
                       
                       <div class="form-group col-xs-12" id="surMansetPhoto">
                            <label for="example-color-input" class=" col-form-label">Sürmanşet Fotoğrafı (Habere kapak fotoğrafı girmeyi unutmayın!..)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim2">
                            <p><img src="../images/upload/<?=$query2->image_sur?>" width="200px" ></p>

                        </div>
                       <?php } ?>
                        <div class="form-group col-xs-12 m-b-2">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->title))?>" required>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=stripslashes($query2->text)?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (aralarına virgül ',' yazınız. Örn.: kocaeli,haber,sitesi )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="tags" id="example-text-input" value="<?=stripslashes($query2->tags)?>" required>
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
            </div>
        </div>
    <?php } ?>
    