<!-- <?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "delete from whyus where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=whyus&ok=delete");
        }           
    ?>    -->  
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Neden Biz?</h5>
                <div class="card-icon pull-right">
                    <!-- <a href="?page=whyus&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a> -->
                    <a href="?page=whyus" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Sıralama</th>
                            <th>Başlık</th>                                    
                            <th>İkon</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, ordering, first_title_tr, image from whyus order by create_date DESC";
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
                            <td class="center"><?=$query1->ordering; ?></td>
                            <td class="center"><?=$query1->first_title_tr; ?></td>
                            <td class="center"><i class='<?=$query1->image; ?> text-success'></i></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=whyus&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <!-- <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=whyus&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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

            //General Texts
            $status   = mysqli_real_escape_string($connect, $_POST[status]);
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 999;
            }
            //For Turkish languages
            $first_title_tr   = mysqli_real_escape_string($connect, $_POST[first_title_tr]);
            $sub_title_tr   = mysqli_real_escape_string($connect, $_POST[sub_title_tr]);
            //For English language
            $first_title_en   = mysqli_real_escape_string($connect, $_POST[first_title_en]);
            $sub_title_en   = mysqli_real_escape_string($connect, $_POST[sub_title_en]);
            $icon   = mysqli_real_escape_string($connect, $_POST[icon]);
    

            $query_string1      = "INSERT INTO whyus (status, ordering, first_title_tr, sub_title_tr, first_title_en, sub_title_en, image) 
            VALUES('$status', '$ordering', '$first_title_tr', '$sub_title_tr', '$first_title_en', '$sub_title_en', '$icon')";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=whyus&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                   <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Neden Biz? - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=whyus" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=whyus&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="exampleSelect1">Durum</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "0")) {?><option value="0" >Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                <?php if ($_POST[status] == "1"){?><option value="0">Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                            </select>
                       </div>
                         <div class="form-group col-xs-12 col-sm-3 col-md-3">
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
                                        <div class="form-group col-xs-6">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?=$_POST[first_title_tr];?>" required>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="sub_title_tr" value="<?=$_POST[sub_title_tr];?>" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                   <div class="row">
                                       <div class="form-group col-xs-6">
                                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="first_title_en" value="<?=$_POST[first_title_en];?>" required>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="sub_title_en" value="<?=$_POST[sub_title_en];?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-6" id="title_1_tr">
                             <label for="icon" class=" col-form-label">İkon<span class="text-danger">*</span> <span class="text-info"><a href="http://rhythm.nikadevs.com/content/icons-et-line" target="_blank" title="">İkon listesi</a></span></label>
                             <input class="form-control" type="text" id="example-text-input" name="icon" value="<?=$_POST[icon];?>" required>
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
                $ordering = 999;
            }
            //For Turkish languages
            $first_title_tr   = mysqli_real_escape_string($connect, $_POST[first_title_tr]);
            $sub_title_tr   = mysqli_real_escape_string($connect, $_POST[sub_title_tr]);
            //For English language
            $first_title_en   = mysqli_real_escape_string($connect, $_POST[first_title_en]);
            $sub_title_en   = mysqli_real_escape_string($connect, $_POST[sub_title_en]);
            $icon   = mysqli_real_escape_string($connect, $_POST[icon]);

            $sorgu      = "update whyus set 
            status = '$status',
            ordering = '$ordering',
            first_title_tr = '$first_title_tr',
            sub_title_tr = '$sub_title_tr',
            first_title_en = '$first_title_en',
            sub_title_en = '$sub_title_en',
            image = '$icon'
            where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=whyus&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM whyus WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Neden Biz? - Düzenle</h5>
                <div class="card-icon pull-right">
                    <!-- <a href="?page=whyus&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a> -->
                    <a href="?page=whyus" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=whyus&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
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
                            <label for="example-text-input" >Sıra</label>
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
                                            <label for="example-text-input" class=" col-form-label">Başlık 1<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->first_title_tr)); ?>" required>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="sub_title_tr" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->sub_title_tr)); ?>" required>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="two" role="tabpanel">
                                   <div class="row">
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık 1<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="first_title_en" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->first_title_en)); ?>" required>
                                        </div>
                                        <div class="form-group col-xs-12">
                                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                                            <input class="form-control" type="text" id="example-text-input" name="sub_title_en" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->sub_title_en)); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group col-xs-12">
                             <label for="icon" class=" col-form-label">İkon<span class="text-danger">*</span> <span class="text-info"><a href="http://rhythm.nikadevs.com/content/icons-et-line" target="_blank" title="">İkon listesi</a></span></label>
                             <input class="form-control" type="text" id="example-text-input" name="icon" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->image)); ?>" required>
                             <i class='edit-page-icon flaticon <?=$query2->image; ?> text-success' style="::before font-size: 34px;" ></i>
                         </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>


            </div>
        </div>
    <?php } ?>