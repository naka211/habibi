<?php $user = $this->session->userdata('user');
if(!empty($user)){
    $this->load->model('user_model', 'user');
    $numUnreadMessage = $this->user->getNumUnreadMessage($user->id);
    $unreadMessageNotificationHTML = !empty($numUnreadMessage) ? '<i class="notify">' . $numUnreadMessage . '</i>' : '';
    $numPositiveNotification = $this->user->getNumOfNotification($user->id);
    $numPositiveNotificationHTML = !empty($numPositiveNotification) ? '<i class="notify">' . $numPositiveNotification . '</i>' : '';
}
?>

<?php if(!$user && $page == 'home/index'){?>

<?php }else{?>
    <script src="<?php echo base_url().'templates/';?>js/functions.js"></script>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <a class="navbar-brand" href="index.php">Habibi</a>
                    <div class="box_user_top">
                        <div class="box_user_content">
                            <h4 class="media-heading">Jorgensen</h4>
                            <a href="block_list.php">Bloker liste</a> |
                            <a href="<?php echo site_url('user/logout');?>">Log out</a>
                        </div>
                        <a class="img_avatar_sm" href="myprofile.php">
                            <img src="<?php echo base_url();?>/templates/images/1x/avatar_small.jpg" class="img-responsive" alt="">
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
                            <li><a href="message.php">Besked</a></li>
                            <li><a href="viewvisit.php">Besøg</a></li>
                            <li><a href="blink.php">Blink <span>5</span></a></li>
                            <li><a href="friend.php">Venner</a></li>
                            <li><a href="request.php">Venneanmodninger <span>2</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
<?php }?>