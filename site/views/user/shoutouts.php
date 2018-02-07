<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="main_right">
                    <div class="mymessages clearfix">
                        <h3 class="text-uppercase">Se shoutouts</h3>
                        <div class="row mymessages_row">
                            <div class="col-lg-12">
                                <?php if(!empty($shoutouts)){?>
                                <div class="table-responsive table_seeShoutout">
                                    <table class="table table-bordered table-hover table-striped">
                                        <tbody>
                                        <thead>
                                        <tr>
                                            <th>Indhold</th>
                                            <th>Aktiv tid</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <?php foreach($shoutouts as $shoutout){
                                            $time = strtotime($shoutout->dt_update);
                                            ?>
                                        <tr>
                                            <td width="50%">
                                                <?php echo $shoutout->content;?>
                                            </td>
                                            <td><p><span class="dates"><?php echo date("d.m.Y", $time);?></span> <span class="times">Kl.<?php echo date("H:i", $time);?></span></p></td>
                                            <td><?php echo $shoutout->status ? "Aktiv":"Inaktiv";?></td>
                                            <td><a class="btnDelete" href="javascript:void(0);" onclick="deleteShoutout(<?php echo $shoutout->id?>);"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php } else {echo "Der er ingen data!";}?>
                                <a href="<?php echo site_url('user/createShoutout')?>" class="btn btn-block btnMore text-uppercase"><i class="fa fa-plus-square-o fa-lg" aria-hidden="true"></i> Opret en shoutout (koster kr. 10)</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>