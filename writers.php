<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>         
<?php 
    if ($_GET[action] == "delete") {
	    $sil_sorgu     = "delete from writers where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=writers&ok=delete");
    }			
?>			
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazarlar</h5>
                <div class="card-icon pull-right">
                    <a href="?page=writers&amp;action=add" data-toggle="tooltip" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=writers" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                           <th>ID</th>
						   <th>Durum</th>
						   <th>İsim</th>
						   <th>E-Posta</th>
						   <th>Sıra</th>
						   <th>Fotoğraf</th>
						   <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
						$sorgu1        = "select * from writers order by name";
						$sorgu1_calistir   = mysqli_query($connect, $sorgu1);
						while ($writers = mysqli_fetch_object($sorgu1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$writers->id?></td>
                            <td class="center">
							<?php if ($writers->status == "1") { ?>
								<span class="tag tag-success">Aktif</span>
							<?php } ?>
							<?php if ($writers->status == "0") { ?>
								<span class="tag tag-danger">Pasif</span>
							<?php } ?>									

							</td>
							<td class="center"><?=$writers->name?></td>
							<td class="center"><?=$writers->email?></td>
							<td class="center"><?=$writers->ordering?></td>
							 <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$writers->picture?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=writers&action=edit&id=<?=$writers->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=writers&action=delete&id=<?=$writers->id;?>'>Evet</a>">
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
	            $status             = mysqli_real_escape_string($connect, $_POST[status]);
	            $ordering           = mysqli_real_escape_string($connect, $_POST[ordering]);
	            $password           = sha1(md5(mysqli_real_escape_string($connect, $_POST[password])));   
	            $name         		= mysqli_real_escape_string($connect, $_POST[name]);
                $email              = mysqli_real_escape_string($connect, $_POST[email]);
	            $text              = mysqli_real_escape_string($connect, $_POST[text]);
            
	            $user_created = usercontrol($email);
	            if ($user_created >= 1) {
                	header("Location: ?page=writers&action=add&ok=usererror");
	            }
	            else{

					/* //////////////// RESİM EKLEME  ////////////////*/
           		     if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                        $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",picture";
                        $resim_2 = ", '$new_name'";
	                }
	                        
	                $sorgu      = "insert into writers (status, ordering, password, name, text, email $resim_1) 
	                values('$status', '$ordering', '$password', '$name', '$text', '$email' $resim_2)";
	                        // echo $sorgu;
	                $sorgu_calistir = mysqli_query($connect, $sorgu);
	                header("Location: ?page=writers&ok=add");
	                echo mysqli_error();
	                die();
	           	 }
        	}

       		?>

       		 <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-plus"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazarlar - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=writers" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=writers&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="exampleSelect1">Durum</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ((!$_POST[status]) or ($_POST[status] == "1")) {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($_POST[status] == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
                       </div>
                    	<div class="form-group col-xs-12 col-md-3">
                            <label for="example-text-input">Sıra<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="ordering" value="<?=$_POST[ordering];?>">
                        </div>
                          <div class="form-group col-xs-12">
                            <label for="example-text-input">Ad Soyad<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" id="example-text-input" name="name" value="<?=$_POST[name];?>" required>
                        </div>
                           <div class="form-group col-xs-12">
                            <label for="example-text-input">Email<span class="text-danger">*</span></label>
                            <input class="form-control" type="email" id="example-text-input" name="email" value="<?=$_POST[email];?>" required>
                        </div>
                       <div class="form-group col-xs-12">
                            <label for="example-number-input">Şifre</label>
                            <input class="form-control" type="password" id="example-number-input" name="password" value="<?=$_POST[password];?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Yazar Hakkında<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=$_POST[text];?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-number-input">Fotoğraf</label>
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

          <?php if ($_GET[action] == "edit") { ?>
                
                  <?php if ($_POST[submit] == "Kaydet") {
            	
	            $status             = mysqli_real_escape_string($connect, $_POST[status]);
	            $ordering           = mysqli_real_escape_string($connect, $_POST[ordering]);
	            $name           	= mysqli_real_escape_string($connect, $_POST[name]);
                $email              = mysqli_real_escape_string($connect, $_POST[email]);
	            $text              = mysqli_real_escape_string($connect, $_POST[text]);

	            $user_created = usercontrol($email);
	            if ($user_created >= 1) {
                	header("Location: ?page=writers&action=edit&id=$_GET[id]&ok=usererror");
	            }
	            else{
            
	                /* //////////////// RESİM EKLEME  ////////////////*/
	                if ($_FILES[resim][name]) {
	                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
	                        $new_name = resimYukle($_FILES[resim][name],$fiup);
	                        $resim = ", picture = '$new_name'";
	                }
	                        
	                    $sorgu      = "update writers set 
	                    status = '$status', 
	                    ordering = '$ordering', 
                        name = '$name',                                     
	                    text = '$text',                                     
	                    email = '$email'
	                    $resim where id = '$_GET[id]'";
	                    // echo $sorgu;
	                    $sorgu_calistir = mysqli_query($connect, $sorgu);
	                    //Eski resim de temizlenir.
	                    unlink("../images/upload/$_POST[resim_isim]");
	                    
	                    header("Location: ?page=writers&action=edit&id=$_GET[id]&ok=edit");
	                    echo mysqli_error();
	                 }
                }

                    ?>     		
	        <?php
	                // Düzenle
	        $sorgu        = "select * from writers where id = '$_GET[id]'";
	        $sorgu_calistir   = mysqli_query($connect, $sorgu);
	        $writers         = mysqli_fetch_object($sorgu_calistir);
	        ?>
	         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Yazarlar - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=writers&amp;action=add" data-toggle="tooltip" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=writers" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=writers&action=edit&id=<?=$writers->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="exampleSelect1">Durum<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ($writers->status == "1") {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($writers->status == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
                       </div>
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="example-text-input">Sıra<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?=stripslashes($writers->ordering)?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input">Ad Soyad<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="example-text-input" value="<?=stripslashes($writers->name)?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input">Email<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="example-text-input" value="<?=stripslashes($writers->email)?>" required>
                        </div>
                       <div class="form-group col-xs-12 col-md-2">
                            <label for="example-text-input">Şifre</label>
                            <button type="button" class="btn btn-sm btn-default btn-block demo9"><span>Değiştir</span></button>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Yazar Hakkında<span class="text-danger">*</span></label>
                            <textarea class="mytextarea" name="text" rows="5"><?=stripslashes($writers->text)?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input">Fotoğraf<span class="text-danger">*</span></label>
							<input class="form-control focused" type="file" name="resim">
							<p><img src="../images/upload/<?=$writers->picture?>" width="200px" ></p>

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

