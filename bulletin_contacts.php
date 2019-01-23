    <?php if ($_GET[action] == "delete") {

        $sil_sorgu     = "DELETE FROM bulletin WHERE id = $_GET[id]";
        $sil_exec      = mysqli_query($connect, $sil_sorgu);
        header("Location: ?page=newscomments&ok=delete");
        }           
    ?>
    <?php if (!$_GET[action]) { ?>      
        <div class="card">
            <div class="card-header b-a-0">
                <div class="card-icon pull-left">
                        <i class="fa fa-list"></i>
                </div>                      
                <h5 class="pull-left"> Sayfa: Bülten Abonelikleri</h5>
            </div>
            <div class="card-block">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <!-- <th>Adı</th> -->
                            <th>E-Mail</th>
                            <th>Kayıt Tarihi</th>
                            <th>Kaydı Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $query_string1        = "SELECT * FROM bulletin ORDER BY create_date desc";
                        $query_string1_calistir   = mysqli_query($connect, $query_string1);
                        while ($query1 = mysqli_fetch_object($query_string1_calistir)) {
                        ?>  
                        <tr role="row" class="odd">
                            <td><?=$query1->id?></td>
                            <!-- <td class="center"><?=$query1->name?></td> -->
                            <td><?=$query1->email?></td>
                            <td><?=dateformat4($query1->create_date)?></td>
                            <td class="center">
                                <a class="btn btn-danger pull-right" href="#" data-toggle="popover" data-trigger="focus hover" data-placement="left" title="Sil?" data-html="true" data-content="<a class='btn btn-danger' href='?page=newscomments&action=delete&id=<?=$query1->id;?>'>Evet</a>">
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
   