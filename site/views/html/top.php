<?php $user = $this->session->userdata('user');
if(!empty($user)){
    /*$this->load->model('user_model', 'user');
    $numUnreadMessage = $this->user->getNumUnreadMessage($user->id);
    $unreadMessageNotificationHTML = !empty($numUnreadMessage) ? '<i class="notify">' . $numUnreadMessage . '</i>' : '';
    $numPositiveNotification = $this->user->getNumOfNotification($user->id);
    $numPositiveNotificationHTML = !empty($numPositiveNotification) ? '<i class="notify">' . $numPositiveNotification . '</i>' : '';*/

    if(isGoldMember()){
        $blinkLink = 'href="'.site_url('user/blinks').'"';
        $messageLink = 'href="'.site_url('user/messages').'"';
        $visitingLink = 'href="'.site_url('user/visits').'"';
        $friendRequestLink = 'href="'.site_url('user/friendRequests').'"';
    } else {
        $blinkLink = $messageLink = $visitingLink = $friendRequestLink = 'data-fancybox data-src="#modalUpgrade" href="javascript:;"';
    }
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
                            <img src="<?php echo base_url();?>/uploads/user/<?php echo $user->avatar;?>" class="img-responsive" alt="">
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
                            <li class="active"><a href="search.php">Søg</a></li>
                            <li><a href="favorites.php">Favoritter</a></li>
                            <li><a <?php echo $messageLink; ?>>Besked</a></li>
                            <li><a <?php echo $visitingLink; ?>>Besøg</a></li>
                            <li><a <?php echo $blinkLink; ?>>Blink <span>5</span></a></li>
                            <li><a href="friend.php">Venner</a></li>
                            <li><a <?php echo $friendRequestLink; ?>>Venneanmodninger <span>2</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php }?>