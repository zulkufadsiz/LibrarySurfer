 <?php 
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {
            //For Turkish languages
            $about_short_text_tr   = mysqli_real_escape_string($connect, $_POST[about_short_text_tr]);
            $about_text_tr   = mysqli_real_escape_string($connect, $_POST[about_text_tr]);
            // $vision_short_text_tr   = mysqli_real_escape_string($connect, $_POST[vision_short_text_tr]);
            $vision_text_tr   = mysqli_real_escape_string($connect, $_POST[vision_text_tr]);
            // $mission_short_text_tr   = mysqli_real_escape_string($connect, $_POST[mission_short_text_tr]);
            $mission_text_tr   = mysqli_real_escape_string($connect, $_POST[mission_text_tr]);

            if ($_FILES[resim][name]) {
            //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                $new_name = resimYukle($_FILES[resim][name],$fiup);
                $resim = ", image = '$new_name'";
            }
           
            $sorgu      = "update about set
            about_short_text_tr = '$about_short_text_tr',
            about_text_tr = '$about_text_tr',
            vision_text_tr = '$vision_text_tr',
            mission_text_tr = '$mission_text_tr'
            $resim where id = '1'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=about&action=edit&ok=edit");
            echo mysqli_error();
            }
        ?>          
        <?php
        // Düzenle
        $query_string2        = "SELECT * FROM about WHERE id = '1'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Hakkımızda</h5>
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=about&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Hakkımızda Kısa Açıklama<span class="text-danger">*</span></label>
                            <textarea name="about_short_text_tr" style="min-height: 150px;"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->about_short_text_tr));?></textarea>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Hakkımızda Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="about_text_tr" rows="3"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->about_text_tr));?></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Misyon Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="mission_text_tr" rows="3"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->mission_text_tr));?></textarea>
                        </div>
                        
                    </div>
                     <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Vizyon Tam Açıklama<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="vision_text_tr" rows="3"><?php echo str_replace(chr(34), "&quot;", stripslashes($query2->vision_text_tr));?></textarea>
                        </div>
                        
                    </div>
                     <div class="form-group col-sm-4 col-xs-12">
                        <label for="example-color-input" class=" col-form-label">Hakkımızda Görseli<span class="text-danger">*</span></label>
                        <input class="form-control focused" type="file" name="resim">
                        <p><img src="<?php echo $pic_url?>/<?php echo $query2->image?>" width="200px" ></p>
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                    </div>
               </form>
            </div>
        </div>
    <?php } ?>