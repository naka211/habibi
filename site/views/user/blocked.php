<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-8">
                <div class="main_right">
                    <div class="invitationer_box">
                        <h3 class="text-uppercase">Blokeret liste</h3>
                        <div class="row">
                            <?php if($userList){foreach($userList as $row){?>
                            <div class="col-md-3 col-xs-4 item_people">
                                <div class="img-people">
                                    <a class="box_img_people active" href="<?php echo site_url('user/profile/'.$row->id.'/'.seoUrl($row->name))?>">
                                        <?php echo modules::run('left/left/avatar',(object)$row, 150, 150);?>
                                    </a>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p class="name">
                                            <a href="<?php echo site_url('user/profile/'.$row->id.'/'.seoUrl($row->name))?>">
                                                <?php echo $row->name;?>
                                            </a>
                                        </p>
                                        <?php if($row->birthday){$yearold = date('Y',time()) - explode('/',$row->birthday)[2];}else{$yearold = "";}?>
                                        <p class="age">Age: <?php echo $yearold;?></p>
                                        <p class="postcode">Postnr. : <?php echo $row->code;?></p>
                                        <a href="<?php echo site_url('user/unblockUser/'.$row->id)?>" class="btn btn-block" value="<?php echo $row->id;?>">
                                            Fjerne blokeringen
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php }}else{?>
                            <div class="col-md-3 col-xs-4 item_people">
                                <p>Der er ingen data!</p>
                            </div>
                            <?php }?>
                        </div>
                        <div class="row text-center">
                          <ul class="pagination">
                            <?php echo $pagination;?>
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>