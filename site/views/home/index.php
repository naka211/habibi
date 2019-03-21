<script src="<?php echo base_url().'templates/';?>js/intro.js"></script>
<div id="page">
    <section class="banner">
        <div class="swiper_banner swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <nav class="navbar navbar-light nav_top" role="navigation">
                        <div class="container">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="">Habibi</a>
                            </div>
                            <div class="box_login">
                                <p class="hidden-xs">Er du allerede medlem?</p>
                                <a data-fancybox data-src="#modalLogin" href="javascript:;" class="btn btnLogin">Log ind</a>
                            </div>
                        </div>
                    </nav>
                    <img src="<?php echo base_url().'uploads/content/'.getContent(13, 'image');?>" alt="" class="img-responsive img_banner">
                    <div class="caption">
                        <h2><?php echo getContent(13, 'title');?></h2>
                        <?php echo getContent(13, 'content');?>
                        <a href="<?php echo site_url('register');?>" class="btn btnCreate_membership">Opret gratis medlemskab her</a>
                    </div>
                    <div class="w_mouse">
                        <svg class="svg_mouseScroll" xmlns="http://www.w3.org/2000/svg" width="16" height="37" viewBox="0 0 34.375 80.375">
                            <path id="mouse-scroll" d="M32.927,37.933c0,6.972-5.652,12.625-12.625,12.625h-6.333C6.997,50.558,1.344,44.905,1.344,37.933V13.917  c0-6.972,5.652-12.625,12.625-12.625l6.333,0c6.973,0,12.625,5.653,12.625,12.625V37.933zM19.198,15.125c0,1.104-0.895,2-2,2h-0.125c-1.104,0-2-0.896-2-2V9.166c0-1.104,0.896-2,2-2h0.125c1.105,0,2,0.896,2,2V15.125zM17.136 7.166 L17.166 1.437zM17.136 17.125 L17.136 23.208z"/>
                            <polyline id="arrow1" points="26.948,58.5 17.136,68.313   7.323,58.5 "/>
                            <polyline id="arrow2" points="26.948,65.25 17.136,75.063   7.323,65.25 "/>
                        </svg>
                    </div>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_customerServices">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6 col-md-6 col-xs-12">
                                    <div class="main_img_customerServices">
                                        <img src="<?php echo base_url().'uploads/content/'.getContent(18, 'image');?>" alt="" class="img-responsive img-circle">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-6 col-md-6 col-xs-12">
                                    <div class="row list_img_small_blur">
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_9224436.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_62754775.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_36966483.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_12300646.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_29983841.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_24031527.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_20168337.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                            <div class="img_blur">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_18568645.jpg" alt="" class="img-responsive">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <ul class="list_intro">
                                                <li>Hurtig oprettelse og nem frameldelse</li>
                                                <li>Gratis medlemskab uden binding</li>
                                                <li>Garanteret privat og diskret</li>
                                                <li>Høj sikkerhed med 256 bit SSL kryptering</li>
                                                <li>Gør din profil anonym med vores sløringsværktøj</li>
                                            </ul>
                                            <a href="<?php echo site_url('register');?>" class="btn btnsignup_member">OPRET GRATIS MEDLEMSKAB HER</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w_mouse">
                            <svg class="svg_mouseScroll" xmlns="http://www.w3.org/2000/svg" width="16" height="37" viewBox="0 0 34.375 80.375">
                                <path id="mouse-scroll" d="M32.927,37.933c0,6.972-5.652,12.625-12.625,12.625h-6.333C6.997,50.558,1.344,44.905,1.344,37.933V13.917  c0-6.972,5.652-12.625,12.625-12.625l6.333,0c6.973,0,12.625,5.653,12.625,12.625V37.933zM19.198,15.125c0,1.104-0.895,2-2,2h-0.125c-1.104,0-2-0.896-2-2V9.166c0-1.104,0.896-2,2-2h0.125c1.105,0,2,0.896,2,2V15.125zM17.136 7.166 L17.166 1.437zM17.136 17.125 L17.136 23.208z"/>
                                <polyline id="arrow1" points="26.948,58.5 17.136,68.313   7.323,58.5 "/>
                                <polyline id="arrow2" points="26.948,65.25 17.136,75.063   7.323,65.25 "/>
                            </svg>
                        </div>
                        <!--<div class='back-to-top show back-to-top-intro' title='Tilbage til toppen'>
                            <i class="fas fa-long-arrow-alt-up"></i>
                        </div>-->
                    </section>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_blurring">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12 text-center">
                                    <h2>Sløring af billede</h2>
                                    <div class="box_img_blurring">
                                        <div class="w_box_img_blurring_item">
                                            <div class="box_img_blurring_item">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_18568645_0.jpg" alt="" class="img-responsive">
                                            </div>
                                            <p>0% sløret</p>
                                        </div>
                                        <div class="w_box_img_blurring_item">
                                            <div class="box_img_blurring_item">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_18568645_50.jpg" alt="" class="img-responsive">
                                            </div>
                                            <p>50% sløret</p>
                                        </div>
                                        <div class="w_box_img_blurring_item">
                                            <div class="box_img_blurring_item">
                                                <img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_18568645_100.jpg" alt="" class="img-responsive">
                                            </div>
                                            <p>100% sløret</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-8 col-sm-offset-2">
                                            <ul class="list_blurring">
                                                <li>Du kan slørre dit billede.</li>
                                                <li>Du kan selv vælge hvor kraftig en sløring du vil sætte på dit billede.</li>
                                                <li>Du vælger selv hvornår du vil fjerne sløringen.</li>
                                                <li>Du kan selv vælge om du vil vise dit billed offentligt, eller kun for enkelte profiler.</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <a data-fancybox data-src="#modalBlur" href="javascript:;" class="btn btnMore">Læs mere</a>
                                </div>
                            </div>
                        </div>
                        <div class="w_mouse">
                            <svg class="svg_mouseScroll" xmlns="http://www.w3.org/2000/svg" width="16" height="37" viewBox="0 0 34.375 80.375">
                                <path id="mouse-scroll" d="M32.927,37.933c0,6.972-5.652,12.625-12.625,12.625h-6.333C6.997,50.558,1.344,44.905,1.344,37.933V13.917  c0-6.972,5.652-12.625,12.625-12.625l6.333,0c6.973,0,12.625,5.653,12.625,12.625V37.933zM19.198,15.125c0,1.104-0.895,2-2,2h-0.125c-1.104,0-2-0.896-2-2V9.166c0-1.104,0.896-2,2-2h0.125c1.105,0,2,0.896,2,2V15.125zM17.136 7.166 L17.166 1.437zM17.136 17.125 L17.136 23.208z"/>
                                <polyline id="arrow1" points="26.948,58.5 17.136,68.313   7.323,58.5 "/>
                                <polyline id="arrow2" points="26.948,65.25 17.136,75.063   7.323,65.25 "/>
                            </svg>
                        </div>
                        <!--<div class='back-to-top show back-to-top-intro' title='Tilbage til toppen'>
                            <i class="fas fa-long-arrow-alt-up"></i>
                        </div>-->
                    </section>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_block_history">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                                    <h2>Blokering</h2>
                                    <div class="box_img_blocking">
                                        <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/depositphoto_9224436_0.jpg" alt="" class="img-responsive"></a>
                                        <p>Bloker</p>
                                    </div>
                                    <p>Ønsker du ikke at være synlig overfor enkelte profiler, så kan du via blokering skjule dig, så du ikke er synlig på deres søgning.</p>
                                    <a data-fancybox data-src="#modalBlokering" href="javascript:;" class="btn btnMore">Læs mere</a>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
                                    <h2>Slet chat historik</h2>
                                    <div class="box_img_chat">
                                        <img src="<?php echo base_url().'templates/';?>images/1x/img_chat.png" alt="" class="img-responsive">
                                    </div>
                                    <p>Du kan slette din chat historik, gøres dette, slettes historikken hos begge parter i chatten.</p>
                                    <a data-fancybox data-src="#modalChat" href="javascript:;" class="btn btnMore">Læs mere</a>
                                </div>
                            </div>
                        </div>
                        <div class="w_mouse">
                            <svg class="svg_mouseScroll" xmlns="http://www.w3.org/2000/svg" width="16" height="37" viewBox="0 0 34.375 80.375">
                                <path id="mouse-scroll" d="M32.927,37.933c0,6.972-5.652,12.625-12.625,12.625h-6.333C6.997,50.558,1.344,44.905,1.344,37.933V13.917  c0-6.972,5.652-12.625,12.625-12.625l6.333,0c6.973,0,12.625,5.653,12.625,12.625V37.933zM19.198,15.125c0,1.104-0.895,2-2,2h-0.125c-1.104,0-2-0.896-2-2V9.166c0-1.104,0.896-2,2-2h0.125c1.105,0,2,0.896,2,2V15.125zM17.136 7.166 L17.166 1.437zM17.136 17.125 L17.136 23.208z"/>
                                <polyline id="arrow1" points="26.948,58.5 17.136,68.313   7.323,58.5 "/>
                                <polyline id="arrow2" points="26.948,65.25 17.136,75.063   7.323,65.25 "/>
                            </svg>
                        </div>
                        <!--<div class='back-to-top show back-to-top-intro' title='Tilbage til toppen'>
                            <i class="fas fa-long-arrow-alt-up"></i>
                        </div>-->
                    </section>
                </div>

                <div class="swiper-slide">

                    <div class="w_footer">
                        <div class="section_app">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                                        <h2>HENT APP´EN</h2>
                                        <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/app_store.png" alt="" class="img-responsive"></a>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                                        <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/google_play.png" alt="" class="img-responsive"></a>
                                        <!--<h2><a class="link_register" href="<?php /*echo site_url('register');*/?>">ELLER TILMELD DIG ONLINE</a></h2>-->
                                        <h2>Kommer snart</h2>
                                    </div>
                                    <!--<div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12" style="text-align: right;">
                                        <h3 style="color: #FFF; margin-bottom: 0px; font-size: 30px; margin-top: 5px;">Kommer snart</h3>
                                    </div>-->
                                </div>
                            </div>
                        </div>

                        <div class="w_mainFooter">
                            <div class="footer">
                                <div class="container">
                                    <div class="row footer_top">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                            <img src="<?php echo base_url().'templates/';?>images/1x/logo.svg" alt="" class="img-responsive logo_footer">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                            <p class="text_follow">Følg os på Facebook / Instagram</p>
                                            <div class="box_socail">
                                                <a href="https://www.facebook.com/Habibidating-748451042173578/" class="btn btn_fb"></a>
                                                <a href="https://www.instagram.com/habibidating.dk/" class="btn btn_in"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                            <ul class="list">
                                                <li>- <a data-fancybox data-src="#modalContact" href="javascript:;">Kontakt os</a></li>
                                                <li>- <a data-fancybox data-src="#modalAbout" href="javascript:;">Om os</a></li>
                                                <li>- <a href="<?php echo site_url('home/handelsbetingelser');?>">Brugerbetingelser</a></li>
                                                <li>- <a href="<?php echo site_url('home/abonnement');?>">Betingelser for abonnement</a></li>
                                                <li>- <a href="<?php echo site_url('home/cookie');?>">Cookie & persondatapolitik</a></li>
                                                <li>- <a href="<?php echo site_url('home/guldmedlemskab');?>">Fordele ved et guld medlemskab</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6  col-ms-6 col-xs-12">
                                            <ul class="list_intro intro_footer">
                                                <li>Hurtig oprettelse og nem frameldelse</li>
                                                <li>Gratis medlemskab uden binding</li>
                                                <li>Garanteret privat og diskret</li>
                                                <li>Høj sikkerhed med 256 bit SSL kryptering</li>
                                                <li>Gør din profil anonym med vores sløringsværktøj</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row footer_bottom">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <p><a data-fancybox data-src="#modalContact" href="javascript:;">Kontakt os</a>
                                                - <a data-fancybox data-src="#modalAbout" href="javascript:;">Om os</a>
                                                - <a href="<?php echo site_url('home/handelsbetingelser');?>">Brugerbetingelser</a>
                                                - <a href="<?php echo site_url('home/abonnement');?>">Betingelser for abonnement</a>
                                                - <a href="<?php echo site_url('home/cookie');?>">Cookie & persondatapolitik</a>
                                                - <a href="<?php echo site_url('home/guldmedlemskab');?>">Fordele ved et guld medlemskab</a>
                                            </p>
                                            <!--<a href="javascript:;" class="btnMovetop">Tilbage til top <i class="i_up"></i></a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--<div class='back-to-top show back-to-top-intro' title='Tilbage til toppen'>
                        <i class="fas fa-long-arrow-alt-up"></i>
                    </div>-->
                </div>

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <script type="text/javascript">
            var mouse_Scroll = document.getElementById('mouse-scroll');
            var mouse_Scroll_Str = mouse_Scroll.getTotalLength();
            mouse_Scroll.setAttribute('stroke-dashoffset', mouse_Scroll_Str);
            mouse_Scroll.setAttribute('stroke-dasharray', mouse_Scroll_Str);
        </script>

    </section>

    <div class='back-to-top back-to-top-intro' title='Tilbage til toppen' id="back-to-top-intro">
        <i class="fas fa-long-arrow-alt-up"></i>
    </div>

    <div style="display: none;" id="modalBlur" class="animated-modal modalBlur">
        <div class="overlay"></div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="w_box_modalBlur_img">
                    <div class="box_modalBlur_img">
                        <img class="img-responsive" src="<?php echo base_url().'templates/';?>images/1x/popup1.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="w_box_modalBlur_content">
                    <div class="box_modalBlur_content">
                        <h4>Slørring:</h4>
                        <ul class="list_blurring">
                            <li>Du kan slørre dit billede.</li>
                            <li>Du kan selv vælge hvor krafig en slørring du vil sætte på dit bilede.</li>
                            <li>Du vælger selv hvomår du vil fjeme slørringen.</li>
                            <li>Du kan vælge om du vil vise dig offentligt eller om du kun vil vise dig for enkelte profiler.</li>
                        </ul>
                        <p>Eks 1: Når du slørre dit billed til at starte med så bestemmer du hvor meget du vil slørres og det kan ændres senere hen</p>
                        <p>Eks 2: Når du har fået en venneanmoding og kommer i kontakt med en anden bruger og føler dig sikker så kan du fjerne slørringen hos den enkelte bruger ved et enkelt klik</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;" id="modalBlokering" class="animated-modal modalBlur">
        <div class="overlay"></div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="w_box_modalBlur_img">
                    <div class="box_modalBlur_img">
                        <img class="img-responsive" src="<?php echo base_url().'templates/';?>images/1x/popup2.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="w_box_modalBlur_content">
                    <div class="box_modalBlur_content">
                        <h4>Blokering:</h4>
                        <p>Ønsker du ikke at være synlig overfor  enkelte profiler så kan du via blokering skjule dig så du ikke er synlig på deres søgning.</p>
                        <p>Eks 1: hvis du mener der er en bruger på siden som ikke skal se du har en profil her så kan du blokere vedkommende og så er du ikke på vedkommendes søgning</p>
                        <p>Eks 2: hvis du blver generet eller føler dig overvåget kan du blokere de profiler og du er ikke på deres søgning</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;" id="modalChat" class="animated-modal modalBlur">
        <div class="overlay"></div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="w_box_modalBlur_img">
                    <div class="box_modalBlur_img">
                        <img class="img-responsive" src="<?php echo base_url().'templates/';?>images/1x/popup2.jpg" alt="">
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                <div class="w_box_modalBlur_content">
                    <div class="box_modalBlur_content">
                        <h4>Chat:</h4>
                        <p>Du kan slette din chat historik, gøres dette slettes historikken hos begge parter i chatten.</p>
                        <p>Eks 1: Du som enten mand eller kvinde har den sikkerhed at Sletning af chatten betyder at hvis du er i gang med at chatte med en anden bruger og du bliver stødt eller ikke finder personen værdig så kan du slette historiken ved et enkelt klik og den bliver slettet hos begge parter så det ikke kan misbruges efterfølgende</p>
                        <p>Eks 2: hvis din chat er slået fra så kan den åbnes hos enkelte bruger ved at modparten sender en venneanmodning og der er en åben chat funktion</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="display: none;" id="modalLogin" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Log ind</h2>
                <?php echo form_open('user/login', array('id'=>'frm_login', 'class'=>'frm_login'))?>
                    <div class="form-group">
                        <label for="">E-mail / Brugernavn</label>
                        <input type="text" class="form-control" name="info">
                    </div>
                    <div class="form-group">
                        <label for="">Kodeord</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <button type="submit" class="btn btnSeefull">Log ind</button>
                    <div class="clearfix text-center">
                        <a href="<?php echo site_url('register');?>" class="btn btn-link">Opret medlemskab</a>
                        <a data-fancybox data-src="#modalFP" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Glemt kodeord?</a>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
    <div style="display: none;" id="modalFP" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>GLEMT DIN ADGANGSKODE?</h2>
                <p>Angiv venligst emailadressen til din konto. En verificeringskode vli blive sendt til dig. Når du har modtaget verificeringskoden vil du kunne vælge en ny adgangskode til din konto.</p>
                <?php echo form_open('', array('id'=>'frm_forgotPassword', 'class'=>'frm_login'))?>
                    <div class="form-group">
                        <label for="">E-mail</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <button type="submit" class="btn btnSeefull">Send</button>
                <?php echo form_close();?>
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
                <?php echo form_open('', array('id'=>'frm_register', 'class'=>'frm_register'))?>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Brugernavn</label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Fødselsår</label>
                                <select name="year" class="form-control">
                                    <option value="">Vælg</option>
                                    <?php for($i = 1930; $i <= 2010; $i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">E-mail</label>
                                <input type="text" class="form-control" name="email" id="email">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Land</label>
                                <select name="land" class="form-control">
                                    <option value="">Vælg</option>
                                    <option value="Tyrkiet">Tyrkiet</option>
                                    <option value="Syrien">Syrien</option>
                                    <option value="Irak">Irak</option>
                                    <option value="Libanon">Libanon</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palæstina">Palæstina</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Bosnien">Bosnien</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Marokko">Marokko</option>
                                    <option value="Albanien">Albanien</option>
                                    <option value="Algeriet">Algeriet</option>
                                    <option value="Egypten">Egypten</option>
                                    <option value="Makedionen">Makedionen</option>
                                    <option value="Andet">Andet</option>
                                </select>
                            </div>
                        </div>
                    </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Køn</label>
                            <select name="gender" class="form-control">
                                <option value="">Vælg</option>
                                <option value="1">Mand</option>
                                <option value="2">Kvinde</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="">Region</label>
                            <select name="region" class="form-control">
                                <option value="">Vælg</option>
                                <option value="København">København</option>
                                <option value="Storkøbenhavn">Storkøbenhavn</option>
                                <option value="Århus">Århus</option>
                                <option value="Aalborg">Aalborg</option>
                                <option value="Odense">Odense</option>
                                <option value="Nordsjælland">Nordsjælland</option>
                                <option value="Midt/Vestsjælland">Midt/Vestsjælland</option>
                                <option value="Sydsjælland">Sydsjælland</option>
                                <option value="Lolland/Falster">Lolland/Falster</option>
                                <option value="Fyn">Fyn</option>
                                <option value="Nordjylland">Nordjylland</option>
                                <option value="Østjylland">Østjylland</option>
                                <option value="Vestjylland">Vestjylland</option>
                                <option value="Sydjylland">Sydjylland</option>
                                <option value="Midtjylland">Midtjylland</option>
                                <option value="Sønderjylland">Sønderjylland</option>
                                <option value="Bornholm">Bornholm</option>
                            </select>
                        </div>
                    </div>
                </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Kodeord</label>
                                <input type="password" class="form-control" name="password" id="password">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Gentag kodeord</label>
                                <input type="password" class="form-control" name="confirmPassword">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <h3>Jeg søger</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Køn</label>
                                <select name="find_gender" class="form-control">
                                    <option value="">Vælg</option>
                                    <option value="1">Mand</option>
                                    <option value="2">Kvinde</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Land</label>
                                <select name="find_land" class="form-control">
                                    <option value="">Vælg</option>
                                    <option value="Tyrkiet">Tyrkiet</option>
                                    <option value="Syrien">Syrien</option>
                                    <option value="Irak">Irak</option>
                                    <option value="Libanon">Libanon</option>
                                    <option value="Pakistan">Pakistan</option>
                                    <option value="Palæstina">Palæstina</option>
                                    <option value="Somalia">Somalia</option>
                                    <option value="Afghanistan">Afghanistan</option>
                                    <option value="Bosnien">Bosnien</option>
                                    <option value="Iran">Iran</option>
                                    <option value="Marokko">Marokko</option>
                                    <option value="Albanien">Albanien</option>
                                    <option value="Algeriet">Algeriet</option>
                                    <option value="Egypten">Egypten</option>
                                    <option value="Makedionen">Makedionen</option>
                                    <option value="Andet">Andet</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Region</label>
                                <select name="find_region" class="form-control">
                                    <option value="">Vælg</option>
                                    <option value="København">København</option>
                                    <option value="Storkøbenhavn">Storkøbenhavn</option>
                                    <option value="Århus">Århus</option>
                                    <option value="Aalborg">Aalborg</option>
                                    <option value="Odense">Odense</option>
                                    <option value="Nordsjælland">Nordsjælland</option>
                                    <option value="Midt/Vestsjælland">Midt/Vestsjælland</option>
                                    <option value="Sydsjælland">Sydsjælland</option>
                                    <option value="Lolland/Falster">Lolland/Falster</option>
                                    <option value="Fyn">Fyn</option>
                                    <option value="Nordjylland">Nordjylland</option>
                                    <option value="Østjylland">Østjylland</option>
                                    <option value="Vestjylland">Vestjylland</option>
                                    <option value="Sydjylland">Sydjylland</option>
                                    <option value="Midtjylland">Midtjylland</option>
                                    <option value="Sønderjylland">Sønderjylland</option>
                                    <option value="Bornholm">Bornholm</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn_viewSearch">Opret</button>
                    </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>

</div>