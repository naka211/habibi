<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$item->id);?>
            <div class="col-md-8">
                <div class="main_right">
                    <div class="invitationer_box">
                        <div class="row">
                            <div class="col-md-12 mb15">
                                <h3 class="text-uppercase"><?php echo $item->name;?></h3>
                            </div>
                            <div class="col-md-12 mb15 pl0 pr0">
                                <div class="col-md-6">
                                <?php if(isGoldMember()){?>
                                    <img src="<?php echo base_url(); ?>uploads/btn_goldmember.png" alt="" class="img-responsive">
                                <?php } else {?>
                                    <img src="<?php echo base_url(); ?>uploads/btn_freemember.png" alt="" class="img-responsive">
                                <?php }?>
                                </div>
                                <div class="col-md-6">
                                    <?php if(!isGoldMember()){?>
                                        <a href="<?php echo site_url('user/upgrade');?>" class="btn btnPositive2 active"><span class="btnPositive_content">Upgrade to Gold Member</span></a>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo site_url('user/update');?>" class="btn btnGray3">Redigér min profil</a>
                            </div>
                            <div class="col-md-6">
                                <a href="<?php echo site_url('invitationer/index');?>" class="btn btnGray3">Opret invitation</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php if($item->expired_at){?>
                                    <h4><i>Udløbet: <?php echo date('d/m/Y', $item->expired_at);?></i></h4>
                                    <h4><i>Stå ved guld medlem: <?php echo $item->stand_by_payment?'Ja':'Nej';?></i></h4>
                                <?php }?>
                                <p><?php echo $item->slogan;?></p>
                            </div>
                        </div>
                        <div class="row">
                            <!--<div class="col-md-9 box_info_highline col-xs-offset-right-2 col-xs-12">-->
                            <div class="col-md-12 box_info_highline col-xs-12">
                                <div class="col-md-6 col-sm-6">
                                    <?php if($item->birthday){$yearold = date('Y',time()) - explode('/',$item->birthday)[2];}else{$yearold = "";}?>
                                    <p><strong>Alder</strong>: <?php echo $yearold;?> år</p>
                                    <p><strong>Forhold</strong>: <?php echo $item->relationship;?></p>
                                    <p><strong>Etnisk oprindelse</strong>: <?php echo $item->ethnic_origin;?></p>
                                    <p><strong>Uddannelse</strong>: <?php echo $item->training;?></p>
                                    <p><strong>Postnr</strong>: <?php echo $item->code;?></p>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <p><strong>Køn</strong>: <?php if($item->gender==1){echo "Kvinde";}else if($item->gender==2){echo "Mand";}else{echo "";}?></p>
                                    <p><strong>Børn</strong>: <?php echo $item->children;?></p>
                                    <p><strong>Religion</strong>: <?php echo $item->religion;?></p>
                                    <p><strong>Kropsbygning</strong>: <?php echo $item->body;?></p>
                                    <p><strong>Ryger</strong>: <?php echo $item->smoking;?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="text-uppercase">mine events</h3>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa fa-check green" aria-hidden="true"></i> Købte</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa fa-heart red" aria-hidden="true"></i> Ønskeliste</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="zeduuce_box clearfix">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-sm-2 text-center">
                                            <img src="<?php echo base_url();?>templates/img/i_cart.png" alt="">
                                            <p class="count"><?php if($tilbud){echo count($tilbud);}else{echo "0";}?></p>
                                        </div>
                                        <div class="col-sm-10">
                                            <ul class="list_buy">
                                                <?php if($tilbud){foreach($tilbud as $row){?>
                                                <li>
                                                    <a class="hovertips" data-tip="<?php echo $row->name;?>" href="<?php echo site_url('tilbud/detail/'.$row->product_id.'/'.seoUrl($row->name));?>">
                                                        <img class="img-responsive" src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=63&h=63&q=100" alt=""/>
                                                    </a>
                                                </li>
                                                <?php }}?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!--Box wishlist-->
                                <?php echo modules::run('wishlist/wishlist/index',$item->id);?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="text-uppercase">MIT LIV I BILLEDER</h3>
                            </div>
                            <div class="col-sm-6">
                                <a href="<?php echo site_url('user/myphoto')?>" class="btn-link pull-right">Tilføj nyt billede</a>
                            </div>
                            <!--Box My photo-->
                            <?php echo modules::run('myphoto/myphoto/index',$item->id);?>
                        </div>
                        <div class="row mt30">
                            <div class="col-lg-12">
                                <h3 class="text-uppercase">Instagram billeder</h3>
                            </div>
                            <div class="col-lg-12">
                                <div id="instagram_photo" class="owl-carousel mypicture">
                                    
                                    <div class="item">
                                        <a class="fancybox" rel="gallery1" href="<?php echo base_url();?>templates/img/img07.jpeg"><img src="<?php echo base_url();?>templates/img/img07_small.jpg" alt="" class="img-responsive"></a>
                                    </div>
                                    <div class="item">
                                        <a class="fancybox" rel="gallery1" href="<?php echo base_url();?>templates/img/img07.jpeg"><img src="<?php echo base_url();?>templates/img/img07_small.jpg" alt="" class="img-responsive"></a>
                                    </div>
                                    <div class="item">
                                        <a class="fancybox" rel="gallery1" href="<?php echo base_url();?>templates/img/img07.jpeg"><img src="<?php echo base_url();?>templates/img/img07_small.jpg" alt="" class="img-responsive"></a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_minprofil').addClass('active');
});
</script>