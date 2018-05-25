<?php $user = $this->session->userdata('user');?>
<?php if(!empty($user)){?>
    <div id="footer" class="cf"></div>
    <section class="section_app">
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
    </section>
    <footer class="footer footer_underpages">
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
    </footer>
    <div class='back-to-top' id='back-to-top' title='Back to top'>
        <i class="fas fa-long-arrow-alt-up"></i>
    </div>

    <div class="box_notify">
        <i class="far fa-comment fa-lg"></i> Lorem ipsum dolor sit amet.
        <a href="#" class="btnClose_xs"><i class="fas fa-times"></i></a>
    </div>

    <a href="index.php" class="btn btnPennic"><i class="fas fa-sign-out-alt fa-lg"></i> PANIK</a>

    <div style="display: none;" id="modalChat" class="animated-modal modalChat">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="chat">
                    <ul>
                        <li class="other">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>

                            <div class="message blur">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Itaque quod et dolore accusantium. Labore aut similique ab voluptas rerum quia. Reprehenderit voluptas doloribus ut nam tenetur ipsam.
                                </p>
                            </div>
                            <div class="date">Sendt: d. 13/02/2018 kl. 22:09</div>
                        </li>
                        <li class="other">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>
                            <div class="message">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Modi ratione aliquid non. Et porro deserunt illum sed velit necessitatibus. Quis fuga et et fugit consequuntur. Et veritatis fugiat veniam pariatur maxime iusto aperiam.
                                </p>
                            </div>
                            <div class="date">
                                Sendt: d. 13/02/2018 kl. 22:09
                            </div>
                        </li>
                        <li class="you">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                            <div class="message">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Provident impedit atque nemo culpa et modi molestiae. Error non dolorum voluptas non a. Molestiae et nobis nisi sed.
                                </p>
                            </div>
                            <div class="date">
                                Sendt: d. 13/02/2018 kl. 22:09
                            </div>
                        </li>
                        <li class="other">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/toffeenutdesign/128.jpg" /></a>
                            <div class="message">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Id vel ducimus perferendis fuga excepturi nulla. Dolores dolores amet et laborum facilis. Officia magni ut non autem et qui incidunt. Qui similique fugit vero porro qui cupiditate.
                                </p>
                            </div>
                            <div class="date">
                                Sendt: d. 13/02/2018 kl. 22:09
                            </div>
                        </li>
                        <li class="you">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                            <div class="message">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Provident impedit atque nemo culpa et modi molestiae. Error non dolorum voluptas non a. Molestiae et nobis nisi sed.
                                </p>
                            </div>
                            <div class="date">
                                Sendt: d. 13/02/2018 kl. 22:09
                            </div>
                        </li>
                        <li class="you">
                            <a class="user" href="#"><img alt="" src="https://s3.amazonaws.com/uifaces/faces/twitter/igorgarybaldi/128.jpg" /></a>
                            <div class="message">
                                <div class="hider">
                                    <span>Click to read</span>
                                </div>
                                <p>
                                    Est ut at eum sed perferendis ea hic. Tempora perspiciatis magnam aspernatur explicabo ea. Sint atque quod.
                                </p>
                            </div>
                            <div class="date">
                                Sendt: d. 13/02/2018 kl. 22:09
                            </div>
                        </li>
                    </ul>
                    <form class="frm_Chat" action="" method="POST" role="form">
                        <input type="text" class="form-control" placeholder="Skriv en besked her.........">
                        <button type="submit" class="btn btnSend">SEND</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <div style="display: none;" id="modalUpgrade" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3><?php echo getContent(20, 'title');?></h3>
                <?php echo getContent(20, 'content');?>

            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <img src="<?php echo base_url().'templates/';?>images/1x/premium.png" alt="" class="img-responsive premium_img">
            </div>
        </div>
        <div class="text-center">
            <a href="text_page.php" class="btn btn_Upgrade">Opgrader nu</a>
        </div>
    </div>

    <div style="display: none;" id="modalQuestion" class="animated-modal modalLogin">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p>Er du sikkert på at slette hele chat-beskeden? </p>
                <div class="text-center">
                    <a href="#" class="btn btnYes">JA</a>
                    <a href="#" class="btn btnNo">NEJ</a>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php if(!isset($_COOKIE['ha_cookie'])){?>
<section class="cookie">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Cookies er nødvendige for at få hjemmesiden til at fungere, men de gemmer også information om hvordan du bruger vores hjemmeside, så vi kan forbedre den både for dig og for andre. Cookies på denne hjemmeside bruges primært til trafikmåling og optimering af sidens indhold. Du kan forsætte med at bruge vores side som altid, hvis du accepterer at vi bruger cookies. Lær mere om hvordan du håndterer cookies på dine enheder.</p>
                <a href="javascript:void(0);" class="btn btnCookie"><i class="fa fa-times fa-lg" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</section>
<?php }?>