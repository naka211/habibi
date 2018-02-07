<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-8">
                <div class="main_right">
                        <div class="mymessages clearfix">
                            <h3 class="text-uppercase">Mine beskeder</h3>
                            <?php if($list){foreach($list as $row){?>
                            <div class="row mymessages_row">
                                <div class="col-sm-4">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <a href="<?php echo site_url('user/messages/'.$row->id.'/'.seoUrl($row->name))?>">
                                                <?php if($row->avatar){?>
                                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $row->avatar;?>&w=35&h=35&q=100" alt="" class="img-responsive"/>
                                                <?php }else{?>
                                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>templates/img/no-avatar.jpg&w=35&h=35&q=100" alt="" class="img-responsive"/>
                                                <?php }?>
                                            </a>
                                        </div>
                                        <div class="col-xs-9">
                                            <p>
                                                <a href="<?php echo site_url('user/messages/'.$row->id.'/'.seoUrl($row->name))?>">
                                                    <span class="c660563"><?php echo $row->name;?></span>
                                                </a>
                                                <?php if($row->notSeen){?>
                                                <span class="red">(<?php echo $row->notSeen;?>)</span>
                                                <?php }?>
                                            </p>
                                            <p><?php echo getTimeDifference(strtotime($row->dt_create));?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <p class="mt10"><?php echo $row->message;?></p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="pull-right"><a href="<?php echo site_url('user/deleteMessage/'.$row->id);?>"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></a></p>
                                </div>
                            </div>
                            <?php }}?>
                            <div class="row">
                                <a href="javascript:void(0)" class="btn btn-block btnMore"><i class="fa fa-caret-down fa-lg" aria-hidden="true"></i> Se mere</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>