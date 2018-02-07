<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <meta name="format-detection" content="telephone=no"/>
    <title><?php if (!empty($title)) echo $title; ?></title>
    <meta name="DC.title" content="<?php if (!empty($title)) echo $title; ?>"/>
    <meta name="geo.region" content="VN-SG"/>
    <meta name="geo.placename" content=""/>
    <meta name="title" content="<?php if (!empty($meta_title)) echo $meta_title; ?>"/>
    <meta name="keywords" content="<?php if (!empty($meta_keywords)) echo $meta_keywords; ?>"/>
    <meta name="description" content="<?php if (!empty($meta_description)) echo $meta_description; ?>"/>
    <meta name="robots" content="noodp, index, follow"/>
    <meta name="generator" content="HTML Tidy for Windows (vers 14 February 2016), see www.w3.org"/>
    <meta name="copyright" content="Copyright © 2016 by LDC"/>
    <meta name="abstract" content="<?php if (!empty($title)) echo $title; ?>"/>
    <meta name="distribution" content="Global"/>
    <meta name="REVISIT-AFTER" content="1 DAYS"/>
    <meta name="RATING" content="GENERAL"/>
    
    <?php $link = base_url().$_SERVER['REQUEST_URI'];?>
    <link rel="canonical" href="<?php echo $link;?>"/>
    
    <meta property="og:url"           content="<?php echo $link;?>"/>
    <meta property="og:type"          content="website"/>
    <meta property="og:title"         content="<?php if(!empty($title)) echo $title;?>"/>
    <meta property="og:description"   content="<?php if(!empty($meta_description)) echo $meta_description;?>"/>
    <meta property="og:image"         content=""/>
    
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-152x152.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url().'templates/';?>favicons/apple-touch-icon-180x180.png"/>
    <link rel="icon" type="image/png" href="<?php echo base_url().'templates/';?>favicons/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="<?php echo base_url().'templates/';?>favicons/android-chrome-192x192.png" sizes="192x192"/>
    <link rel="icon" type="image/png" href="<?php echo base_url().'templates/';?>favicons/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="<?php echo base_url().'templates/';?>favicons/favicon-16x16.png" sizes="16x16"/>
    <link rel="manifest" href="<?php echo base_url().'templates/';?>favicons/manifest.json"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="msapplication-TileImage" content="<?php echo base_url().'templates/';?>favicons/mstile-144x144.png"/>
    <meta name="theme-color" content="#ffffff"/>
    
    <!-- Bootstrap Core CSS -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'/>
    <link href='https://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'/>
    <link href="<?php echo base_url().'templates/';?>css/bootstrap.min.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    
    <!-- Custom CSS -->
    <link href="<?php echo base_url().'templates/';?>css/animate.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/hover.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/owl.carousel.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/owl.theme.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/ion.rangeSlider.css" rel="stylesheet" />
    <link href="<?php echo base_url().'templates/';?>css/ion.rangeSlider.skinHTML5.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo base_url().'templates/';?>source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
    <link href="<?php echo base_url().'templates/';?>css/ninja-slider.css" rel="stylesheet" />
    <link href="<?php echo base_url().'templates/';?>css/thumbnail-slider.css" rel="stylesheet" type="text/css" />
    
    <link href="<?php echo base_url().'templates/';?>css/style.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/mobile-style.css" rel="stylesheet"/>
    <link href="<?php echo base_url().'templates/';?>css/cuong.css" rel="stylesheet"/>
    
    <script type="text/javascript">
      WebFontConfig = {
        google: { families: [ 'Open+Sans:400,300,600:latin' ] }
      };
      (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })(); </script>
      
      <script type="text/javascript">
      WebFontConfig = {
        google: { families: [ 'Dancing+Script::latin' ] }
      };
      (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
      })(); </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo base_url().'templates/';?>js/jquery.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/jquery.mousewheel-3.0.6.pack.js"></script>
    <script src="<?php echo base_url().'templates/';?>source/jquery.fancybox.pack.js?v=2.1.5"></script>
    <script src="<?php echo base_url().'templates/';?>js/owl.carousel.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/modernizr.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/ninja-slider.js"></script>
    <script src="<?php echo base_url().'templates/';?>js/thumbnail-slider.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script src="<?php echo base_url();?>templates/js/jquery.validate.bootstrap.popover.min.js"></script>
    <script>
    var token_value = '<?php echo $this->security->get_csrf_hash();?>';
    var base_url = '<?php echo base_url();?>';
    var base_url_lang = '<?php echo base_url().$this->lang->lang();?>/';
    </script>
    <?php if(checkLogin() && isGoldMember()){?>
    <link type="text/css" href="<?php echo base_url();?>cometchat/cometchatcss.php" rel="stylesheet" charset="utf-8">
    <script type="text/javascript" src="<?php echo base_url();?>cometchat/cometchatjs.php" charset="utf-8"></script>
    <?php }?>
</head>