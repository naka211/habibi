<div class="create_profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <a class="logo_sub" href="https://www.habibidating.dk"><img src="<?php echo base_url().'templates/';?>images/1x/logo.png" alt="" class="img-respsonsive"></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <?php echo form_open('user/newsletter', array('id'=>'frm_newsletter', 'class'=>'frm_newsletter'))?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <a href="<?php echo base_url();?>"><img src="<?php echo base_url().'templates/';?>images/1x/logo.png" alt="" class="img-responsive"></a>
                            <h3>Tilmeld dig Habibi´s nyheds brev og vær med i lodtrækningen om 5 gavekort til en værdi af 500,- til Magasin du Nord.</h3>
                            <p class="description">Der trækkes lod i blandt de første 1000 tilmeldte</p>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Indtast din e-mail…" name="email">
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="newsletter"> Eksklusivt nyhedsbrev med tilbud &amp; nyheder.
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="term"> Accepter vores <a href="#">salgs - og leveringsbetingelser</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btnSendPost">SEND AFSTED</button>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="img_newsletter">
                                <img src="<?php echo base_url().'templates/';?>images/1x/section2_photo.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p class="description">Når du har tilmeldt dig vores nyhedsbrev vil du blive informeret om vores launch dato via mail.<br><br>
                                Alle brugere vil få 3 første måneders gratis Guld medlemskab af Danmarks nye etniske dating side.</p>
                            <ul class="list_infoNewsletter">
                                <li>Hurtig oprettelse og nem framelding</li>
                                <li>Høj sikkerhed med 256 bit SSL kryptering</li>
                                <li>Gratis medlemskab uden binding</li>
                                <li>Gør din profil anonym med vores sløringsværktøj</li>
                            </ul>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12">
                        <p class="description box_login"><a href="https://www.habibidating.dk" style="color: #000; font-weight: bold;">www.habibidating.dk</a> </p>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $("#frm_newsletter").validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "email":{
                    required:true,
                    email: true
                },
                "newsletter": {
                    required:true
                },
                "term": {
                    required:true
                }
            },
            messages: {
                "email":{
                    required: 'Indtast din email',
                    email: 'Indtast venligst en gyldig e-mailadresse'
                },
                "newsletter":{
                    required:'Acceptere dette felt'
                },
                "term":{
                    required:'Acceptere dette felt'
                }
            }
        });
    });
</script>