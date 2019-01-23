<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM representatives WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=representatives&ok=delete");
        }           
    ?>   
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Temsilcilikler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=representatives&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=representatives" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
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
                        $query_string1        = "SELECT id, status, title_tr, image from representatives order by create_date DESC";
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

                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>

                            <td class="center">
                                <a class="btn btn-info" href="?page=representatives&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=representatives&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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
            $query_string1      = "INSERT INTO representatives (status, ordering, title_tr, title_en, text_tr, text_en, tags $resim_1) 
            values('$status', '$ordering', '$title_tr', '$title_en', '$text_tr', '$text_en', '$tags' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=representatives&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Temsilcilikler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=representatives" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=representatives&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                            <input class="form-control" type="number" id="example-text-input" name="ordering" value="<?=$_POST[ordering];?>">
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
                                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?=$_POST[title_tr];?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_tr" rows="5"><?=$_POST[text_tr];?></textarea>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_en" value="<?=$_POST[title_en];?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_en" rows="5"><?=$_POST[text_en];?></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=$_POST[tags];?>" required>
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
           
            $sorgu      = "update representatives set 
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

            header("Location: ?page=representatives&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM representatives WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Temsilcilikler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=representatives&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=representatives" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=representatives&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?=$query2->ordering?>">
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
                                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->title_tr));?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_tr" rows="5"><?=str_replace(chr(34), "&quot;", stripslashes($query2->text_tr));?></textarea>
                                        </div>
                                        
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                    <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="title_en" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->title_en));?>" required>
                                        </div>
                                        
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Tam Açıklama<span class="text-danger">*</span></label>
                                            <textarea class="mytextarea" name="text_en" rows="5"><?=str_replace(chr(34), "&quot;", stripslashes($query2->text_en));?></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Etiketler (Aralarına virgül koyarak ayırınız)<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="tags" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->tags));?>" required>
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