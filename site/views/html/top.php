<?php $user = getUser();
$class = $this->router->fetch_class();
if(!empty($user)){
    $this->load->model('user_model', 'user');
    $unreadMessageQuantity = $this->user->getUnreadMessageQuantity($user->id);
    $unreadMessageQuantityHTML = !empty($unreadMessageQuantity) ? '<span>' . $unreadMessageQuantity . '</span>' : '';
    $blinkingQuantity = $this->user->getBlinkingQuantity($user->id);
    $blinkingQuantityHTML = !empty($blinkingQuantity) ? '<span>' . $blinkingQuantity . '</span>' : '';
    $friendRequestQuantity = $this->user->friendRequestQuantity($user->id);
    $rejectRequestQuantity = $this->user->rejectRequestQuantity($user->id);
    $requestQuantity = $friendRequestQuantity + $rejectRequestQuantity;
    $requestQuantityHTML = $requestQuantity != 0 ? '<span>' . $requestQuantity . '</span>' : '';
    $newFriendQuantity = $this->user->newFriendQuantity($user->id);
    $newFriendQuantityHTML = !empty($newFriendQuantity) ? '<span>' . $newFriendQuantity . '</span>' : '';

    if(!empty($unreadMessageQuantity) || !empty($blinkingQuantity) || !empty($friendRequestQuantity) || !empty($rejectRequestQuantity) || !empty($newFriendQuantity)){
        $notificationTotal = $unreadMessageQuantity + $blinkingQuantity + $friendRequestQuantity + $rejectRequestQuantity + $newFriendQuantity;
        $mark = '<span>'.$notificationTotal.'</span>';
    } else {
        $mark = '';
    }

    $visitingLink = 'href="'.site_url('user/visitMe').'"';
    $friendRequestLink = 'href="'.site_url('user/friendRequests').'"';
    $messageLink = 'href="'.site_url('user/messages').'"';
    $blinkLink = 'href="'.site_url('user/receivedBlinks').'"';
    $friendLink = 'href="'.site_url('user/friends').'"';
}
?>

<?php if(!empty($user) && $class != 'home'){?>
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
                                <a>Guld medlem udløber: <?php echo @date('d/m/Y', $user->expired_at)?></a>
                            <?php } else {?>
                                <a>Gratis medlem: Ubegrænset</a>
                            <?php }?>
                        </div>
                        <div class="dropdown_avatar clearfix">
                            <a href="#" href="#menu_sub" id="toggle" class="btntoggle">
                                <div class="img_avatar_sm">
                                    <img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>?<?php echo time();?>" class="img-responsive" alt="">
                                </div>
                                <span class="caret"></span>
                            </a>
                            <div id="menu_sub">
                                <div class="box_editProfile">
                                    <h3>
                                        <?php if(isGoldMember()){?>
                                            Guld medlem udløber: <?php echo @date('d/m/Y', $user->expired_at)?>
                                        <?php } else {?>
                                            Gratis medlem: Ubegrænset
                                        <?php }?>
                                    </h3>
                                    <ul class="clearfix">
                                        <!--<li><a href="#"><i class="i_01"></i> Profilinfo</a></li>-->
                                        <li><a href="<?php echo site_url('user/index');?>"><i class="i_02"></i> Min profil</a></li>
                                        <li><a href="<?php echo site_url('user/update');?>"><i class="i_08"></i> Rediger profil</a></li>
                                        <!--<li><a href=""><i class="i_03"></i> Om mig</a></li>-->
                                        <li><a href="<?php echo site_url('user/myPhoto');?>"><i class="i_04"></i> Album</a></li>
                                        <!--<li><a href=""><i class="i_05"></i> Værdier og interesser</a></li>
                                        <li><a href=""><i class="i_06"></i> Matchprofil</a></li>-->
                                        <li><a href="<?php echo site_url('user/blockList');?>"><i class="i_07"></i> Blokerede</a></li>
                                    </ul>
                                </div>
                                <div class="that_profile">
                                    <p><span></span></p>
                                    <div class="avatar">
                                        <a href="<?php echo site_url('user/index');?>">
                                            <div class="avatar__icon avatar__icon--big">
                                                <img src="<?php echo base_url();?>uploads/thumb_user/<?php echo $user->avatar;?>?<?php echo time();?>" class="avatar__image" alt="">
                                            </div>
                                            <div class="avatar__name">Se profil</div>
                                        </a>
                                    </div>
                                    <ul class="clearfix">
                                        <li><a data-fancybox data-src="#modalContact" href="javascript:;">Kontakt os</a></li>
                                        <li><a data-fancybox data-src="#modalAbout" href="javascript:;">Om os</a></li>
                                        <li><a href="<?php echo site_url('home/handelsbetingelser');?>">Brugerbetingelser</a></li>
                                        <li><a href="<?php echo site_url('home/abonnement');?>">Betingelser for abonnement</a></li>
                                        <li><a href="<?php echo site_url('home/cookie');?>">Cookie & persondatapolitik</a></li>
                                        <li><a href="<?php echo site_url('home/guldmedlemskab');?>">Fordele ved et guld medlemskab</a></li>
                                    </ul>
                                    <p class="text-center"><a href="<?php echo site_url('user/logout');?>" class="btn btnLogout">Log af</a></p>
                                </div>
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
                            <span class="text_menu">MENU <?php echo $mark;?></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="nav navbar-nav">
                            <li id="searchMenu"><a href="<?php echo site_url('user/searching')?>">Søg</a></li>
                            <li id="favoriteMenu"><a href="<?php echo site_url('user/favorites')?>">Favoritter</a></li>
                            <li id="messageMenu"><a <?php echo $messageLink;?>>Beskeder <?php echo $unreadMessageQuantityHTML?></a></li>
                            <li id="visitMenu"><a <?php echo $visitingLink;?>>Besøg</a></li>
                            <li id="blinkMenu"><a <?php echo $blinkLink;?>>Blink <?php echo $blinkingQuantityHTML?></a></li>
                            <li id="friendMenu"><a <?php echo $friendLink;?>>Venner <?php echo $newFriendQuantityHTML;?></a></li>
                            <li id="friendRequestMenu"><a <?php echo $friendRequestLink;?>>Venneanmodninger <?php echo $requestQuantityHTML;?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php }?>