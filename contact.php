<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>    
  <?php if ($_GET[action] == edit) { ?>
  <?php if ($_POST[submit] == "Kaydet") {
  
  $email   = mysqli_real_escape_string($connect, $_POST[email]);
  $phone   = mysqli_real_escape_string($connect, $_POST[phone]);
  $phone2   = mysqli_real_escape_string($connect, $_POST[phone2]);
  $phone3   = mysqli_real_escape_string($connect, $_POST[phone3]);
  $fax   = mysqli_real_escape_string($connect, $_POST[fax]);
  $address_tr   = mysqli_real_escape_string($connect, $_POST[address_tr]);
  $coordinates   = mysqli_real_escape_string($connect, $_POST[coordinates]);
  
  $sorgu      = "update contact set
  email = '$email',
  phone = '$phone',
  phone2 = '$phone2',
  phone3 = '$phone3',
  fax = '$fax',
  address_tr = '$address_tr',
  coordinates = '$coordinates'
  where id = '1'";
  // echo $sorgu;
  $sorgu_calistir = mysqli_query($connect, $sorgu);
  
  header("Location: ?page=contact&action=edit&ok=edit");
  echo mysqli_error();
  }
  ?>
  <?php
  $sorgu        = "select * from contact where id = '1'";
  $sorgu_calistir   = mysqli_query($connect, $sorgu);
  $contact         = mysqli_fetch_object($sorgu_calistir);
  ?>
   <div class="card">
        <div class="card-header b-a-0">
            <div class="card-icon pull-left">
                    <i class="fa fa-edit"></i>
            </div>                      
            <h5 class="pull-left"> Sayfa: İletişim</h5>
        </div>
        <div class="card-block">
            <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=contact&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                <div class="row">
                  <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">E-Mail<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="email" id="example-text-input" value="<?php echo stripslashes($contact->email)?>" required>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Telefon 1<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="phone" id="example-text-input" value="<?php echo stripslashes($contact->phone)?>" required>
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Telefon 2<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="phone2" id="example-text-input" value="<?php echo stripslashes($contact->phone2)?>">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Telefon 3<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="phone3" id="example-text-input" value="<?php echo stripslashes($contact->phone3)?>">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Fax<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="fax" id="example-text-input" value="<?php echo stripslashes($contact->fax)?>">
                    </div>
                     <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Adres<span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="address_tr" id="example-text-input" value="<?php echo stripslashes($contact->address_tr)?>" required>
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
