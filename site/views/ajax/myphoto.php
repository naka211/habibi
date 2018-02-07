<?php if($list){foreach($list as $row){?>
<li id="show_images_<?php echo $row['id'];?>" class="portfolio isotope-item">
    <a class="portfolio_img" href="javascript:void(0)">
        <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/<?php echo $imageFolder;?>/<?php echo $row['image'];?>&w=150&h=150&q=100" alt="" class="img-responsive"/>
    </a>
    <a href="javascript:void(0)" onclick="deletedata('user_image','<?php echo $row['id'];?>','show_images_<?php echo $row['id'];?>');"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
</li>
<?php }}?>