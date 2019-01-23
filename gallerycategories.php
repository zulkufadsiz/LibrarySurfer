    <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "DELETE FROM gallery_categories WHERE category_id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=gallerycategories&ok=delete");
        }           
    ?>          
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Galeri Kategorileri</h5>
                <div class="card-icon pull-right">
                    <a href="?page=gallerycategories&amp;action=add" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=gallerycategories" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
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
                            <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT category_id, title_tr, status, ordering FROM gallery_categories ORDER BY category_id";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?php echo $query1->category_id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  

                            </td>
                            <td class="center"><?php echo $query1->title_tr ?></td>
                            <td><?php echo $query1->ordering?></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=gallerycategories&action=edit&id=<?php echo $query1->category_id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=gallerycategories&action=delete&id=<?php echo $query1->category_id;?>'>Evet</a>">
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
            if ($ordering == 0) {
                $ordering = 9999;
            }
            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $title_en   = mysqli_real_escape_string($connect, $_POST[title_en]);

            $query_string1      = "insert into gallery_categories (status, ordering, title_tr, title_en) 
            values('$status', '$ordering', '$title_tr', '$title_en')";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            header("Location: ?page=gallerycategories&ok=add");
            echo mysqli_error();
            die();
            }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Galeri Kategorileri - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=gallerycategories" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=gallerycategories&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
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
                       <div class="form-group col-xs-12">
                            <label for="example-number-input" class=" col-form-label">Sıra</label>
                            <input class="form-control" type="number" id="example-number-input" name="ordering" value="<?php echo $_POST[ordering];?>">
                        </div>

                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?php echo $_POST[title_tr];?>" required>
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
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
             if ($ordering == 0) {
                $ordering = 9999;
            }
            $title_tr   = mysqli_real_escape_string($connect, $_POST[title_tr]);
            $title_en   = mysqli_real_escape_string($connect, $_POST[title_en]);

            $query_string1      = "UPDATE gallery_categories SET 
            status = '$status', 
            ordering = '$ordering', 
            title_tr = '$title_tr',
            title_en = '$title_en'
            WHERE category_id = '$_GET[id]'";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);

            header("Location: ?page=gallerycategories&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM gallery_categories WHERE category_id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Galeri Kategorileri - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=gallerycategories&amp;action=add" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=gallerycategories" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=gallerycategories&action=edit&id=<?php echo $query2->category_id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="exampleSelect1">Durum</label>
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
                       <div class="form-group col-xs-12">
                            <label for="example-number-input" class=" col-form-label">Sıra</label>
                            <input class="form-control" type="number" name="ordering" id="example-number-input" value="<?php echo stripslashes($query2->ordering)?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->title_tr));?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>

            </div>
        </div>
    <?php } ?>