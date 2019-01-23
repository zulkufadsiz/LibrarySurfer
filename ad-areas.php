<?php 
session_start();
include 'inc/session.php'; ?>
<?php if ($user_information->level == 1): ?>                            
       
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Reklam Alanı</h5>
                <div class="card-icon pull-right">
                    <a href="?page=ad-areas" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block list-data-table">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Başlık</th>
                            <th>Tip</th>
                            <th>Şekil</th>
                            <th>Kullanılabilirlik</th>
                            <th>Konum</th>
                            <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query1_string        = "SELECT id, status, title, type, shape, availability, image FROM ad_areas ORDER BY id";
                        $query1_string_calistir   = mysqli_query($connect, $query1_string);
                        while ($query1 = mysqli_fetch_object($query1_string_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$query1->id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Aktif</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Pasif</span>
                            <?php } ?>                                  

                            </td>
                            <td class="center"><?=$query1->title?></td>

                            <td>
                            <?php
                            if ($query1->type == 1 ) {
                                echo "Tekli";
                            }
                            else{
                                echo "Çoklu";
                                }   
                            ?>
                            </td>

                            <td><?php 
                                    $query_string2 ="SELECT title FROM ad_shapes WHERE id = $query1->shape";
                                    // echo $query_string2;
                                    $query_string2_calistir = mysqli_query($connect, $query_string2);
                                    $query2 = mysqli_fetch_object($query_string2_calistir);
                                    echo $query2->title;?>
                                
                            </td>
                             <td class="center">
                            <?php if ($query1->availability == "1") { ?>
                                <span class="tag tag-success">Evet</span>
                            <?php } ?>
                            <?php if ($query1->availability == "0") { ?>
                                <span class="tag tag-danger">Hayır</span>
                            <?php } ?>                                  

                            </td>

                             <td class="center">
                                <a href="../images/upload/<?=$query1->image?>" title="Kapak Fotosu" target="_blank">Reklam Alanı Konumu </a>

                            </td>
                            <td class="center">
                                <a class="btn btn-info" href="?page=ad-areas&action=edit&id=<?=$query1->id?>">
                                    <i class="fa fa-edit "></i>  
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
    if ($_GET[action] == "edit") {   ?>
        <?php if ($_POST[submit] == "Kaydet") {
            $status   = mysqli_real_escape_string($connect, $_POST[status]);

            $query1_string      = "UPDATE ad_areas SET 
            status = '$status'
            WHERE id = '$_GET[id]'";
            // echo $query1_string;
            $query1_string_calistir = mysqli_query($connect, $query1_string);

            header("Location: ?page=ad-areas&action=edit&id=$_GET[id]&ok=edit");
            echo mysqli_error();
            }

        ?>          
        <?php
                // Düzenle
        $query_string2        = "SELECT * FROM ad_areas WHERE id = '$_GET[id]'";
        $query_string2_calistir   = mysqli_query($connect, $query_string2);
        $query2         = mysqli_fetch_object($query_string2_calistir);
        ?>   
         <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-edit"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Reklam Alanı - Düzenle</h5>
                <div class="card-icon pull-right">
                    <a href="?page=ad-areas" data-toggle="tooltip" data-placement="left" title="Tümünü Gör"><i class="fa fa-eye"></i></a>
                </div>  
            </div>
            <div class="card-block">
                <form class="form-horizontal" name="form" action="?page=ad-areas&action=edit&id=<?=$query2->id?>" method="POST" enctype="multipart/form-data" onsubmit="return checkform(this);" id="validate">
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="exampleSelect1">Durum (Dikkat! Bu özelliğin pasif olması bu alandaki reklamların gözükmemesine sebep olacaktır!..)</label>
                            <select class="form-control" id="exampleSelect1" name="status">
                                <?php if ($query2->status == "1") {?>
                                    <option value="1" selected>Aktif</option>
                                    <option value="0">Pasif</option>
                                <?php } ?>
                                <?php if ($query2->status == "0"){?>
                                    <option value="1">Aktif</option>
                                    <option value="0" selected>Pasif</option>
                                <?php } ?>
                            </select>
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
    