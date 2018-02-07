<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-12">
                        <h3 class="text-uppercase mt0">MINE VÆRDIBEVIS</h3>
                    </div>
                </div>
                <div class="row">
                    <?php if($tilbud){foreach($tilbud as $row){?>
                    <div class="item-deal col-sm-6">
                        <div class="deal-img">
                            <span class="cate-small"><?php echo $row->company;?></span>
                            <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=425&h=185&q=100" alt="" class="img-responsive"/>
                            <div class="deal-title3">
                                <h3><?php echo $row->name;?></h3>
                                <div><?php echo $row->description;?></div>
                            </div>
                        </div>
                        <div class="info-deal clearfix">
                            <div class="row">
                                <p class="total_number">
                                Antal: 1<a class="text-underline" href="<?php echo site_url('tilbud/detail/'.$row->product_id.'/'.seoUrl($row->name));?>">Se tilbud</a>
                                <a href="#">Udskriv tilbud</a>Indløst: <?php echo $row->codes;?> &nbsp;&nbsp;&nbsp;<?php if($row->used){ echo "Ja";}else{ echo "Nej";}?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php }}else{?>
                    <div class="item-deal col-sm-12">
                        <p>Der er ingen data!</p>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</section>