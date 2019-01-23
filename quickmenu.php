<?php if ($_GET[action] == "delete") {
        $sil_sorgu     = "delete from quick_menu where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=quickmenu&ok=delete");
        }           
    ?>     
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hızlı Erişim Menüsü</h5>
                <div class="card-icon pull-right">
                    <!-- <a href="?page=quickmenu&amp;action=add" title="Yeni Ekle"><i class="fa fa-plus"></i></a> -->
                    <a href="?page=quickmenu" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sıra</th>
                            <th>Başlık</th>                                    
                            <th>Görsel</th>
                            <th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, ordering, first_title_tr, image from quick_menu order by create_date DESC";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$query1->id?></td>
                            <td><?=$query1->ordering?></td>
                            <td class="center"><?=$query1->first_title_tr; ?></td>
                            <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$query1->image?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=quickmenu&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=quickmenu&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {
            //General Texts
            $ordering   = mysqli_real_escape_string($connect, $_POST[ordering]);
            if ($ordering == "") {
                $ordering = 9999;
            }
            //For Turkish languages
            $first_title_tr   = mysqli_real_escape_string($connect, $_POST[first_title_tr]);
            $button_one_link_tr   = mysqli_real_escape_string($connect, $_POST[button_one_link_tr]);

            //For English language
            $first_title_en   = mysqli_real_escape_string($connect, $_POST[first_title_en]);
            $button_one_link_en   = mysqli_real_escape_string($connect, $_POST[button_one_link_en]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }

            $sorgu      = "update quick_menu set 
            ordering = '$ordering',
            first_title_tr = '$first_title_tr',
            button_one_link_tr = '$button_one_link_tr',
            first_title_en = '$first_title_en',
            button_one_link_en = '$button_one_link_en'
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=quickmenu&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }
        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM quick_menu WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hızlı Erişim Menüsü - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=quickmenu" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=quickmenu&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-3 col-md-3">
                            <label for="example-text-input" >Sıra</label>
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?=$query2->ordering?>">
                       </div>
                        <div class="form-group col-xs-12" >
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="first_title_tr" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->first_title_tr)); ?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Link<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="button_one_link_tr" value="<?=str_replace(chr(34), "&quot;", stripslashes($query2->button_one_link_tr)); ?>" required>
                            <span> (örn. Tarayıcıda yazan link www.domain.com/alinacaklink/1 gibi ise yazacağınız link .com/ dan sonrası yani "alinacaklink/1" olmalı.)</span>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-color-input" class=" col-form-label">Kapak Resmi<span class="text-danger">*</span>(G*Y = 1050px * 750px)</label>
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