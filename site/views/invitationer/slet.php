<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="main_right">
                    <div class="del_reservation">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="breadcrumb">
                                    <li><a href="<?php echo site_url('invitationer/index')?>">Invitationer</a>
                                    </li>
                                    <li class="active">Slet reservation</li>
                                </ul>
                                <h3 class="text-uppercase">invitèr vip</h3>
                            </div>
                        </div>
                        <div class="row">
                            <?php if($tilbud){foreach($tilbud as $row){?>
                            <div class="col-md-6">
                                <div class="reservation_item">
                                    <div class="img_reservation_item">
                                        <a href="<?php echo site_url('tilbud/detail/'.$row->product_id.'/'.seoUrl($row->name));?>">
                                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                                        </a>
                                        <span class="cate_reservation"><?php echo $row->company;?></span>
                                        <div class="reservation_item_info">
                                            <h4><?php echo $row->name;?></h4>
                                            <div><?php echo $row->description;?></div>
                                        </div>
                                    </div>
                                    <div class="bottom_reservation clearfix">
                                        <a href="javascript:void(0)" onclick="selectTilbud('<?php echo $row->id;?>')" class="btn btnDel pull-right"><i class="fa fa-trash fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php }}else{?>
                            <div class="item-deal col-sm-12">
                                <p>Der er ingen data!</p>
                            </div>
                            <?php }?>
                            <input type="hidden" value="" name="tilbudDelete" id="tilbudDelete" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_invitationer').addClass('active');
});
</script>