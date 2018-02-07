<?php if($user->facebook){
    $facebookLink = 'https://graph.facebook.com/'.$user->facebook.'/picture?type=square&width='.$width.'&height='.$height.'&redirect=false';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $facebookLink);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($ch);
    $output = json_decode($output);
    if(isset($output->error)){
        $img = base_url().'templates/img/no-avatar.jpg';
    } else {
        $img = $output->data->url;
    }
    ?>
    <img src="<?php echo $img?>" alt="" class="img-responsive"/>
<?php }else if($user->avatar){ ?>
    <img src="<?php echo base_url();?>thumb/timthumb.php?src=<?php echo base_url();?>uploads/user/<?php echo $user->avatar;?>&w=<?php echo $width;?>&h=<?php echo $height;?>&q=100" alt="" class="img-responsive"/>
<?php }else{?>
    <img src="<?php echo base_url();?>templates/img/no-avatar.jpg" width="<?php echo $width;?>" height="<?php echo $height;?>" class="img-responsive"/>
<?php }?>