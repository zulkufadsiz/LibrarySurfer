 <?php 
    if ($_GET[action] == "edit") {   ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Kalite Belgelerimiz</h5>
            </div>
            <div class="card-block">
              <!-- Çoklu Görsel Yükleme Betiği -->
                <?php
                $islem = $_GET['pp_action'];
                switch($islem){
                case "": 
                ?>
                    <form method="post" action="?page=qualitydocs&action=edit&id=1&pp_action=upload" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="example-color-input" class="col-form-label">Kalite Belgeleri</label><br>
                        <label class="control-label" for="focusedInput">İçerik Görselleri (CTRL tuşu ile birden fazla görsel yükleyebilirsiniz)</label>
                        <div class="controls">
                        <span class="btn btn-default btn-file">
                            <input name="imagesUpload[]" type="file" min="1" max="3" multiple />
                        </span>                                     
                            <input class="btn btn-success" type="submit" value="Gönder">
                        </div>
                    </div>                                      
                    </form>
                <label class="control-label" for="focusedInput">İçerik Görsellerini Sıralayın (Görseli sürükleyip bırakarak sıralamayı değiştirebilirsiniz)</label>
                    <div class="form-group">    </div>              
                    <button class="btn btn-success about-save">Sıralamayı Kaydet</button>      
                    <div id="response4"></div>
                    
                <div class="row">

                    <ul class="sortable-4">
                    <?php

                    $select = "SELECT * FROM about_pictures WHERE product_id = 1 ORDER by picture_ordering"; // select every element in the table in order by order column
                    $perform = mysqli_query($connect,  $select ); //perform selection query

                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                        $id = $array['picture_id'];
                        $title = $array['title'];
                        $photo_name = $array['picture_path'];
                        ?>
                            <li id='item-<?php echo $id ?>' class="text-center"><img src="../images/upload/<?php echo $photo_name ?>" alt=""><br><?php echo $title ?>
                            <a class="btn btn-danger" href="?page=qualitydocs&action=edit&id=1&pp_action=resim_sil&picture_id=<?=$array['picture_id']?>" style="width:100%">Sil</a></li>

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
                        
                        $query = mysqli_query($connect, "INSERT INTO about_pictures (picture_path, product_id) VALUES ('$img_name', '1')");
                        header("Location: ?page=qualitydocs&action=edit&id=1&ok=edit");
                    }else{//Resim seçilmemiþ ve hata var ise
                        header("Location: ?page=qualitydocs&action=edit&id=1&ok=error");
                    }
                }
                break;
                case "resim_sil":
                $id = $_GET['picture_id'];
                $silincek_resim = mysqli_query($connect, "SELECT * FROM about_pictures WHERE picture_id=$id");
                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                $sil = mysqli_query($connect, "DELETE FROM about_pictures WHERE picture_id=$id");

                if($sil){
                header("Location: ?page=qualitydocs&action=edit&id=1&ok=delete");
                @unlink($silincek_resim_yeni['picture_id']); 
                }else{
                header("Location: ?page=qualitydocs&action=edit&id=1&ok=error");

                }
                break;
                }
                ?>                                  

            </div>
        </div>
    <?php } ?>