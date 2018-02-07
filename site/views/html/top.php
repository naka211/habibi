<?php $user = $this->session->userdata('user');
if(!empty($user)){
    if($user->b2b != 1){
        $this->load->model('user_model', 'user');
        $numUnreadMessage = $this->user->getNumUnreadMessage($user->id);
        $unreadMessageNotificationHTML = !empty($numUnreadMessage) ? '<i class="notify">' . $numUnreadMessage . '</i>' : '';
        $numPositiveNotification = $this->user->getNumOfNotification($user->id);
        $numPositiveNotificationHTML = !empty($numPositiveNotification) ? '<i class="notify">' . $numPositiveNotification . '</i>' : '';
    } else {
        $unreadMessageNotificationHTML = '';
        $numPositiveNotificationHTML = '';
    }
}
?>
<?php if(!$user && $page == 'home/index'){?>
<header class="navbar-fixed-top">
    <section>
      <div class="container">
        <div class="row">
          <div class="col-xs-3 col-md-3">
            <a href="<?php echo base_url();?>" class="logo"></a>
          </div>
          <div class="col-xs-9 col-md-9">
            <p class="pull-right">
              <span>Er du allerede medlem? </span> 
              <i class="fa fa-long-arrow-right"></i>
              <a class="btnLogin hvr-bounce-to-bottom" href="#Flogin" data-toggle="modal"> Log ind</a>
            </p>
          </div>
        </div>
      </div>
    </section>
</header>
<?php }else{?>
<header class="navbar-fixed-top header2">
    <section>
      <div class="container">
        <div class="row">
            <div class="col-sm-3 col-md-3">
                <a class="logo" href="<?php echo base_url();?>">logo</a>
            </div>
            <div class="col-sm-9 col-md-9 logined">
                <?php if($user){?>
                <p class="pull-right"><a href="javascript:void(0)">Velkommen <?php echo $user->name;?></a> <a href="<?php echo site_url('user/logout');?>">Log ud</a> <a href="<?php echo site_url('tilbud/cart');?>">Kurv (<span id="number-cart"><?php echo $this->cart->total_items();?></span>)</a></p>
                <?php }else{?>
                <p class="pull-right"><a href="#Flogin" data-toggle="modal">Log ind</a> <a href="<?php echo site_url('tilbud/cart');?>">Kurv (<span id="number-cart"><?php echo $this->cart->total_items();?></span>)</a></p>
                <?php }?>
            </div>
        </div>
      </div>
    </section>
    <nav role="navigation" class="navbar navbar-inverse border_white">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
          <div class="container">
            <ul class="nav navbar-nav">
                <?php if($user && $user->b2b){?>
                    <li id="menu_sold"><a href="<?php echo site_url('b2b/sold');?>">Solgt</a></li>
                    <li id="menu_minprofil"><a href="<?php echo site_url('b2b/profile');?>">Min profil</a></li>
                <?php }else{?>
                    <li id="menu_minprofil"><a <?php if($user){?> href="<?php echo site_url('user/index');?>" <?php }else{?> href="#Flogin" data-toggle="modal" <?php }?>>Min profil <?php if(!empty($user)){ echo $unreadMessageNotificationHTML;}?></a></li>
                    <li id="menu_favorit"><a <?php if($user && !$user->b2b){?> href="<?php echo site_url('user/favorit');?>" <?php }else{?> href="#Flogin" data-toggle="modal" <?php }?>>Favorit liste</a></li>
                    <li id="menu_browsing"><a href="<?php echo site_url('user/browsing');?>">Browsing</a></li>
                    <li id="menu_positiv"><a <?php if($user && !$user->b2b){?> href="<?php echo site_url('user/positiv');?>" <?php }else{?> href="#Flogin" data-toggle="modal" <?php }?>>Positiv liste <?php if(!empty($user)){echo $numPositiveNotificationHTML;}?></a></li>
                    <li id="menu_invitationer"><a <?php if($user && !$user->b2b){?> href="<?php echo site_url('invitationer/index');?>" <?php }else{?> href="#Flogin" data-toggle="modal" <?php }?>>Invitationer</a></li>
                    <li id="menu_tilbud"><a href="<?php echo site_url('tilbud/index');?>">Tilbud</a></li>
                    <li id="menu_kontakt"><a href="<?php echo site_url('kontakt');?>">Kontakt</a></li>
                <?php }?>
            </ul>
          </div>
        </div>
    </nav>
</header>
<?php }?>