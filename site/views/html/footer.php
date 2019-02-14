<?php $pageArr = array('home/index');?>
<?php $user = $this->session->userdata('user'); ?>
<?php if(!in_array($page, $pageArr)){?>
    <div id="footer" class="cf"></div>
    <section class="section_app">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5 col-ms-5 col-xs-12">
                    <h2>HENT APP´EN</h2>
                    <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/app_store.png" alt="" class="img-responsive"></a>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-ms-7 col-xs-12">
                    <a href="#"><img src="<?php echo base_url().'templates/';?>images/1x/google_play.png" alt="" class="img-responsive"></a>
                    <!--<h2><a class="link_register" data-fancybox data-src="#modalRegister" href="javascript:;" title="">ELLER TILMELD DIG ONLINE</a></h2>-->
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
                    <p class="text_follow">Følg os på Facebook</p>
                    <div class="box_socail">
                        <a href="#" class="btn btn_fb"></a>
                    </div>
                </div>
            </div>

            <?php if($page != 'home/newsletter'){?>
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
                    <p><a href="#">Om Zeeduce</a> - <a href="#">hjælp / FAQ</a> - <a href="#">Kontakt</a> - <a href="#">Succeshistorier</a> - <a href="#">Karriere</a> - <a href="#">Presse</a> - <a href="#">Onlinedating-apps</a> - <a href="#">iPhone dating app</a> - <a href="#">Android dating app</a> - <a href="#">Følg Zeeduce.</a></p>
                </div>
            </div>
            <?php }?>
        </div>
    </footer>
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
            <a href="<?php echo site_url('user/upgrade');?>" class="btn btn_Upgrade">Opgrader nu</a>
        </div>
    </div>
<?php } else {?>

<?php }?>
<div style="display: none;" id="modalError" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content"></p>
            </div>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="$.fancybox.close();">Luk</button>
        </div>
    </div>
</div>
<div style="display: none;" id="modalMessage" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p class="f19" id="message-content"></p>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="$.fancybox.close();">Luk</button>
        </div>
    </div>
</div>
<div style="display: none;" id="modalContact" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h2>Kontakt os</h2>
            <?php echo form_open('user/contact', array('id'=>'frm_contact', 'class'=>'frm_login'))?>
            <div class="form-group">
                <label for="">Navn *</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="form-group">
                <label for="">E-mail *</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label for="">Telefon *</label>
                <input type="text" class="form-control" name="phone">
            </div>
            <div class="form-group">
                <label for="">Besked *</label>
                <textarea name="message" class="form-control"></textarea>
            </div>
            <p><i>Felter markeret med * skal udfyldes</i></p>
            <button type="submit" class="btn btnSeefull">Send</button>
            <?php echo form_close();?>
        </div>
    </div>
</div>
<div style="display: none;" id="modalAbout" class="animated-modal modalBlur">
    <div class="overlay"></div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="w_box_modalBlur_content">
                <div class="box_modalBlur_content">
                    <h4>Habibidating.dk</h4>
                    <p>Habibidating.dk har en mission, vi vil være Danmarks største og mest fortrukne datingsite for etniske Danskere.</p>
                    <p>Grundlagt i 2018, men undervejs i lang tid før. Habibidating vil bygge det største samfund for etniske singler på udkig efter kærlighed, relationer, venskab eller dates.</p>
                    <p>Dating har aldrig været nemmere. Habibidating.dk giver jer en enkel, sikker og sjov side, der gør det nemt og hurtigt at se og kontakte ligesindede singler i dit område.</p>
                    <p>Har du aldrig har oplevet "Poweren" i internet dating så er det nu du skal tilmelde dig Habibidating.</p>
                    <p>Velkommen ombord og held og lykke med din søgning</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(!isset($_COOKIE['ha_panik_cookie'])){?>
    <div class="box_notify">
        <i class="far fa-comment fa-lg"></i> Benyttes denne knap logges du automatisk af.
        <a href="javascript:void(0);" class="btnClose_xs"><i class="fas fa-times"></i></a>
    </div>
<?php }?>
<a href="javascript:void(0);" class="btn btnPennic"><i class="fas fa-sign-out-alt fa-lg"></i> PANIK</a>
<div class='back-to-top' id='back-to-top' title='Back to top'>
    <i class="fas fa-long-arrow-alt-up"></i>
</div>
<?php if(!isset($_COOKIE['ha_cookie'])){?>
    <section class="cookie">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <p class="mb-1">Cookies er nødvendige for at få hjemmesiden til at fungere, men de giver også info om hvordan du bruger vores hjemmeside, så vi kan forbedre den både for dig og for andre.</p>
                    <p>Vi bruger cookies! <a href="<?php echo site_url('home/cookie');?>" class="btnMore2">Læs mere</a></p>
                    <a href="#" class="btn btnCookie">OKAY</a>
                </div>
            </div>
        </div>
    </section>
<?php }?>
<script>
    $( document ).ready(function() {
        <?php if($this->session->flashdata('message')){?>
        $('#message-content').html('<?php echo $this->session->flashdata('message');?>');
        $.fancybox.open({src: '#modalMessage'});
        <?php }?>

        <?php if($this->session->flashdata('error')){?>
        $('#error-content').html('<?php echo $this->session->flashdata('error');?>');
        $.fancybox.open({src: '#modalError'});
        <?php }?>
    });
</script>
