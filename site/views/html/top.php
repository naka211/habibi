<?php $user = $this->session->userdata('user');
if(!empty($user)){
    $this->load->model('user_model', 'user');
    $unreadMessageQuantity = $this->user->getUnreadMessageQuantity($user->id);
    $unreadMessageQuantityHTML = !empty($unreadMessageQuantity) ? '<span>' . $unreadMessageQuantity . '</span>' : '';
    $blinkingQuantity = $this->user->getBlinkingQuantity($user->id);
    $blinkingQuantityHTML = !empty($blinkingQuantity) ? '<span>' . $blinkingQuantity . '</span>' : '';
    $friendRequestQuantity = $this->user->friendRequestQuantity($user->id);
    $friendRequestQuantityHTML = !empty($friendRequestQuantity) ? '<span>' . $friendRequestQuantity . '</span>' : '';
    $newFriendQuantity = $this->user->newFriendQuantity($user->id);
    $newFriendQuantityHTML = !empty($newFriendQuantity) ? '<span>' . $newFriendQuantity . '</span>' : '';

    $visitingLink = 'href="'.site_url('user/visitMe').'"';
    $friendRequestLink = 'href="'.site_url('user/friendRequests').'"';
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
                            <?php if(isGoldMember()){?>
                                <a>Guld abonnement udløber: <?php echo @date('d/m/Y', $user)?></a>
                            <?php } else {?>
                                <a>Gratis medlem: Ubegrænset</a>
                            <?php }?>
                        </div>
                        <div class="dropdown dropdown_avatar show clearfix">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="img_avatar_sm">
                                    <img src="<?php echo base_url();?>/uploads/thumb_user/<?php echo $user->avatar;?>" class="img-responsive" alt="">
                                </div>
                                <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo site_url('user/index');?>">Min profil</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/update');?>">Rediger profil</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/myPhoto');?>">Min foto</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/blockList');?>">Bloker liste</a>
                                <a class="dropdown-item" href="<?php echo site_url('user/logout');?>">Log ud</a>
                            </div>
                        </div>
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
                            <li id="friendMenu"><a <?php echo $friendLink;?>>Venner <?php echo $newFriendQuantityHTML;?></a></li>
                            <li id="friendRequestMenu"><a <?php echo $friendRequestLink;?>>Venneanmodninger <?php echo $friendRequestQuantityHTML;?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php }?>