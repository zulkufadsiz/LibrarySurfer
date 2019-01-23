 <?php 
    if ($_GET[action] == "edit") {   ?>
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Diğer Dosyalar</h5>
            </div>
            <div class="card-block">
                <?php
                $islem = $_GET['doc_action'];
                switch($islem){
                case "": 
                ?>
                    <form method="post" action="?page=otherdocs&action=edit&id=1&doc_action=upload" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="example-color-input" class="col-form-label">Dosyalar</label><br>
                        <label class="control-label" for="focusedInput">Dosyaları (CTRL tuşu ile birden fazla yükleyebilirsiniz. Yüklenen dosyanın adı sitede GÖZÜKEN başlık olacaktır.)</label>
                        <div class="controls">
                        <span class="btn btn-default btn-file">
                            <input name="imagesUpload[]" type="file" min="1" max="3" multiple />
                        </span>                                     
                            <input class="btn btn-success" type="submit" value="Gönder">
                        </div>
                    </div>                                      
                    </form>
                <label class="control-label" for="focusedInput">Dosyaları Sıralayın (Dosyayı sürükleyip bırakarak sıralamayı değiştirebilirsiniz)</label>
                    <div class="form-group">    </div>              
                    <button class="btn btn-success about-doc-save">Sıralamayı Kaydet</button>      
                    <div id="response5"></div>
                    
                <div class="row">

                    <ul class="sortable-5">
                    <?php

                    $select = "SELECT * FROM about_other_docs WHERE doc_category = 1 ORDER by doc_ordering"; // select every element in the table in order by order column
                    $perform = mysqli_query($connect,  $select ); //perform selection query

                     while( $array = @mysqli_fetch_array( $perform ) ){ //download every row into array
                        $id = $array['doc_id'];
                        $title = $array['doc_title'];
                        $photo_name = $array['doc_path'];
                        ?>
                            <li id='item-<?php echo $id ?>' class="text-center"><img src="../images/upload/<?=$photo_name?>" alt=""><br><span><?php echo $title ?></span>
                            <a class="btn btn-danger" href="?page=otherdocs&action=edit&id=1&doc_action=resim_sil&doc_id=<?=$array['doc_id']?>" style="width:100%">Sil</a></li>

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
                        $img_title = $_FILES["imagesUpload"]["name"][$upload];
                        $img_title = explode('.', $img_title);
                        move_uploaded_file($img_source,$img_target.'/'.$img_name);
                        
                        $query = mysqli_query($connect, "INSERT INTO about_other_docs (doc_path, doc_title, doc_category) VALUES ('$img_name', '$img_title[0]', '1')");
                        header("Location: ?page=otherdocs&action=edit&id=1&ok=edit");
                    }else{//Resim seçilmemiþ ve hata var ise
                        header("Location: ?page=otherdocs&action=edit&id=1&ok=error");
                    }
                }
                break;

                case "resim_sil":
                $id = $_GET['doc_id'];
                $silincek_resim = mysqli_query($connect, "SELECT * FROM about_other_docs WHERE doc_id=$id");
                $silincek_resim_yeni = mysqli_fetch_array($silincek_resim);
                $sil = mysqli_query($connect, "DELETE FROM about_other_docs WHERE doc_id=$id");

                if($sil){
                header("Location: ?page=otherdocs&action=edit&id=1&ok=delete");
                @unlink($silincek_resim_yeni['picture_id']); 
                }else{
                header("Location: ?page=otherdocs&action=edit&id=1&ok=error");

                }
                break;
                }
                ?>                                  
            </div>
        </div>
    <?php } ?>