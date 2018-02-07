<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="w-item-deal mb0">
                    <h3 class="text-uppercase mt0">Godkendt datering af <?php echo $friend->name;?></h3>
                    <div class="row">
                        <?php if($list){foreach($list as $row){?>
                        <div class="col-sm-6 item-deal">
                            <div class="deal-img">
                                <?php if($row['company']){ ?><span class="cate-small"><?php echo $row['company'];?></span><?php }?>
                                <span class="vip_invation"><?php echo $row['name'];?></span>
                                <?php if($row['listimage']){?>
                                <div class="sync3 owl-carousel">
                                    <?php foreach($row['listimage'] as $rs){?>
                                    <div class="item">
                                        <a href="javascript:void(0)">
                                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/invita/<?php echo $rs->image;?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                                        </a>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php }else{ if($row['image']){?>
                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row['image'];?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                                <?php }else{?>
                                <div style="height: 185px; background: #252525;">&nbsp;</div>
                                <?php }}?>
                            </div>
                            <?php if($row['listimage']){?>
                            <div class="sync4 owl-carousel">
                                <?php foreach($row['listimage'] as $rs){?>
                                <div class="item"><a href="javascript:void(0)">
                                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/invita/<?php echo $rs->image;?>&w=73&h=47&q=100" alt="" class="img-responsive"/>
                                </a></div>
                                <?php }?>
                            </div>
                            <?php }?>
                            <div class="deal-title">
                                <h3><?php echo $row['title'];?></h3>
                                <div>
                                    <?php echo $row['description'];?>
                                </div>
                                <?php if($row['proID']){?>
                                <a href="<?php echo site_url('tilbud/detail/'.$row['proID'].'/'.seoUrl($row['proName']));?>" class="btn-link">LÆS MERE</a>
                                <?php }?>
                            </div>
                            <div class="info-deal clearfix">
                                <div class="row">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="time">
                                            <?php echo date('d/m/Y H:i', $row['accepted_time'])?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }}else{?>
                        <div class="col-sm-6 item-deal">
                            <p>Endnu ingen data!</p>
                        </div>
                        <?php }?>
                    </div>
                </div> 
            </div>  
        </div>
    </div>
</section>