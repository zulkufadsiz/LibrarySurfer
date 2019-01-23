<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM services WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=services&ok=delete");
        }           
    ?>   
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hizmetler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=services&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=services" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Başlık</th>                                    
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, title_tr, image from services order by create_date DESC";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                       
                        <tr role="row" class="odd">
                            <td><?php echo $query1->id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  
                            </td>
                            <td class="center"><?php echo $query1->title_tr?></td>

                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?php echo $query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>

                            <td class="center">
                                <a class="btn btn-info" href="?page=services&action=edit&id=<?php echo $query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=services&action=delete&id=<?php echo $query1->id;?>'>Evet</a>">
                                    <i class="fa fa-trash-o "></i> 
                                </a>
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

            //General Texts
            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);
            
            //For Turkish languages
            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $text_tr   = mysqli_real_escape_string($connect, $_POST[text_tr]);

            //For English language
            $title_en   = mysqli_real_escape_string($connect, $_POST[title_en]);
            $text_en   = mysqli_real_escape_string($connect, $_POST[text_en]);
            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
            }
            $query_string1      = "INSERT INTO services (status, ordering, title_tr, title_en, text_tr, text_en, tags $resim_1) 
            values('$status', '$ordering', '$title_tr', '$title_en', '$text_tr', '$text_en', '$tags' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=services&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hizmetler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=services" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=services&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Durum</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "0")) {?><option value="0" >Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                <?php if ($_POST[status] == "1"){?><option value="0">Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                            </select>
                       </div>
                      
                       <div class="form-group col-xs-12 col-sm-3 col-md-3" id="location_selector">
                            <label for="example-text-input">Sıra</label>
                            <input class="form-control" type="number" id="example-text-input" name="ordering" value="<?php echo $_POST[ordering];?>">
                       </div>

                       <div class="form-group col-xs-12" >

                           <h6 class="text-center m-b-1 m-t-1">İçerik Detayları</h6>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#one" role="tab">Türkçe</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#two" role="tab">English</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="one" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?php echo $_POST[title_tr];?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_tr" rows="5"><?php echo $_POST[text_tr];?></textarea>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_en" value="<?php echo $_POST[title_en];?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_en" rows="5"><?php echo $_POST[text_en];?></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?php echo $_POST[tags];?>" required>
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
            //General Texts
            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);
            
            //For Turkish languages
            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $text_tr   = mysqli_real_escape_string($connect, $_POST[text_tr]);

            //For English language
            $title_en   = mysqli_real_escape_string($connect, $_POST[title_en]);
            $text_en   = mysqli_real_escape_string($connect, $_POST[text_en]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }
           
            $sorgu      = "update services set 
            status = '$status', 
            ordering = '$ordering', 
            tags = '$tags', 
            title_tr = '$title_tr',
            text_tr = '$text_tr', 
            title_en = '$title_en', 
            text_en = '$text_en'
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=services&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM services WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hizmetler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=services&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=services" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=services&action=edit&id=<?php echo $query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                            <label for="exampleSelect1">Sıra</label>
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?php echo $query2->ordering?>">
                       </div>
                     <div class="form-group col-xs-12" >

                           <h6 class="text-center m-b-1 m-t-1">İçerik Detayları</h6>
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#one" role="tab">Türkçe</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#two" role="tab">English</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="one" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->title_tr));?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_tr" rows="5"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->text_tr));?></textarea>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_en" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->title_en));?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_en" rows="5"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->text_en));?></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->tags));?>" required>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="../images/upload/<?php echo $query2->image?>" width="200px" ></p>

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
                    <form method="post" action="?page=services&action=edit&id=<?php echo $_GET['id']?>&pp_action=upload" enctype="multipart/form-data">
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
                    <button class="btn btn-success services-save">Sıralamayı Kaydet</button>      
                    <div id="response3"></div>
                    
                <div class="row">

                    <ul class="sortable-3">
                    <?php

                    $select = "SELECT * FROM services_pictures WHERE product_id = $_GET[id] ORDER by picture_ordering"; // select every element in the table in order by order column
                    $perform = mysqli_query($connect,  $select ); //perform selection query

                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                        $id = $array['picture_id'];
                        $title = $array['title'];
                        $photo_name = $array['picture_path'];
                        ?>
                            <li id='item-<?php echo $id ?>' class="text-center"><img src="../images/upload/<?php echo $photo_name ?>" alt=""><br><?php echo $title ?>
                            <a class="btn btn-danger" href="?page=services&action=edit&id=<?php echo $_GET[id]?>&pp_action=resim_sil&picture_id=<?php echo $array['picture_id']?>" style="width:100%">Sil</a></li>

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
                        
                        $query = mysqli_query($connect, "INSERT INTO services_pictures (picture_path, product_id) VALUES ('$img_name', '$_GET[id]')");
                        header("Location: ?page=services&action=edit&id=$_GET[id]&ok=edit");
                    }else{//Resim seçilmemiþ ve hata var ise
                        header("Location: ?page=services&action=edit&id=$_GET[id]&ok=error");
                    }
                }
                break;

                case "resim_sil":
                $id = $_GET['picture_id'];
                $silincek_resim = mysqli_query($connect, "SELECT * FROM services_pictures WHERE picture_id=$id");
                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                $sil = mysqli_query($connect, "DELETE FROM services_pictures WHERE picture_id=$id");

                if($sil){
                header("Location: ?page=services&action=edit&id=$_GET[id]&ok=delete");
                @unlink($silincek_resim_yeni['picture_id']); 
                }else{
                header("Location: ?page=services&action=edit&id=$_GET[id]&ok=error");

                }
                break;
                }
                ?>                                  




            </div>
        </div>
    <?php } ?>