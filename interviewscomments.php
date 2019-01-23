    <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "DELETE FROM interviews_comments WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=interviewscomments&ok=delete");
        }           
    ?>
    <?php if ($_GET[action] == "check") {
            $query_string1      = "UPDATE interviews_comments SET 
            status = 1 
            WHERE id = '$_GET[id]'";
            // echo $query_string1;
            $query_string1_calistir = mysqli_query($connect, $query_string1);
            header("Location: ?page=interviewscomments&ok=edit");
        }           
    ?>            
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Roportaj Yorumları</h5>
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Durum</th>
                            <th>Tip</th>
                            <th>Adı</th>
                            <th>E-Mail</th>
                            <th>Yorum</th>
                            <th>Konu</th>
                            <th>Düzenle / Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT * FROM interviews_comments ORDER BY status,create_date desc";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$query1->id?></td>
                            <td class="center">
                            <?php if ($query1->status == "1") { ?>
                                <span class="tag tag-success">Yayında</span>
                            <?php } ?>
                            <?php if ($query1->status == "0") { ?>
                                <span class="tag tag-danger">Onay Bekliyor</span>
                            <?php } ?>                                  

                            </td>
                            <td>
                            <?php
                            if ($query1->parent_comment == 0 ) {
                                echo "Ana yorum";
                            }
                            else{
                                echo "Alt yorum";
                            }   
                            ?>
                            </td>
                            <td class="center"><?=$query1->name?></td>
                            <td><?=$query1->email?></td>
                            <td class="center">
                                <a href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Yorum" data-html="true" data-content="<p><?=$query1->comment?></p>">
                                    Yorumu Gör 
                                </a>
                            </td>
                            <td class="center"><a href="http://kocaelifikir.com/roportajlar/belirsiz/<?=$query1->item_id?>" target="_blank">İçeriğe Git</a></td>
                            <td class="center">
                                <?php
                                    if ($query1->status == 0 ) {  ?> 
                                     <a class="btn btn-success" href="?page=interviewscomments&action=check&id=<?=$query1->id?>">
                                    <i class="fa fa-check "></i>  
                                </a>
                                <?php } ?>
                                <a class="btn btn-danger pull-right" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=interviewscomments&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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
  