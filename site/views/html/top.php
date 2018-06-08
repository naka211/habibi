<?php $user = $this->session->userdata('user');
if(!empty($user)){
    $this->load->model('user_model', 'user');
    $unreadMessageQuantity = $this->user->getUnreadMessageQuantity($user->id);
    $unreadMessageQuantityHTML = !empty($unreadMessageQuantity) ? '<span>' . $unreadMessageQuantity . '</span>' : '';
    $blinkingQuantity = $this->user->getBlinkingQuantity($user->id);
    $blinkingQuantityHTML = !empty($blinkingQuantity) ? '<span>' . $blinkingQuantity . '</span>' : '';
    $friendRequestQuantity = $this->user->friendRequestQuantity($user->id);
    $friendRequestQuantityHTML = !empty($friendRequestQuantity) ? '<span>' . $friendRequestQuantity . '</span>' : '';

    if(isGoldMember()){
        $messageLink = 'href="'.site_url('user/messages').'"';
        $visitingLink = 'href="'.site_url('user/visitMe').'"';
        $friendRequestLink = 'href="'.site_url('user/friendRequests').'"';
    } else {
        $visitingLink = $friendRequestLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
    }
    $messageLink = 'href="'.site_url('user/messages').'"';
    $blinkLink = 'href="'.site_url('user/receivedBlinks').'"';
    $friendLink = 'href="'.site_url('user/friends').'"';
}
?>

<?php if(!$user && $page == 'home/index'){?>

<?php }else{?>
    <script src="<?php echo base_url().'templates/';?>js/functions.js"></script>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a class="navbar-brand" href="<?php echo base_url();?>">Habibi</a>
                    <div class="box_user_top">
                        <div class="box_user_content">
                            <h4 class="media-heading"><?php echo $user->name;?></h4>
                            <a href="block_list.php">Bloker liste</a> |
                            <a href="<?php echo site_url('user/logout');?>">Log out</a>
                        </div>
                        <a class="img_avatar_sm" href="<?php echo site_url('user/index');?>">
                            <img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div id="menuwrap">
        <nav id="menu" class="navbar navbar-light" role="navigation">
            <div class="container">
                <div class="row">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="text_menu">MENU</span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            <li id="searchMenu"><a href="<?php echo site_url('user/searching')?>">Søg</a></li>
                            <li id="favoriteMenu"><a href="<?php echo site_url('user/favorites')?>">Favoritter</a></li>
                            <li id="messageMenu"><a <?php echo $messageLink;?>>Besked <?php echo $unreadMessageQuantityHTML?></a></li>
                            <li id="visitMenu"><a <?php echo $visitingLink;?>>Besøg</a></li>
                            <li id="blinkMenu"><a <?php echo $blinkLink;?>>Blink <?php echo $blinkingQuantityHTML?></a></li>
                            <li id="friendMenu"><a <?php echo $friendLink;?>>Venner</a></li>
                            <li id="friendRequestMenu"><a <?php echo $friendRequestLink;?>>Venneanmodninger <?php echo $friendRequestQuantityHTML;?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php }?>