<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM announcements WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=announcements&ok=delete");
        }           
    ?>   
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Duyurular</h5>
                <div class="card-icon pull-right">
                    <a href="?page=announcements&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=announcements" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
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
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, category_id, writer_id,title_tr, image from announcements WHERE writer_id = 0 order by create_date DESC";
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
                            <td class="center">
                                <?php 
                                $post_category_id = $query1->category_id;
                                $query_string3       = "SELECT id,title_tr from announcement_categories where id = '$post_category_id'";
                                $query_string3_calistir   = mysqli_query($connect, $query_string3);
                                $query3 = mysqli_fetch_object($query_string3_calistir);
                                 if($query1->category_id == 0) {
                                    echo "Genel";
                                 } else {
                                   echo $query3->title_tr; 
                                 }?>

                            </td>
                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?php echo $query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>

                            <td class="center">
                                <a class="btn btn-info" href="?page=announcements&action=edit&id=<?php echo $query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=announcements&action=delete&id=<?php echo $query1->id;?>'>Evet</a>">
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
            $category_id = mysqli_real_escape_string($connect, $_POST[category_id]);
            if($category_id == "") {
                $category_id = 0 ;
            }
            $writer_id =    mysqli_real_escape_string($connect, $_POST[writer_id]);
            if($writer_id == "") {
                $writer_id = 0 ;
            }
            
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
            $query_string1      = "INSERT INTO announcements (status, ordering, category_id, writer_id, title_tr, title_en, text_tr, text_en, tags $resim_1) 
            values('$status', '$ordering','$category_id','$writer_id', '$title_tr', '$title_en', '$text_tr', '$text_en', '$tags' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=announcements&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Duyurular - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=announcements" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=announcements&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                       <div class="form-group col-xs-12 col-sm-3">
                        
                                    <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                                    <select class="form-control" name="category_id" id="post_category_select" required>
                                        <option value="0" disabled selected>Kategori Seçiniz</option>
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string2        = "SELECT * FROM announcement_categories WHERE status = 1 ORDER BY title_tr";
                                        $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                        while ($query2 = mysqli_fetch_object($query_string2_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query2->id?>"><?php echo $query2->title_tr?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                        
                       <div class="form-group col-xs-12" >

                           <h6 class="text-center m-b-1 m-t-1">İçerik Detayları</h6>
                           <!--  <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#one" role="tab">Türkçe</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#two" role="tab">English</a></li>
                            </ul> -->
                            <div class="tab-content">
                                <div class="tab-pane active" id="one" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?php echo $_POST[title_tr];?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_tr" rows="5" required><?php echo $_POST[text_tr];?></textarea>
                                        </div>
                                        
                                    </div>

                                </div>
                                <!-- <div class="tab-pane" id="two" role="tabpanel">
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
                                </div> -->
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?php echo $_POST[tags];?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Resmi (G*Y = 1200px * 600px)<span class="text-danger">*</span></label>
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
            $category_id = mysqli_real_escape_string($connect, $_POST[category_id]);
           
            $writer_id =    mysqli_real_escape_string($connect, $_POST[writer_id]);
            if($writer_id == "") {
                $writer_id = 0 ;
            }
            
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
           
            $sorgu      = "update announcements set 
            status = '$status', 
            ordering = '$ordering', 
            category_id = '$category_id',
            writer_id = '$writer_id',
            tags = '$tags', 
            title_tr = '$title_tr',
            text_tr = '$text_tr', 
            title_en = '$title_en', 
            text_en = '$text_en'
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=announcements&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM announcements WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Duyurular - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=announcements&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=announcements" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=announcements&action=edit&id=<?php echo $query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                        <div class="form-group col-xs-12 col-sm-3">
                            <label for="exampleSelect1">Kategori<span class="text-danger">*</span></label>
                            <select class="form-control" name="category_id" id="post_category_select" >
                                <option value="0" disabled selected>Kategori seçiniz.</option>
                                <?php
                                // Kategoriler DB' den çekilir.
                                $query_string3        = "SELECT * FROM announcement_categories WHERE status = 1 ORDER BY title_tr";
                                $query_string3_calistir   = mysqli_query($connect, $query_string3);
                                while ($query3 = mysqli_fetch_object($query_string3_calistir)) {
                                    ?>
                                     <option value="<?php echo $query3->id?>" <?php if ($query3->id == $query2->category_id): ?> selected <?php endif ?>><?php echo $query3->title_tr?></option>
                                <?php } ?>
                            </select>
                        </div>
                            
                        
                     <div class="form-group col-xs-12" >

                           <h6 class="text-center m-b-1 m-t-1">İçerik Detayları</h6>
                            <ul class="nav nav-tabs" role="tablist">
                                <!-- <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#one" role="tab">Türkçe</a></li> -->
                                <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#two" role="tab">English</a></li>-->
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
                                <!--<div class="tab-pane" id="two" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_en" value="<?/*=str_replace(chr(34), "&quot;", stripslashes($query2->title_en));*/?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_en" rows="5"><?/*=str_replace(chr(34), "&quot;", stripslashes($query2->text_en));*/?></textarea>
                                        </div>
                                        
                                    </div>
                                </div>-->
                            </div>
                        </div>  
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->tags));?>" required>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi (G*Y = 1200px * 600px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="../images/upload/<?php echo $query2->image?>" width="200px" ></p>

                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>

            </div>
        </div>
    <?php } ?>