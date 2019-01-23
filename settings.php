<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>    
<!--     <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "delete from settings where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        //header("Location: ?page=settings&ok=delete");
        }           
    ?>  -->         
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: SEO Optimizasyon</h5>
                <div class="card-icon pull-right">
                    <a href="?page=settings" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
							<th>ID</th>
							<th>Durum</th>
							<th>Başlık</th>                                    
							<th>Düzenle</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT id, status, title  from settings Where status = 1 order by title";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?php echo $query1->id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  
                            </td>
                            <td class="center"><?php echo $query1->title?></td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=settings&action=edit&id=<?php echo $query1->id?>">
                                    <i class="fa fa-edit "></i>  
                                </a>
                                <!-- <a class="btn btn-danger" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=settings&action=delete&id=<?php echo $query1->id;?>'>Evet</a>">
                                    <i class="fa fa-trash-o "></i> 
                                </a> -->
                            </td>
                        </tr>
                       <?php } ?>
                   </tbody>
                </table>
            </div>
        </div>
    <?php } ?> <!-- !action-->
     <?php 
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {
            $title   = mysqli_real_escape_string($connect, $_POST[title]);
            $meta_title   = mysqli_real_escape_string($connect, $_POST[meta_title]);
            $meta_description   = mysqli_real_escape_string($connect, $_POST[meta_description]);
            $meta_keywords   = mysqli_real_escape_string($connect, $_POST[meta_keywords]);

            $sorgu      = "update settings set 
            title = '$title',
            meta_title = '$meta_title',
            meta_description = '$meta_description', 
            meta_keywords = '$meta_keywords'
            $resim where id = '$_GET[id]'";
            // echo $sorgu;
            $sorgu_calistir = mysqli_query($connect, $sorgu);    
        
            header("Location: ?page=settings&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM settings WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: SEO Optimizasyon - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=settings" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form id="checkForm" data-toggle="validator" role="form" class="form-horizontal" name="form" action="?page=settings&action=edit&id=<?php echo $query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);">
                    <div class="row">
                    
                        <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Başlık<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title" id="example-text-input" value="<?php echo stripslashes($query2->title)?>" required>
                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Meta Title<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="meta_title" id="example-text-input" value="<?php echo stripslashes($query2->meta_title)?>" required>
                        </div>
                          <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Meta Açıklama<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="meta_description" rows="3" required><?php echo stripslashes($query2->meta_description)?></textarea>

                        </div>
                         <div class="form-group col-xs-12">
                            <label for="example-text-input" class=" col-form-label">Meta Keywords (aralarına virgül ',' yazınız. Örn.: kocaeli,haber,sitesi )<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="meta_keywords" id="example-text-input" value="<?php echo stripslashes($query2->meta_keywords)?>" required>
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
    