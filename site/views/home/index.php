<script src="<?php echo base_url().'templates/';?>js/intro.js"></script>
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
                    <img src="<?php echo base_url().'uploads/content/'.getContent(13, 'image');?>" alt="" class="img-responsive img_banner">
                    <div class="caption">
                        <h2><?php echo getContent(13, 'title');?></h2>
                        <?php echo getContent(13, 'content');?>
                        <a data-fancybox data-src="#modalRegister" href="javascript:;" class="btn btnCreate_membership">Opret gratis medlemskab her</a>
                    </div>
                </div>

                <div class="swiper-slide">
                    <section class="section_intro section_customerServices">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php echo base_url().'uploads/content/'.getContent(18, 'image');?>" alt="" class="img-responsive">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <div class="customerServices_content">
                                        <h2><?php echo getContent(18, 'title');?></h2>
                                        <div class="description">
                                            <?php echo getContent(18, 'content');?>
                                        </div>
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
                                        <h2><?php echo getContent(19, 'title');?></h2>
                                        <div class="description">
                                            <?php echo getContent(19, 'content');?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php echo base_url().'uploads/content/'.getContent(19, 'image');?>" alt="" class="img-responsive">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!--<div class="swiper-slide">
                    <section class="section_intro section_delivers">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-ms-6 col-xs-12">
                                    <img src="<?php /*echo base_url().'templates/';*/?>images/1x/img_deliver.png" alt="" class="img-responsive">
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
                </div>-->

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

    <div style="display: none;" id="modalError" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                    <img src="<?php echo base_url();?>/templates/images/i_warning.png" alt="" class="img-responsive">
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-center">
                    <p class="f19" id="error-content">&nbsp;<?php echo $this->session->flashdata('message');?></p>
                </div>
                <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="$.fancybox.close();">Luk</button>
            </div>
        </div>
    </div>
    <div style="display: none;" id="modalMessage" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="message-content"></p>
                <button type="submit" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="$.fancybox.close();">Luk</button>
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
                        <a data-fancybox data-src="#modalRegister" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Register</a>
                        <a data-fancybox data-src="#modalFP" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Forgot password?</a>
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
                                <option value="1">Mænd</option>
                                <option value="2">Kvinder</option>
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

                    <!--<div class="form-group">
                        <h3>Jeg er</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Køn</label>
                                <select name="gender" class="form-control">
                                    <option value="1">Mænd</option>
                                    <option value="2">Kvinder</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Etnisk oprindelse</label>
                                <select name="ethnic_origin" class="form-control">
                                    <option value="Europæisk">Europæisk</option>
                                    <option value="Afrikansk">Afrikansk</option>
                                    <option value="Latinamerikansk">Latinamerikansk</option>
                                    <option value="Asiatisk">Asiatisk</option>
                                    <option value="Indisk">Indisk</option>
                                    <option value="Arabisk">Arabisk</option>
                                    <option value="Blandet/andet">Blandet/andet</option>
                                </select>
                            </div>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <h3>Jeg søger</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Køn</label>
                                <select name="find_gender" class="form-control">
                                    <option value="">Vælg</option>
                                    <option value="1">Mænd</option>
                                    <option value="2">Kvinder</option>
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