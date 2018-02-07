<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui"/>
    <meta name="description" content="bootstrap admin template"/>
    <meta name="author" content="Le Duc Cuong"/>
    <title><?php echo $title;?></title>
    <link rel="apple-touch-icon" href="<?php echo base_url();?>templates/assets/images/apple-touch-icon.png"/>
    <link rel="shortcut icon" href="<?php echo base_url();?>templates/assets/images/favicon.ico"/>
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/css/bootstrap-extend.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/assets/css/site.min.css"/>
    <!-- Plugins -->
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/animsition/animsition.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/asscrollable/asScrollable.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/switchery/switchery.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/intro-js/introjs.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/slidepanel/slidePanel.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/flag-icon-css/flag-icon.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/vendor/waves/waves.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/assets/examples/css/pages/login-v3.css"/>
    <!-- Fonts -->
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/fonts/material-design/material-design.min.css"/>
    <link rel="stylesheet" href="<?php echo base_url();?>templates/global/fonts/brand-icons/brand-icons.min.css"/>
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'/>
    <!--[if lt IE 9]>
    <script src="<?php echo base_url();?>templates/global/vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <!--[if lt IE 10]>
    <script src="<?php echo base_url();?>templates/global/vendor/media-match/media.match.min.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/respond/respond.min.js"></script>
    <![endif]-->
    <!-- Scripts -->
    <script src="<?php echo base_url();?>templates/global/vendor/modernizr/modernizr.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/breakpoints/breakpoints.js"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="page-login-v3 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Page -->
<div class="page animsition vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">

<div class="page-content vertical-align-middle">
    <div class="panel">
        <div class="brand">
            <img class="brand-img" src="<?php echo base_url();?>templates/assets/images/logo-vi.png" alt="..."/>
        </div>
        <div class="panel-body">
            <?php
                if($this->session->flashdata('message')){
                    echo '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>';
                }if($this->session->flashdata('error')){
                    echo '<div class="alert alert-danger">'.$this->session->flashdata('error').'</div>';
                }if($this->session->flashdata('notes')){
                    echo '<div class="alert alert-primary">'.$this->session->flashdata('notes').'</div>';
                }
            ?>
            <?php echo form_open(base_url());?>
                <?php echo form_error('username')?>
                <div class="form-group form-material floating">
                    <input type="text" class="form-control" name="username" value="<?php echo set_value('username')?>" />
                    <label class="floating-label"><?php echo lang('login.username');?></label>
                </div>
                <?php echo form_error('password')?>
                <div class="form-group form-material floating">
                    <input type="password" class="form-control" name="password" />
                    <label class="floating-label"><?php echo lang('login.password');?></label>
                </div>

                <button type="submit" name="login" class="btn btn-primary btn-block btn-lg margin-top-20 margin-bottom-20 btn-login-kfc"><?php echo lang('login.login');?></button>

                <div class="form-group clearfix">
                    <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg pull-left">
                        <input type="checkbox" id="inputCheckbox" name="remember"/>
                        <label for="inputCheckbox"><?php echo lang('login.remember');?></label>
                    </div>
                </div>
            <?php echo form_close()?>
        </div>
        <div class="center"></div>
    </div>
    <footer class="page-copyright page-copyright-inverse">
        <p><?php echo date('Y',time())?></p>
    </footer>
</div>
</div>
<!-- End Page -->
<!-- Core  -->
    <script src="<?php echo base_url();?>templates/global/vendor/jquery/jquery.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/bootstrap/bootstrap.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/animsition/animsition.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/asscroll/jquery-asScroll.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/mousewheel/jquery.mousewheel.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/asscrollable/jquery.asScrollable.all.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/waves/waves.js"></script>
    <!-- Plugins -->
    <script src="<?php echo base_url();?>templates/global/vendor/switchery/switchery.min.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/intro-js/intro.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/screenfull/screenfull.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/slidepanel/jquery-slidePanel.js"></script>
    <script src="<?php echo base_url();?>templates/global/vendor/jquery-placeholder/jquery.placeholder.js"></script>
    <!-- Scripts -->
    <script src="<?php echo base_url();?>templates/global/js/core.js"></script>
    <script src="<?php echo base_url();?>templates/assets/js/site.js"></script>
    <script src="<?php echo base_url();?>templates/assets/js/sections/menu.js"></script>
    <script src="<?php echo base_url();?>templates/assets/js/sections/menubar.js"></script>
    <script src="<?php echo base_url();?>templates/assets/js/sections/sidebar.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/configs/config-colors.js"></script>
    <script src="<?php echo base_url();?>templates/assets/js/configs/config-tour.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/asscrollable.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/animsition.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/slidepanel.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/switchery.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/tabs.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/jquery-placeholder.js"></script>
    <script src="<?php echo base_url();?>templates/global/js/components/material.js"></script>
    <script>
    (function(document, window, $) {
        'use strict';
        var Site = window.Site;
        $(document).ready(function() {
          Site.run();
        });
    })(document, window, jQuery);
    </script>
</body>
</html>