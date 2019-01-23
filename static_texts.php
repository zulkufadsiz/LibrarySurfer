 <?php 
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {

            //For Turkish languages
            $static_text_tr   = mysqli_real_escape_string($connect, $_POST[static_text_tr]);
            $static_text_tr = trim($static_text_tr);
            $static_text_tr = str_replace('\r\n','',$static_text_tr);
            $static_text_tr = str_replace('\n\r','',$static_text_tr);
            $static_text_tr = str_replace('\r','',$static_text_tr);
            $static_text_tr = str_replace('\n','',$static_text_tr);

            echo $sorgu      = "update static_texts set
            static_text_tr = '$static_text_tr'
            where id = '1'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    
            header("Location: ?page=statictexts&action=edit&ok=edit");
            echo mysqli_error();
            }
        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM static_texts WHERE id = '1'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);

        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Sabit Metinler</h5>
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=statictexts&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                     <div class="form-group col-xs-12" >
                           <h6 class="text-center m-b-1 m-t-1">Dikkat!!! Bu alanda yanlış yada eksik düzenleme yapılması sitenizdeki bazı alanların gözükmemesine sebep olabilir!!! (Yalnızca <b>=>Oklar Arasındaki<=</b> alanı düzenleyiniz. )</h6>
                                <div class="form-group col-xs-12">
                                    <label for="example-text-input" class=" col-form-label">Türkçe Sabit Metinler<span class="text-danger">*</span></label>
                                    <textarea name="static_text_tr" rows="7"><?php 
                                        $exploded_rows = explode("<=", $query2->static_text_tr);
                                        $numItems = count($exploded_rows);
                                        $i = 0;
                                        foreach ($exploded_rows as $key) {
                                            if(++$i === $numItems) {
                                                echo $key;
                                            }else{
                                                echo $key."<=&#13;&#10;";
                                                }
                                            }
                                         ?>
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>
            </div>
        </div>
    <?php } ?>