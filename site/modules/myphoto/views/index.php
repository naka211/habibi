<div class="col-lg-12">
    <div id="mypicture" class="owl-carousel mypicture">
        <?php if($list){foreach($list as $row){?>
        <div class="item">
            <a class="fancybox" rel="gallery_myphoto" href="<?php echo base_url();?>uploads/photo/<?php echo $row->image;?>">
                <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/photo/<?php echo $row->image;?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
            </a>
        </div>
        <?php }}?>
    </div>
</div>