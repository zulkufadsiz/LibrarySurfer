 <?php 
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {

            //For Turkish languages
            $text_tr   = mysqli_real_escape_string($connect, $_POST[text_tr]);
            //For English language
            $text_en   = mysqli_real_escape_string($connect, $_POST[text_en]);

            $sorgu      = "update human_resources set
            text_tr = '$text_tr',
            text_en = '$text_en'
            where id = '1'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    

            header("Location: ?page=humanresources&action=edit&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM human_resources WHERE id = '1'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: İnsan Kaynakları</h5>
               
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=humanresources&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">İnsan Kaynakları Açıklama (Bölüm başlıkları Menüden Formats->Headings->Heading 1 olarak eklenmelidir.)<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text_tr" rows="3"><?=str_replace(chr(34), "&quot;", stripslashes($query2->text_tr));?></textarea>
                        </div>
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>

            </div>
        </div>
    <?php } ?>