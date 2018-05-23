<head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title><?php if (!empty($title)) echo $title; ?></title>
    <meta name="DC.title" content="<?php if (!empty($title)) echo $title; ?>"/>
    <meta name="geo.region" content="VN-SG"/>
    <meta name="geo.placename" content=""/>
    <meta name="title" content="<?php if (!empty($meta_title)) echo $meta_title; ?>"/>
    <meta name="keywords" content="<?php if (!empty($meta_keywords)) echo $meta_keywords; ?>"/>
    <meta name="description" content="<?php if (!empty($meta_description)) echo $meta_description; ?>"/>
    <meta name="robots" content="noodp, index, follow"/>
    <meta name="generator" content="HTML Tidy for Windows (vers 14 February 2016), see www.w3.org"/>
    <meta name="copyright" content="Copyright © 2018 by NTT"/>
    <meta name="abstract" content="<?php if (!empty($title)) echo $title; ?>"/>


    <?php $link = base_url().$_SERVER['REQUEST_URI'];?>
    <link rel="canonical" href="<?php echo $link;?>"/>

    <meta property="og:url"           content="<?php echo $link;?>"/>
    <meta property="og:type"          content="website"/>
    <meta property="og:title"         content="<?php if(!empty($title)) echo $title;?>"/>
    <meta property="og:description"   content="<?php if(!empty($meta_description)) echo $meta_description;?>"/>
    <meta property="og:image"         content=""/>

    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url().'templates/';?>favicon_package_v0.16/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url().'templates/';?>favicon_package_v0.16/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url().'templates/';?>favicon_package_v0.16/favicon-16x16.png">
    <link rel="manifest" href="<?php echo base_url().'templates/';?>favicon_package_v0.16/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.0/css/swiper.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/css/animsition.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.css">

    <link rel="stylesheet" href="<?php echo base_url().'templates/';?>css/component.css">
    <link rel="stylesheet" href="<?php echo base_url().'templates/';?>css/styles.css" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url().'templates/';?>css/mobile.css" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animsition/4.0.2/js/animsition.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.2.0/js/swiper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/latest/plugins/ScrollToPlugin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollTrigger/0.3.6/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.matchHeight/0.7.2/jquery.matchHeight-min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.5/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

    <script src="<?php echo base_url().'templates/';?>js/functions.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });
    </script>

    <script>
        var token_value = '<?php echo $this->security->get_csrf_hash();?>';
        var base_url = '<?php echo base_url();?>';
        var base_url_lang = '<?php echo base_url().$this->lang->lang();?>/';
    </script>
    <?php if(checkLogin() && isGoldMember()){?>
        <script type="text/javascript" charset="utf-8" src="<?php echo base_url();?>cometchat/js.php"></script>
        <link type="text/css" rel="stylesheet" media="all" href="<?php echo base_url();?>cometchat/css.php" />
    <?php }?>

</head>