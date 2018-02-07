<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-7">
                <div class="main_right">
                        <div class="mymessages clearfix">
                            <h3 class="text-uppercase">Mine beskeder</h3>
                            <div class="row mymessages_row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-xs-2">
                                            <span class="pull-left mr10"><i class="fa fa-angle-left fa-2x" aria-hidden="true"></i></span>
                                            <a href="<?php echo site_url('user/mymessages');?>">
                                                <?php if($item->avatar){?>
                                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $item->avatar;?>&w=35&h=35&q=100" alt="" class="img-responsive pull-left"/>
                                                <?php }else{?>
                                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>templates/img/no-avatar.jpg&w=35&h=35&q=100" alt="" class="img-responsive pull-left"/>
                                                <?php }?>
                                            </a>
                                        </div>
                                        <div class="col-xs-10 pad0">
                                            <p class="mt5"><span class="c660563"><?php echo $item->name;?></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <textarea name="message" id="message" class="form-control textarea_custom" rows="3" placeholder="..."></textarea>
                                <input type="hidden" name="user_to" id="user_to" value="<?php echo $item->id;?>" />
                            </div>
                            <div class="row">
                                <a href="javascript:void(0)" id="bntSendmes" class="btn btn-block btnMore">Send besked</a>
                            </div>
                            <div class="row mt15">
                                <div class="box_white clearfix" id="list-messages" style="height: 480px; overflow-y: auto;">
                                    <?php if($messages){foreach($messages as $row){?>
                                    <div class="row">
                                         <div class="col-sm-3">
                                            <h5><?php echo $row->name;?></h5>
                                            <p><?php echo getTimeDifference(strtotime($row->dt_create));?></p>
                                        </div>
                                        <div class="col-sm-9">
                                            <p><?php echo $row->message;?></p>
                                        </div>
                                    </div>
                                    <?php }}?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</section>