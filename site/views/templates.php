<!doctype html>
<html class="no-js">

<head>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">
    <title>Habibi</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

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

    <script src="<?php echo base_url().'templates/';?>js/functions.js"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>

</head>

<body>
<div class="se-pre-con"></div>
<div id="page">
    <section class="banner">
        <div class="swiper_banner swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <nav class="navbar navbar-light nav_top" role="navigation">
                        <div class="container">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="index.php">Habibi</a>
                            </div>
                            <div class="box_login">
                                <p class="hidden-xs">Er du allerede medlem?</p>
                                <a data-fancybox data-src="#modalLogin" href="javascript:;" class="btn btnLogin">Log ind</a>
                            </div>
                        </div>
                    </nav>
                    <img src="<?php echo base_url().'templates/';?>images/1x/banner01.jpg" alt="" class="img-responsive img_banner">
                    <div class="caption">
                        <h2>Velkommen Til habibi! 1</h2>
                        <p>Danmarks nye invitations Dating site.<br>
                            Stedet som gør det muligt at komme på DATEN!!</p>
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis suspendisse urna nibh.</p>
                        <a data-fancybox data-src="#modalRegister" href="javascript:;" class="btn btnCreate_membership">Opret gratis medlemskab her</a>
                    </div>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_customerServices">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php echo base_url().'templates/';?>images/1x/img_customServices.png" alt="" class="img-responsive">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <div class="customerServices_content">
                                        <h2>Dedicated<br>
                                            Customer Service</h2>
                                        <p class="description">We pride ourselves on quality and to ensure your experience with us is enjoyable, each profile is reviewed by a member of staff to ensure that a standard level of quality is found.</p>
                                        <p class="description">We have offices in both Florida, USA and Kent in the United Kingdom and we may be contacted by telephone so members have a customer help line if they need it. Online dating should not mean just online help.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_relationships">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <div class="relationships_content">
                                        <h2>Our Dating Website Is<br>
                                            About Delivering<br>
                                            Quality Relationships</h2>
                                        <p class="description">Our proven track record of 14 years strongly suggests that we are not only a successful site, but our staff and approach to this business is of exceptional standards that time and again delivers quality. This is confirmed by our members who have found successful relationships.</p>
                                        <p class="description">We understand that the quality of the members is what makes a site successful and at Sugardaddie.com, we are not only a recognized millionaire dating site, but also a site that offers sound dating advice too.</p>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php echo base_url().'templates/';?>images/1x/img_couple.png" alt="" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_delivers">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php echo base_url().'templates/';?>images/1x/img_deliver.png" alt="" class="img-responsive">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <div class="delivers_content">
                                        <h2>HAbib<br>
                                            Dating Delivers</h2>
                                        <p class="description">We cater to people who are aware of the finer things in life and understand that good living is not a luxury, but a necessity. Sugardaddie.com's dating personals makes every effort for you to attain your relationship with the comforts of a lifestyle that you desire.</p>
                                        <p class="description">Are you a sugar babe that wants to date a millionaire / sugar daddy? Second best is not an option and we understand the needs of single people when delivering an unrivaled matchmaking service that is admired by many, but equaled by none.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="swiper-slide">

                    <div class="w_footer">
                        <div class="section_app">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                                        <h2>HENT APPÉN</h2>
                                        <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/app_store.png" alt="" class="img-responsive"></a>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                                        <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/google_play.png" alt="" class="img-responsive"></a>
                                        <h2><a class="link_register" data-fancybox data-src="#modalRegister" href="javascript:;" title="">ELLER TILMELD DIG ONLINE</a></h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="footer">
                            <div class="container">
                                <div class="row footer_top">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <img src="<?php echo base_url().'templates/';?>images/1x/logo.svg" alt="" class="img-responsive logo_footer">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <p class="text_follow">Følg os på Facebook og Instagram</p>
                                        <div class="box_socail">
                                            <a href="#" class="btn btn_fb"></a>
                                            <a href="#" class="btn btn_tw"></a>
                                            <a href="#" class="btn btn_in"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                        <ul class="list">
                                            <li>- Online dating udelukkende til <a href="index.php">Zeduuce.dk</a></li>
                                            <li>- Internet dating, der fjerner den første forhindring</li>
                                            <li>- En Eksklusiv Dating Website</li>
                                            <li>- Zeduuce.dk er en livsstil</li>
                                            <li>- Tilslutning mennesker gennem eksklusive internet dating</li>
                                            <li>- Zeduuce.dk - Selektiv Online Dating</li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6  col-ms-6 col-xs-12">
                                        <p class="f14"><a href="index.php">Derfor Zeduuce.dk</a></p>
                                        <ul class="list_Therefore">
                                            <li>Danmarks hurtigt voksende datingsite.</li>
                                            <li>Finder din næste kærlighed, partner eller ven her.</li>
                                            <li>Nemt at finde det rigtige match.</li>
                                            <li>Masser af arrangementer, events og gode deals</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row footer_bottom">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <p><a href="#">Om Zeeduce</a> - <a href="#">hjælp / FAQ</a> - <a href="#">Kontakt</a> - <a href="#">Succeshistorier</a> - <a href="#">Karriere</a> - <a href="#">Presse</a> - <a href="#">Onlinedating-apps</a> - <a href="#">iPhone dating app</a> - <a href="#">Android dating app</a> - <a href="#">Følg Zeeduce.</a></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="w_mouse">
            <svg class="svg_mouseScroll" xmlns="http://www.w3.org/2000/svg" width="16" height="37" viewBox="0 0 34.375 80.375">
                <path id="mouse-scroll" d="M32.927,37.933c0,6.972-5.652,12.625-12.625,12.625h-6.333C6.997,50.558,1.344,44.905,1.344,37.933V13.917  c0-6.972,5.652-12.625,12.625-12.625l6.333,0c6.973,0,12.625,5.653,12.625,12.625V37.933zM19.198,15.125c0,1.104-0.895,2-2,2h-0.125c-1.104,0-2-0.896-2-2V9.166c0-1.104,0.896-2,2-2h0.125c1.105,0,2,0.896,2,2V15.125zM17.136 7.166 L17.166 1.437zM17.136 17.125 L17.136 23.208z"/>
                <polyline id="arrow1" points="26.948,58.5 17.136,68.313   7.323,58.5 "/>
                <polyline id="arrow2" points="26.948,65.25 17.136,75.063   7.323,65.25 "/>
            </svg>
        </div>

        <script type="text/javascript">
            var mouse_Scroll = document.getElementById('mouse-scroll');
            var mouse_Scroll_Str = mouse_Scroll.getTotalLength();
            mouse_Scroll.setAttribute('stroke-dashoffset', mouse_Scroll_Str);
            mouse_Scroll.setAttribute('stroke-dasharray', mouse_Scroll_Str);
        </script>

    </section>

    <div style="display: none;" id="modalLogin" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Log in</h2>
                <form class="frm_login" action="landing.php" method="POST" role="form">
                    <div class="form-group">
                        <label for="">Brugernavn</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="text" class="form-control">
                    </div>
                    <button type="submit" class="btn btnSeefull">Opret</button>
                    <div class="clearfix text-center">
                        <a data-fancybox data-src="#modalRegister" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Register</a>
                        <a data-fancybox data-src="#modalFP" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Forgot password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="display: none;" id="modalFP" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>GLEMT DIN ADGANGSKODE?</h2>
                <p>Angiv venligst emailadressen til din konto. En verificeringskode vli blive sendt til dig. Når du har modtaget verificeringskoden vil du kunne vælge en ny adgangskode til din konto.</p>
                <form class="frm_login" action="#" method="POST" role="form">
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="text" class="form-control">
                    </div>
                    <button type="submit" class="btn btnSeefull">Send</button>
                </form>
            </div>
        </div>
    </div>
    <div style="display: none;" id="modalRegister" class="animated-modal modalRegister">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h2>Prøv en søgning</h2>
                <p>Udfyld de faste søgekriterier og få altid opdaterede profiler her.</p>
                <p>Join one of the most established and successful dating sites in the world.</p>
                <p>Featured internationally in media and television.</p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <form class="frm_register" action="landing.php" method="POST" role="form">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Brugernavn</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Fødselsår</label>
                                <select name="" class="form-control">
                                    <option value="">1900</option>
                                    <option value="">1901</option>
                                    <option value="">1902</option>
                                    <option value="">...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">E-mail</label>
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Region</label>
                                <select name="" class="form-control">
                                    <option value="">København</option>
                                    <option value="">København</option>
                                    <option value="">København</option>
                                    <option value="">...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Kodeord</label>
                                <input type="password" class="form-control">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Gentag kodeord</label>
                                <input type="password" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h3>Jeg er</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Køn</label>
                                <select name="" class="form-control">
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Etnisk oprindelse</label>
                                <select name="" class="form-control">
                                    <option value="">...</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h3>Jeg søger</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Jeg søger</label>
                                <select name="" class="form-control">
                                    <option value="">...</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Etnisk oprindelse</label>
                                <select name="" class="form-control">
                                    <option value="">...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn_viewSearch">Opret</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

</body>

</html>
