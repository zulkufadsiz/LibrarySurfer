<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>         
<?php 
    if ($_GET[action] == "delete") {
	    $sil_sorgu     = "delete from reporters where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=reporters&ok=delete");
    }			
?>			
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Muhabirler</h5>
                <div class="card-icon pull-right">
                    <a href="?page=reporters&amp;action=add" data-toggle="tooltip" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=reporters" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
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
						$sorgu1        = "select * from reporters order by name";
						$sorgu1_calistir   = mysqli_query($connect, $sorgu1);
						while ($reporters = mysqli_fetch_object($sorgu1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$reporters->id?></td>
                            <td class="center">
							<?php if ($reporters->status == "1") { ?>
								<span class="tag tag-success">Aktif</span>
							<?php } ?>
							<?php if ($reporters->status == "0") { ?>
								<span class="tag tag-danger">Pasif</span>
							<?php } ?>									

							</td>
							<td class="center"><?=$reporters->name?></td>
							<td class="center"><?=$reporters->email?></td>
							<td class="center"><?=$reporters->ordering?></td>
							 <td class="center"><a href="#" data-toggle="popover" data-trigger="hover" data-placement="left" title="Görsel" data-html="true" data-content="<img src='../images/upload/<?=$reporters->picture?>' class='img-responsive' alt='' style='width: 200px;'>">Görsel</a></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=reporters&action=edit&id=<?=$reporters->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=reporters&action=delete&id=<?=$reporters->id;?>'>Evet</a>">
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
            
	            $user_created = usercontrol($email);
	            if ($user_created >= 1) {
                	header("Location: ?page=reporters&action=add&ok=usererror");
	            }
	            else{

					/* //////////////// RESİM EKLEME  ////////////////*/
           		     if ($_FILES[resim][name]) {
                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
                        $new_name = resimYukle($_FILES[resim][name],$fiup);
                        $resim_1 = ",picture";
                        $resim_2 = ", '$new_name'";
	                }
	                        
	                $sorgu      = "insert into reporters (status, ordering, password, name, email $resim_1) 
	                values('$status', '$ordering', '$password', '$name', '$email' $resim_2)";
	                        // echo $sorgu;
	                $sorgu_calistir = mysqli_query($connect, $sorgu);
	                header("Location: ?page=reporters&ok=add");
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
                <h5 class="pull-left"> Sayfa: Muhabirler - Ekleme</h5>
                <div class="card-icon pull-right">
                    <a href="?page=reporters" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=reporters&action=add" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="exampleSelect1">Durum<span class="text-danger">*</span></label>
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
                    	<div class="form-group col-xs-3">
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

	            $user_created = usercontrol($email);
	            if ($user_created >= 1) {
                	header("Location: ?page=reporters&action=edit&id=$_GET[id]&ok=usererror");
	            }
	            else{
            
	                /* //////////////// RESİM EKLEME  ////////////////*/
	                if ($_FILES[resim][name]) {
	                    //////////////////////////////////////////   RESİM UPLOAD İŞLEMİ ////////////////////////////////////////////////////         
	                        $new_name = resimYukle($_FILES[resim][name],$fiup);
	                        $resim = ", picture = '$new_name'";
	                }
	                        
	                    $sorgu      = "update reporters set 
	                    status = '$status', 
	                    ordering = '$ordering', 
	                    name = '$name',                                     
	                    email = '$email'
	                    $resim where id = '$_GET[id]'";
	                    // echo $sorgu;
	                    $sorgu_calistir = mysqli_query($connect, $sorgu);
	                    //Eski resim de temizlenir.
	                    unlink("../images/upload/$_POST[resim_isim]");
	                    
	                    header("Location: ?page=reporters&action=edit&id=$_GET[id]&ok=edit");
	                    echo mysqli_error();
	                 }
                }

                    ?>     		
	        <?php
	                // Düzenle
	        $sorgu        = "select * from reporters where id = '$_GET[id]'";
	        $sorgu_calistir   = mysqli_query($connect, $sorgu);
	        $users         = mysqli_fetch_object($sorgu_calistir);
	        ?>
	         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Muhabirler - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=reporters&amp;action=add" data-toggle="tooltip" data-placement="left" title="Yeni Ekle"><i class="fa fa-plus"></i></a>
                    <a href="?page=reporters" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=reporters&action=edit&id=<?=$users->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                        <div class="form-group col-xs-12 col-md-3">
                            <label for="exampleSelect1">Durum<span class="text-danger">*</span></label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ($users->status == "1") {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($users->status == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
                       </div>
                        <div class="form-group col-xs-3">
                            <label for="example-text-input">Sıra<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="ordering" id="example-text-input" value="<?=stripslashes($users->ordering)?>">
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input">Ad Soyad<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="name" id="example-text-input" value="<?=stripslashes($users->name)?>" required>
                        </div>
                        <div class="form-group col-xs-12">
                            <label for="example-text-input">Email<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="email" id="example-text-input" value="<?=stripslashes($users->email)?>" required>
                        </div>
                       <div class="form-group col-xs-12 col-md-2">
                            <label for="example-text-input">Şifre<span class="text-danger">*</span></label>
                            <button type="button" class="btn btn-sm btn-default btn-block demo9"><span>Değiştir</span></button>

                        </div>

                         <div class="form-group col-xs-12">
                            <label for="example-text-input">Fotoğraf<span class="text-danger">*</span></label>
							<input class="form-control focused" type="file" name="resim">
							<p><img src="../images/upload/<?=$users->picture?>" width="200px" ></p>

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

