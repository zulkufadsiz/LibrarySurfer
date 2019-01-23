<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>         
  <?php if ($_GET[action] == "edit") { ?>
      <?php if ($_POST[submit] == "Kaydet") {
            	
	            $text       = mysqli_real_escape_string($connect, $_POST[text]);

                $sorgu      = "update identity set 
                text = '$text'                                     
                where id = 1 ";
                // echo $sorgu;
                $sorgu_calistir = mysqli_query($connect, $sorgu);
                //Eski resim de temizlenir.
                
                header("Location: ?page=identity&action=edit&ok=edit");
                echo mysqli_error();
	                 }

                    ?>     		
	        <?php
	                // Düzenle
	        $sorgu        = "select * from identity where id = 1";
	        $sorgu_calistir   = mysqli_query($connect, $sorgu);
	        $identity         = mysqli_fetch_object($sorgu_calistir);
	        ?>
	         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                    <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Künye</h5>
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=identity&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">İçerik<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=stripslashes($identity->text)?></textarea>

                        </div>
                        
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>

            </div>
        </div>

	<?php } ?>					
<?php endif ?>

