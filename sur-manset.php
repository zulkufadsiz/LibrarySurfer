<!--     <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "delete from news where id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        //header("Location: ?page=news&ok=delete");
        }           
    ?>  -->         
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Sürmanşetler</h5>
            </div>
            <div class="card-block">
                <div class="row">
                  <div class="col-sm-2">
                    
                    <h3>Sürmanşet Alanı</h3>
                      <ul id="sortable1" class="connectedSortable">
                      <?php 
                          $sur_query = "SELECT * FROM featured_pool WHERE status = 1 AND location_type = 2 ORDER BY area_ordering";
                          $sur_query_run = mysqli_query($connect, $sur_query);
                          while($array = @mysqli_fetch_array( $sur_query_run )){ 
                            $ordering = $array['area_ordering'];
                            $category_type = $array['category_type'];
                            $item_id = $array['item_id'];
                            $id = $array['id'];

                            if ($category_type  == 1) {
                                  $query_string1        = "SELECT id,title,image,image_sur from news WHERE id = $item_id";
                                  $query_string1_calistir   = mysqli_query($connect, $query_string1);
                                  $query1 = mysqli_fetch_object($query_string1_calistir);
                            }
                            if ($category_type  == 2) {
                                  $query_string1        = "SELECT id,title ,image,image_sur from interviews WHERE id = $item_id";
                                  $query_string1_calistir   = mysqli_query($connect, $query_string1);
                                  $query1 = mysqli_fetch_object($query_string1_calistir);
                            }
                            if ($category_type  == 3) {
                                  $query_string1        = "SELECT id,title ,image,image_sur from corner_posts WHERE id = $item_id";
                                  $query_string1_calistir   = mysqli_query($connect, $query_string1);
                                  $query1 = mysqli_fetch_object($query_string1_calistir);
                            }
                            if ($category_type  == 4) {
                                  $query_string1        = "SELECT id,title ,image,image_sur from ideas WHERE id = $item_id";
                                  $query_string1_calistir   = mysqli_query($connect, $query_string1);
                                  $query1 = mysqli_fetch_object($query_string1_calistir);
                            }
                       ?>
                        <li id='item-<?php echo $id ?>'  class="<?php if($ordering <= 4 ){echo "ui-state-highlight"; }else{echo "ui-state-default";} ?> " title="<?=$query1->title ?>"><img style="width: 100%;" src="../images/upload/<?php if($query1->image_sur != ""){echo $query1->image_sur; }else{echo $query1->image;} ?>" alt=""></li>
                        
                        <?php } ?>
                      </ul>
                  </div>
                  <div class="col-md-1">
                    <i class="material-icons text-info" style="font-size: 80px;width: 100%;padding-top: 200px;">compare_arrows</i>
                  </div>
                  <div class="col-sm-2">

                     <h3>Kuyruktaki İçerikler</h3>
                      <ul id="sortable2" class="connectedSortable">
                      <?php 
                          $sur_query = "SELECT * FROM featured_pool WHERE status = 0 AND location_type = 2 ";
                          $sur_query_run = mysqli_query($connect, $sur_query);
                          while($array = @mysqli_fetch_array( $sur_query_run )){ 
                            $category_type = $array['category_type'];
                            $item_id = $array['item_id'];
                            $id = $array['id'];

                            if ($category_type  == 1) {
                                  $query_string2        = "SELECT id,title,category_id ,image,image_sur from news WHERE id = $item_id";
                                  $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                  $query2 = mysqli_fetch_object($query_string2_calistir);
                            }
                             if ($category_type  == 2) {
                                  $query_string2        = "SELECT id,title ,image,image_sur from interviews WHERE id = $item_id";
                                  $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                  $query2 = mysqli_fetch_object($query_string2_calistir);
                            }
                            if ($category_type  == 3) {
                                 $query_string2        = "SELECT id,title ,image,image_sur from corner_posts WHERE id = $item_id";
                                  $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                  $query2 = mysqli_fetch_object($query_string2_calistir);
                            }
                            if ($category_type  == 4) {
                                  $query_string2        = "SELECT id,title ,image,image_sur from ideas WHERE id = $item_id";
                                  $query_string2_calistir   = mysqli_query($connect, $query_string2);
                                  $query2 = mysqli_fetch_object($query_string2_calistir);
                            }
                       ?>
                        <li id='item-<?php echo $id ?>'  class="ui-state-default" title="<?=$query2->title ?>"><img style="width: 100%;" src="../images/upload/<?php if($query2->image_sur != ""){echo $query2->image_sur; }else{echo $query2->image;} ?>" alt=""></li>
                        <?php } ?>
                      </ul>
                    </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                  <div class="form-group">    </div>              
                  <button class="btn btn-success sur-manset-save">Sıralamayı Kaydet</button>      
                  <div id="response5"></div>
                  
                  </div>
                </div>

            </div>
        </div>
    <?php } ?> <!-- !action-->
   