<div class="create_profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <a class="logo_sub" href="<?php echo base_url();?>"><img src="<?php echo base_url().'templates/';?>images/1x/logo.png" alt="" class="img-respsonsive"></a>
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
                            <h2>Få din <span>10%</span><br>
                                velkomstkode</h2>
                            <p class="description">… tilmeld dig gode tibud og få 10% velkomstrabat.</p>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Indtast din e-mail…" name="email">
                            </div>
                            <button class="btn btnSendPost">SEND AFSTED</button>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Born: Eksklusivt nyhedsbrev med tilbud &amp; nyheder.
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> Accepter vores <a href="#">salgs - og leveringsbetingelser</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="img_newsletter">
                                <img src="<?php echo base_url().'templates/';?>images/1x/section2_photo.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <p class="note_giftcard">* Gæelder ikke gavekort. Minimumsbeløbet er 499 kr.<br>
                                Koden gælder i 7 dage ikke anvendes sammen med andre kode er personlig, og må ikke deles videre eller publicerers.<br>
                                Ved at registrere dig accepterer du at modtage email og smser fra Boozt med eksklusive tilbud, inspriration og personlige anbefailinger. <br>
                                Maks 2 sms’er om måbeden. Du kan altid afmelde dig.</p>
                            <ul class="list_infoNewsletter">
                                <li>Hurtig oprettelse og nem framelding</li>
                                <li>Høj sikkerhed med 256 bit SSL kryptering</li>
                                <li>Gratis medlemskab uden binding</li>
                                <li>Gør din profil anonym med vores sløringsværktøj</li>
                            </ul>
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
                }
            },
            messages: {
                "email":{
                    required: 'Indtast din email',
                    email: 'Indtast venligst en gyldig e-mailadresse'
                }
            }
        });
    });
</script>