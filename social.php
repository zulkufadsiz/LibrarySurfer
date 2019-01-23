<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>    

  <?php if ($_GET[action] == edit) { ?>
  <?php if ($_POST[submit] == "Kaydet") {
  
  $facebook   = mysqli_real_escape_string($connect, $_POST[facebook]);
  $twitter   = mysqli_real_escape_string($connect, $_POST[twitter]);
  $youtube   = mysqli_real_escape_string($connect, $_POST[youtube]);
  $linkedin   = mysqli_real_escape_string($connect, $_POST[linkedin]);
  $pinterest   = mysqli_real_escape_string($connect, $_POST[pinterest]);
  $instagram   = mysqli_real_escape_string($connect, $_POST[instagram]);
  
  $sorgu      = "update social set
  facebook = '$facebook',
  twitter = '$twitter',
  youtube = '$youtube',
  linkedin = '$linkedin',
  pinterest = '$pinterest',
  instagram = '$instagram'
  where id = '1'";
  // echo $sorgu;
  $sorgu_calistir = mysqli_query($connect, $sorgu);
  
  header("Location: ?page=social&action=edit&ok=edit");
  echo mysqli_error();
  }
  ?>
  <?php
  $sorgu        = "select * from social where id = '1'";
  $sorgu_calistir   = mysqli_query($connect, $sorgu);
  $social         = mysqli_fetch_object($sorgu_calistir);
  ?>
   <div class="card">
        <div class="card-header b-a-0">
            <div class="card-icon pull-left">
                    <i class="fa fa-edit"></i>
            </div>                      
            <h5 class="pull-left"> Sayfa: Sosyal Medyalar</h5>
        </div>
        <div class="card-block">
            <form class="form-horizontal" name="form" action="?page=social&action=edit" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                <div class="row">
                     <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Facebook</label>
                        <input class="form-control" type="text" name="facebook" id="example-text-input" value="<?php echo stripslashes($social->facebook)?>">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Twitter</label>
                        <input class="form-control" type="text" name="twitter" id="example-text-input" value="<?php echo stripslashes($social->twitter)?>">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Youtube</label>
                        <input class="form-control" type="text" name="youtube" id="example-text-input" value="<?php echo stripslashes($social->youtube)?>">
                    </div>
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Linked In</label>
                        <input class="form-control" type="text" name="linkedin" id="example-text-input" value="<?php echo stripslashes($social->linkedin)?>">
                    </div>
                    <!-- <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Pinterest</label>
                        <input class="form-control" type="text" name="pinterest" id="example-text-input" value="<?php echo stripslashes($social->pinterest)?>">
                    </div> -->
                    <div class="form-group col-xs-12">
                        <label for="example-text-input" class=" col-form-label">Instagram</label>
                        <input class="form-control" type="text" name="instagram" id="example-text-input" value="<?php echo stripslashes($social->instagram)?>">
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
