<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM sp_books WHERE isbn = $_GET[isbn]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=books&ok=delete");
        }           
    ?>   
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Kitap</h5>
                <div class="card-icon pull-right">
                    <a href="?page=books&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=books" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ISBN</th>
                            <th>Durum</th>
                            <th>Kitap Adı</th>                                    
                            <th>Kategori</th> 
                            <th>Yazar</th>                                    
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT isbn, status, category_id, title, author_id, image from sp_books order by create_date DESC";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?php echo $query1->isbn?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  
                            </td>
                            <td class="center"><?php echo $query1->title?></td>
                            <td>
                                <?php
                                    // Kategoriler DB' den çekilir.
                                    $category = $query1->category_id;
                                    $query_string2 ="SELECT title FROM sp_categories WHERE id = $category";
                                    // echo $query_string2;
                                    $query_string2_calistir = mysqli_query($connect, $query_string2);
                                    $query2 = mysqli_fetch_object($query_string2_calistir);
                                    echo $query2->title;

                                ?>
                            </td>
                            <td>
                                <?php
                                    // Yazarlar DB' den çekilir.
                                    $author = $query1->author_id;
                                    $query_string2 ="SELECT title FROM sp_author WHERE id = $author";
                                    // echo $query_string2;
                                    $query_string2_calistir = mysqli_query($connect, $query_string2);
                                    $query2 = mysqli_fetch_object($query_string2_calistir);
                                    echo $query2->title;

                                ?>
                            </td>
                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='assets/images/upload/<?php echo $query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=books&action=edit&isbn=<?php echo $query1->isbn?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=books&action=delete&isbn=<?php echo $query1->isbn;?>'>Evet</a>">
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
            $isbn   = mysqli_real_escape_string($connect, $_POST[isbn]);
            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $category_id   = mysqli_real_escape_string($connect, $_POST[category_id]);
            $author   = mysqli_real_escape_string($connect, $_POST[author]);
           
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $description   = mysqli_real_escape_string($connect, $_POST[description]);

            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
            }
            $query_string1      = "INSERT INTO sp_books (isbn, status, ordering, category_id, author_id, title, description $resim_1) 
            values('$isbn' ,'$status', '$ordering', '$category_id', '$author', '$title', '$description' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);

            $query_string2 = "SELECT isbn FROM sp_books ORDER BY create_date DESC LIMIT 1 ";
            $query_string2_calistir = mysqli_query($connect, $query_string2);
            $result = mysqli_fetch_object($query_string2_calistir);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=books&action=edit&isbn=$result->isbn&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Kitap - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=books" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=books&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-3">
                                    <label for="exampleSelect1">Durum</label>
                                    <select class="form-control" id="exampleSelect1" name="status">
                                        <?php if ((!$_POST[status]) or ($_POST[status] == "0")) {?><option value="0" >Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                        <?php if ($_POST[status] == "1"){?><option value="0">Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                    </select>
                               </div>
                               <div class="form-group col-xs-12 col-sm-3" id="location_selector">
                                    <label for="example-text-input">Sıra</label>
                                    <input class="form-control" type="number" id="example-text-input" name="ordering" value="<?php echo $_POST[ordering];?>">
                               </div>
                               <div class="form-group col-xs-12 col-sm-3">
                                    <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string2        = "SELECT * FROM sp_categories ORDER BY title";
                                        $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                        while ($query2 = mysqli_fetch_object($query_string2_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query2->id?>"><?php echo $query2->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">ISBN<span class="text-danger">*</span></label>
                            <input class="form-control" maxlength="13" type="text" id="isbn" name="isbn" value="<?php echo $_POST[isbn];?>" required>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kitap Adı<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?php echo $_POST[title];?>" required>
                        </div>
                        <div class="form-group col-xs-12 col-sm-3">
                                    <label for="exampleSelect1">Yazar<span class="text-danger">*</span></label>
                                    <select class="form-control" name="author" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string2        = "SELECT * FROM sp_author ORDER BY title";
                                        $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                        while ($query2 = mysqli_fetch_object($query_string2_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query2->id?>"><?php echo $query2->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Tam Açıklama (Kategori başlıkları Menüden Formats->Headings->Heading 1 olarak eklenmelidir.)<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="description" rows="5"><?php echo $_POST[description];?></textarea>
                        </div>
                                        
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Fotoğrafı (G*Y = 600px * 700px)<span class="text-danger">*</span></label>
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
            $author   = mysqli_real_escape_string($connect, $_POST[author]);
            $isbn   = mysqli_real_escape_string($connect, $_POST[isbn]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            $category_id   = mysqli_real_escape_string($connect, $_POST[category_id]);
            
            //For Turkish languages
           
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $description   = mysqli_real_escape_string($connect, $_POST[description]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }

            $sorgu      = "update sp_books set 
            status = '$status', 
            ordering = '$ordering', 
            category_id = '$category_id',
            isbn = '$isbn', 
            author_id = '$author',
            title = '$title',
            description = '$description' 
            $resim where isbn = '$_GET[isbn]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=books&action=edit&isbn=$_GET[isbn]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM sp_books WHERE isbn = '$_GET[isbn]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Kitap - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=books&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=books" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=books&action=edit&isbn=<?php echo $query2->isbn?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="col-xs-12">
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
                                <div class="form-group col-sm-3 col-xs-12">
                                    <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string3        = "SELECT * FROM sp_categories  ORDER BY title";
                                        $query_string3_calistir   = mysqli_query($connect, $query_string3);
                                        while ($query3 = mysqli_fetch_object($query_string3_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query3->id?>" <?php if ($query3->id == $query2->category_id): ?> selected <?php endif ?>><?php echo $query3->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-4 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">ISBN<span class="text-danger">*</span></label>
                            <input class="form-control" maxlength="13"> type="text" id="example-text-input" name="isbn" value="<?php echo $query2->isbn?>" required>
                        </div>
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kitap Adı<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->title));?>" required>
                        </div>
                        <div class="form-group col-xs-12 col-sm-3">
                                    <label for="exampleSelect1">Yazar<span class="text-danger">*</span></label>
                                    <select class="form-control" name="author" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string4        = "SELECT * FROM sp_author ORDER BY title";
                                        $query_string4_calistir   = mysqli_query($connect, $query_string4);
                                        while ($query4 = mysqli_fetch_object($query_string4_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query4->id?>" <?php if ($query4->id == $query2->author_id): ?> selected <?php endif ?>><?php echo $query4->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="description" rows="5"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->description));?></textarea>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Fotoğrafı (G*Y = 600px * 700px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="assets/images/upload/<?php echo $query2->image?>" width="200px" ></p>

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
                    <form method="post" action="?page=books&action=edit&isbn=<?php echo $_GET['isbn']?>&pp_action=upload" enctype="multipart/form-data">
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
                    <button class="btn btn-success save">Sıralamayı Kaydet</button>      
                    <div id="response"></div>
                    
                <div class="row">

                    <ul class="sortable">
                    <?php

                    $select = "SELECT * FROM sp_book_pictures WHERE isbn = $_GET[isbn] ORDER by picture_ordering"; // select every element in the table in order by order column
                    $perform = mysqli_query($connect,  $select ); //perform selection query

                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                        $id = $array['picture_id'];
                        $title = $array['title'];
                        $photo_name = $array['picture_path'];
                        ?>
                            <li id='item-<?php echo $id ?>' class="text-center"><img src=<?php echo $pic_url;?>/<?php echo $photo_name ?> alt=""><br><?php echo $title ?>
                            <a class="btn btn-danger" href="?page=books&action=edit&isbn=<?php echo $_GET[isbn]?>&pp_action=resim_sil&picture_id=<?php echo $array['picture_id']?>" style="width:100%">Sil</a></li>

                        <?php
                      }

                    ?>
                    </ul>   
                                
                </div>                                  

                <?php
                break;

                case "upload"://upload string deðiþken deðerimiz
                foreach ($_FILES["imagesUpload"]["error"] as $upload => $error) {//Foreach döngüsü kurarak toplu seçimde array olaran gelen resimleri alýyoruz
                    if ($error == UPLOAD_ERR_OK) {//Resim seçilmiþ ve hata yok ise upload yap
                        $img_source = $_FILES["imagesUpload"]["tmp_name"][$upload];
                        $isimyeni = md5(date("Ymdhis").rand(111111,999999));
                        $img_name = $isimyeni.$_FILES["imagesUpload"]["name"][$upload];
                        
                        move_uploaded_file($img_source,$fiup.'/'.$img_name);
                        
                        $query = mysqli_query($connect, "INSERT INTO sp_book_pictures (picture_path, isbn, picture_status) VALUES ('$img_name', '$_GET[isbn]', '1')");
                        header("Location: ?page=books&action=edit&isbn=$_GET[isbn]&ok=edit");
                    }else{//Resim seçilmemiþ ve hata var ise
                        header("Location: ?page=books&action=edit&isbn=$_GET[isbn]&ok=error");
                    }
                }
                break;

                case "resim_sil":
                $id = $_GET['picture_id'];
                $silincek_resim = mysqli_query($connect, "SELECT * FROM sp_book_pictures WHERE picture_id=$id");
                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                $sil = mysqli_query($connect, "DELETE FROM sp_book_pictures WHERE picture_id=$id");

                if($sil){
                header("Location: ?page=books&action=edit&isbn=$_GET[isbn]&ok=delete");
                @unlink($silincek_resim_yeni['picture_id']); 
                }else{
                header("Location: ?page=books&action=edit&isbn=$_GET[isbn]&ok=error");

                }
                break;
                }
                ?>                                  
           


            </div>
        </div>
    <?php } ?>

    
     