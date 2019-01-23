 <?php if ($_GET[action] == "edit") { ?>
                
                <?php if ($_POST[submit] == "Kaydet") {
            	
	            $name           = mysqli_real_escape_string($connect, $_POST[name]);
	            $email              = mysqli_real_escape_string($connect, $_POST[email]);

	            $user_created = usercontrol($email);
	            if ($user_created >= 1) {
                	header("Location: ?page=profile&action=edit&ok=usererror");
	            }
	            else{
            
	                /* //////////////// RESİM EKLEME  ////////////////*/
	                if ($_FILES[resim][name]) {
	                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
	                        $new_name = resimYukle($_FILES[resim][name],$fiup);
	                        $resim = ", picture = '$new_name'";
	                }
	                        
	                    $sorgu      = "update users set 
	                    name = '$name',                                     
	                    email = '$email'
	                    $resim where id = '$user_information->id'";
	                    // echo $sorgu;
	                    $sorgu_calistir = mysqli_query($connect, $sorgu);
	                    //Eski resim de temizlenir.
	                    unlink("<?php echo $pic_url?>/$_POST[resim_isim]");
	                    
	                    header("Location: ?page=profile&action=edit&ok=edit");
	                    echo mysqli_error();
	                 }
                }

                    ?>     		
	        <?php
	                // Düzenle
	        $sorgu        = "select * from users where id = '$user_information->id'";
	        $sorgu_calistir   = mysqli_query($connect, $sorgu);
	        $users         = mysqli_fetch_object($sorgu_calistir);
	        ?>
	         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Profil - Düzenle</h5>
            </div>
            <div class="card-block">
                <form class="form-horizontal" name="form" action="?page=profile&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Ad Soyad<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="example-text-input" value="<?php echo stripslashes($users->name)?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Email<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="example-text-input" value="<?php echo stripslashes($users->email)?>">
                        </div>
                       <div class="form-group col-xs-2">
                            <label for="example-text-input" class=" col-form-label">Şifre<span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-sm btn-default btn-block demo9"><span>Değiştir</span></button>

                        </div>

                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Fotoğraf<span class="text-danger">*</span></label>
							<input class="form-control focused" type="file" name="resim">
							<p><img src="<?php echo $pic_url?>/<?php echo $users->picture?>" width="200px" ></p>

                        </div>
                        
                        
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-primary" name="submit" value="Kaydet">KAYDET</button>
                        </div>
                    </div>
               </form>

            </div>
        </div>

	<?php } ?>					
			
