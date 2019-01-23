    <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "DELETE FROM treatments WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=treatments&ok=delete");
        }           
    ?>          
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Bölümler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=treatments&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=treatments" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Başlık</th>
                            <th>Sıra</th>
                            <th>Bölüm</th>
                            <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, title_tr, category_id, ordering, image FROM treatments ORDER BY id";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
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
                            <td class="center"><?=$query1->title_tr?></td>
                            <td><?=$query1->ordering?></td>
                            <td>
                                <?php
                                    // Kategoriler DB' den çekilir.
                                    $query_string2 ="SELECT title_tr FROM categories WHERE id = $query1->category_id";
                                    // echo $query_string2;
                                    $query_string2_calistir = mysqli_query($connect, $query_string2);
                                    $query2 = mysqli_fetch_object($query_string2_calistir);
                                    echo $query2->title_tr;
                                ?>
                            </td>
                            <!-- <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td> -->
                            <td class="center">
                                <a class="btn btn-info" href="?page=treatments&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=treatments&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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

            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $category_id = mysqli_real_escape_string($connect,$_POST[category_id]);
            $tags = mysqli_real_escape_string($connect, $_POST[tags]);

            //For Turkish languages

            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $text_tr   = mysqli_real_escape_string($connect, $_POST[text_tr]);
            
            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
            }

            $query_string1      = "INSERT INTO treatments (status, ordering, category_id, title_tr, text_tr, tags $resim_1) 
            values('$status', '$ordering', '$category_id','$title_tr','$text_tr', '$tags' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            header("Location: ?page=treatments&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
            }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Uygulanan Tedaviler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=treatments" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=treatments&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-sm-4 col-xs-12">
                            <label for="exampleSelect1">Durum</label>
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
                       <div class="form-group col-sm-4 col-xs-12">
                            <label for="example-number-input">Sıra</label>
                            <input class="form-control" type="number" id="example-number-input" name="ordering" value="<?=$_POST[ordering];?>">
                        </div>
                        <div class="form-group col-xs-12 col-sm-3">
                                    <label for="exampleSelect1">Bölüm<span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" id="exampleSelect1" required>
                                        <option value="0" disabled selected>Yok</option>
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string2        = "SELECT * FROM categories WHERE main_category = 0 ORDER BY title_tr";
                                        $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                        while ($query2 = mysqli_fetch_object($query_string2_calistir)) {
                                        ?>      
                                            <option value="<?=$query2->id?>"><?=$query2->title_tr?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?=$_POST[title_tr];?>" required>
                        </div>
                                    
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text_tr" rows="5"><?=$_POST[text_tr];?></textarea>
                        </div>
                        <!-- <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Resmi (G*Y = 1200px * 600px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim" required>
                        </div> -->
                        <div class="form-group col-xs-12 col-md-9">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=$_POST[tags];?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <p>Çoklu görsel eklemek için önce bu bilgileri kaydedin!..</p>
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
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $category_id   = mysqli_real_escape_string($connect, $_POST[category_id]);
            $tags   = mysqli_real_escape_string($connect, $_POST[tags]);

            //For Turkish languages
            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $text_tr   = mysqli_real_escape_string($connect, $_POST[text_tr]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }

            $query_string1      = "UPDATE treatments SET 
            status = '$status', 
            ordering = '$ordering', 
            category_id = '$category_id',
            tags = '$tags',
            title_tr = '$title_tr',
            text_tr = '$text_tr'
            $resim WHERE id = '$_GET[id]'";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            header("Location: ?page=treatments&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }
        ?>          
        <?php
        // Düzenle
        $query_string2        = "SELECT * FROM treatments WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                    <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Uygulanan Tedaviler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=treatments&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=treatments" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=treatments&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-sm-4 col-xs-12">
                            <label for="exampleSelect1" class=" col-form-label">Durum</label>
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
                       <div class="form-group col-sm-4 col-xs-12">
                            <label for="example-number-input" class=" col-form-label">Sıra</label>
                            <input class="form-control" type="number" name="ordering" id="example-number-input" value="<?=stripslashes($query2->ordering)?>">
                        </div>
                        <div class="form-group col-sm-3 col-xs-12">
                                    <label for="exampleSelect1">Bölüm<span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" id="exampleSelect1" required>
                                        <option value="0" disabled selected >Yok</option>
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string3        = "SELECT * FROM categories WHERE main_category = 0 ORDER BY title_tr";
                                        $query_string3_calistir   = mysqli_query($connect, $query_string3);
                                        while ($query3 = mysqli_fetch_object($query_string3_calistir)) {
                                        ?>      
                                            <option value="<?=$query3->id?>" <?php if ($query3->id == $query2->category_id): ?> selected <?php endif ?>><?=$query3->title_tr?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title_tr" id="example-text-input" value="<?=stripslashes($query2->title_tr)?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text_tr" rows="5"><?=str_replace(chr(34), "&quot;", stripslashes($query2->text_tr));?></textarea>
                        </div>
                        <!-- <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi (G*Y = 1200px * 600px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="../images/upload/<?=$query2->image?>" width="200px"></p>
                        </div> -->
                        <div class="form-group col-xs-12 col-md-9">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->tags));?>" required>
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
                    <form method="post" action="?page=treatments&action=edit&id=<?=$_GET['id']?>&pp_action=upload" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label" for="focusedInput">İçerik Görselleri (G*Y = 1200px * 600px olacak şekilde CTRL tuşu ile birden fazla görsel yükleyebilirsiniz)</label>
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
                    <button class="btn btn-success category-save">Sıralamayı Kaydet</button>      
                    <div id="response8"></div>
                    
                <div class="row">

                    <ul class="sortable-8">
                    <?php

                    $select = "SELECT * FROM treatment_pictures WHERE product_id = $_GET[id] ORDER by picture_ordering"; // select every element in the table in order by order column
                    $perform = mysqli_query($connect,  $select ); //perform selection query

                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                        $id = $array['picture_id'];
                        $title = $array['title'];
                        $photo_name = $array['picture_path'];
                        ?>
                            <li id='item-<?php echo $id ?>' class="text-center"><img src="../images/upload/<?php echo $photo_name ?>" alt=""><br><?php echo $title ?>
                            <a class="btn btn-danger" href="?page=treatments&action=edit&id=<?=$_GET[id]?>&pp_action=resim_sil&picture_id=<?=$array['picture_id']?>" style="width:100%">Sil</a></li>

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
                        
                        $query = mysqli_query($connect, "INSERT INTO treatment_pictures (picture_path, product_id) VALUES ('$img_name', '$_GET[id]')");
                        header("Location: ?page=treatments&action=edit&id=$_GET[id]&ok=edit");
                    }else{//Resim seçilmemiþ ve hata var ise
                        header("Location: ?page=treatments&action=edit&id=$_GET[id]&ok=error");
                    }
                }
                break;

                case "resim_sil":
                $id = $_GET['picture_id'];
                $silincek_resim = mysqli_query($connect, "SELECT * FROM treatment_pictures WHERE picture_id=$id");
                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                $sil = mysqli_query($connect, "DELETE FROM treatment_pictures WHERE picture_id=$id");

                if($sil){
                header("Location: ?page=treatments&action=edit&id=$_GET[id]&ok=delete");
                @unlink($silincek_resim_yeni['picture_id']); 
                }else{
                header("Location: ?page=treatments&action=edit&id=$_GET[id]&ok=error");

                }
                break;
                }
                ?>                                  
    




            </div>
        </div>
    <?php } ?>