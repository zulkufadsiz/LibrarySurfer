<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "DELETE FROM sp_author WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=author&ok=delete");
        }           
    ?>   
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazar</h5>
                <div class="card-icon pull-right">
                    <a href="?page=author&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=author" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Yazar Adı</th>                                    
                            <th>Uyruğu</th>                                    
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, nationality, title, image from sp_author order by create_date DESC";
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
                            <td class="center"><?php echo $query1->title?></td>
                            <td>
                                <?php
                                    // Kategoriler DB' den çekilir.
                                    $nationality = $query1->nationality;
                                    $query_string2 ="SELECT title FROM sp_nationality WHERE id = $nationality";
                                    // echo $query_string2;
                                    $query_string2_calistir = mysqli_query($connect, $query_string2);
                                    $query2 = mysqli_fetch_object($query_string2_calistir);
                                    echo $query2->title;

                                ?>
                            </td>
                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='assets/images/upload/<?php echo $query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=author&action=edit&id=<?php echo $query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=author&action=delete&id=<?php echo $query1->id;?>'>Evet</a>">
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
            $nationality   = mysqli_real_escape_string($connect, $_POST[nationality]);
            
            //For Turkish languages
           
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $description   = mysqli_real_escape_string($connect, $_POST[description]);

            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
            }
            $query_string1      = "INSERT INTO sp_author (status, ordering, title, description, nationality $resim_1) 
            values('$status', '$ordering', '$title', '$description', '$nationality' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=author&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazar - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=author" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=author&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                                    <label for="exampleSelect1">Uyruğu<span class="text-danger">*</span></label>
                                    <select class="form-control" name="nationality" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string2        = "SELECT * FROM sp_nationality";
                                        $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                        while ($query2 = mysqli_fetch_object($query_string2_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query2->id?>"><?php echo $query2->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Yazar Adı<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?php echo $_POST[title];?>" required>
                        </div>
                      
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Yazar Hakkında Bilgi (Kategori başlıkları Menüden Formats->Headings->Heading 1 olarak eklenmelidir.)<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="description" rows="5"><?php echo $_POST[description];?></textarea>
                        </div>
                                        
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Fotoğrafı (G*Y = 600px * 700px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
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
            $nationality   = mysqli_real_escape_string($connect, $_POST[nationality]);
            
            //For Turkish languages
           
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $description   = mysqli_real_escape_string($connect, $_POST[description]);
            $last_update = date('Y-m-d h:i:s');

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }
           
            $sorgu      = "update sp_author set 
            status = '$status', 
            ordering = '$ordering', 
            nationality = '$nationality', 
            title = '$title',
            last_update = '$last_update',
            description = '$description' 
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=author&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM sp_author WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazar - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=author&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=author" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=author&action=edit&id=<?php echo $query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                                    <label for="exampleSelect1">Uyruğu<span class="text-danger">*</span></label>
                                    <select class="form-control" name="nationality" id="exampleSelect1">
                                        <?php
                                        // Kategoriler DB' den çekilir.
                                        $query_string3        = "SELECT * FROM sp_nationality";
                                        $query_string3_calistir   = mysqli_query($connect, $query_string3);
                                        while ($query3 = mysqli_fetch_object($query_string3_calistir)) {
                                        ?>      
                                            <option value="<?php echo $query3->id?>" <?php if ($query3->id == $query2->nationality): ?> selected <?php endif ?>><?php echo $query3->title?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-sm-6 col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Yazar Adı<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->title));?>" required>
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
            </div>
        </div>
    <?php } ?>