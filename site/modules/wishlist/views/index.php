<div class="col-md-6">
    <div class="row">
        <div class="col-sm-2 text-center">
            <img src="<?php echo base_url();?>templates/img/i_cart.png" alt=""/>
            <p class="count"><?php if($list){echo count($list);}else{echo '0';}?></p>
        </div>
        <div class="col-sm-10">
            <ul class="list_buy">
                <?php if($list){foreach($list as $row){?>
                <li>
                    <a class="hovertips" data-tip="<?php echo $row->name;?>" href="<?php echo site_url('tilbud/detail/'.$row->id.'/'.seoUrl($row->name));?>">
                        <img class="img-responsive" src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/product/<?php echo $row->image;?>&w=63&h=63&q=100" alt=""/>
                    </a>
                </li>
                <?php }}?>
            </ul>
        </div>
    </div>
</div>