<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "delete from slider where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=slider&ok=delete");
        }           
    ?>     
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Slider</h5>
                <div class="card-icon pull-right">
                    <a href="?page=slider&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=slider" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Sıra</th>
                            <th>Başlık</th>                                    
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, ordering, first_title_tr, second_title_tr ,image from slider order by create_date DESC";
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
                            <td><?php echo $query1->ordering?></td>
                            <td class="center"><?php echo $query1->first_title_tr." ".$query1->second_title_tr; ?></td>
                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='<?php echo $pic_url?>/<?php echo $query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=slider&action=edit&id=<?php echo $query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=slider&action=delete&id=<?php echo $query1->id;?>'>Evet</a>">
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
            
            //For Turkish languages
            $first_title_tr   = mysqli_real_escape_string($connect, $_POST[first_title_tr]);
            $second_title_tr   = mysqli_real_escape_string($connect, $_POST[second_title_tr]);
            $sub_title_tr   = mysqli_real_escape_string($connect, $_POST[sub_title_tr]);
            $button_one_title_tr   = mysqli_real_escape_string($connect, $_POST[button_one_title_tr]);
            $button_one_link_tr   = mysqli_real_escape_string($connect, $_POST[button_one_link_tr]);
            // $button_two_title_tr   = mysqli_real_escape_string($connect, $_POST[button_two_title_tr]);
            // $button_two_link_tr   = mysqli_real_escape_string($connect, $_POST[button_two_link_tr]);
    
            if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",image";
                        $resim_2 = ", '$new_name'";
            }
          

            $query_string1      = "INSERT INTO slider (status, ordering, first_title_tr, second_title_tr, sub_title_tr, button_one_title_tr, button_one_link_tr $resim_1) 
            VALUES('$status', '$ordering','$first_title_tr', '$second_title_tr', '$sub_title_tr', '$button_one_title_tr', '$button_one_link_tr' $resim_2)";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            $sonid = mysqli_insert_id($connect);
            // echo $kategori_sorgu;   
            header("Location: ?page=slider&action=edit&id=$sonid&ok=add");
            echo mysqli_error();
            die();
        }
     ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Slider - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=slider" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=slider&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <label for="exampleSelect1">Durum</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "0")) {?><option value="0" >Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                                <?php if ($_POST[status] == "1"){?><option value="0">Pasif</option><option value="1" selected>Aktif</option><?php } ?>
                            </select>
                       </div>
                         <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <label for="example-text-input">Sıra</label>
                            <input class="form-control" type="number" id="example-text-input" name="ordering" value="<?php echo $_POST[ordering];?>">
                        </div>
                    <!--   <div class="form-group col-xs-12 col-sm-3 col-md-3" id="location_selector">
                            <label for="exampleSelect1">Slider Tipi</label>
                            <select class="form-control" id="exampleSelect1" name="slider_type">
                                <?php
                                    // Kategoriler DB den çekilir.
                                $count9 = 1;
                                $sorgu9        = "SELECT * from slider_types where status = 1 order by id";
                                $sorgu_calistir9   = mysqli_query($connect, $sorgu9);
                                while ($sliders = mysqli_fetch_object($sorgu_calistir9)) { ?>
                                <option value="<?php echo $sliders->id ?>" <?php if ($count9 == 1) { echo "selected"; } ?> ><?php echo $sliders->title ?></option>
                                <?php 
                                $count9++;
                                } ?>
                            </select>
                       </div>  -->
                      <!--  <div class="form-group col-xs-12" id="title_1_tr">
                            <label for="example-text-input" class=" col-form-label">Üst Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?php echo $_POST[first_title_tr]  ?>">
                        </div> -->

                        <div class="form-group col-xs-12" id="title_2_tr">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="second_title_tr" value="<?php echo $_POST[second_title_tr];?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="sub_title_tr" value="<?php echo $_POST[sub_title_tr];?>" required>
                        </div>
                       <!--  <div class="form-group col-xs-6">
                            <label for="example-text-input" class=" col-form-label">Buton Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="button_one_title_tr" value="<?php echo $_POST[button_one_title_tr];?>" required>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="example-text-input" class=" col-form-label">Buton Link<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="button_one_link_tr" value="<?php echo $_POST[button_one_link_tr];?>" required>
                            <span> (örn. Tarayıcıda yazan link www.domain.com/alinacaklink/1 gibi ise yazacağınız link .com/ dan sonrası yani "alinacaklink/1" olmalı.)</span>
                        </div> -->
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Kapak Resmi (G*Y = 1920px * 650px)<span class="text-danger">*</span></label>
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
            
            //For Turkish languages
            $first_title_tr   = mysqli_real_escape_string($connect, $_POST[first_title_tr]);
            $second_title_tr   = mysqli_real_escape_string($connect, $_POST[second_title_tr]);
            $sub_title_tr   = mysqli_real_escape_string($connect, $_POST[sub_title_tr]);
            $button_one_title_tr   = mysqli_real_escape_string($connect, $_POST[button_one_title_tr]);
            $button_one_link_tr   = mysqli_real_escape_string($connect, $_POST[button_one_link_tr]);
            // $button_two_title_tr   = mysqli_real_escape_string($connect, $_POST[button_two_title_tr]);
            // $button_two_link_tr   = mysqli_real_escape_string($connect, $_POST[button_two_link_tr]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }

            $sorgu      = "update slider set 
            status = '$status',
            ordering = '$ordering',
            first_title_tr = '$first_title_tr',
            second_title_tr = '$second_title_tr',
            sub_title_tr = '$sub_title_tr',
            button_one_title_tr = '$button_one_title_tr',
            button_one_link_tr = '$button_one_link_tr'
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=slider&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
        // Düzenle
        $query_string2        = "SELECT * FROM slider WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Slider - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=slider&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=slider" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=slider&action=edit&id=<?php echo $query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
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
                        <div class="form-group col-xs-12 col-sm-6 col-md-6">
                            <label for="example-text-input" >Sıra</label>
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?php echo $query2->ordering?>">
                       </div>
                        <!-- <div class="form-group col-xs-12 col-sm-3 col-md-3" id="location_selector">
                            <label for="exampleSelect1">Slider Tipi</label>
                            <select class="form-control" id="exampleSelect1" name="slider_type">
                                <?php
                                    // Kategoriler DB' den çekilir.
                                $sorgu9        = "SELECT * from slider_types where status = 1 order by id";
                                $sorgu_calistir9   = mysqli_query($connect, $sorgu9);
                                while ($sliders = mysqli_fetch_object($sorgu_calistir9)) { ?>
                                <option value="<?php echo $sliders->id ?>" <?php if ($sliders->id == $query2->slider_type) { echo "selected"; } ?> ><?php echo $sliders->title ?></option>
                                <?php } ?>
                            </select>
                       </div>  -->
                        <!-- <div class="form-group col-xs-12" id="title_1_tr">
                            <label for="example-text-input" class=" col-form-label">Üst Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->first_title_tr)); ?>">
                        </div> -->

                        <div class="form-group col-xs-12" id="title_2_tr">
                            <label for="example-text-input" class=" col-form-label">Başlık</label>
                            <input class="form-control" type="text" id="example-text-input" name="second_title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->second_title_tr)); ?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık Altı Açıklama<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="sub_title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->sub_title_tr)); ?>" required>
                        </div>
                        <!-- <div class="form-group col-xs-6">
                            <label for="example-text-input" class=" col-form-label">Buton Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="button_one_title_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->button_one_title_tr)); ?>" required>
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="example-text-input" class=" col-form-label">Buton Link<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="button_one_link_tr" value="<?php echo str_replace(chr(34), "&quot;", stripslashes($query2->button_one_link_tr)); ?>" required>
                            <span> (örn. Tarayıcıda yazan link www.domain.com/alinacaklink/1 gibi ise yazacağınız link .com/ dan sonrası yani "alinacaklink/1" olmalı.)</span>
                        </div> -->
                         <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi (G*Y = 1920px * 650px)<span class="text-danger">*</span></label>
                            <input class="form-control focused" type="file" name="resim">
                            <p><img src="<?php echo $pic_url?>/<?php echo $query2->image?>" width="200px" ></p>

                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>


            </div>
        </div>
    <?php } ?>