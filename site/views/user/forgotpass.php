<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="index.php">Forside</a></li>
                <li class="active">Glemt adgangskode</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="forget-pass">
    <div class="container">
        <div class="row mt30 mb30">
            <div class="col-md-9">
                <h2>Glemt din adgangskode?</h2>
                <p class="f14">Angiv venligst emailadressen til din konto. En verificeringskode vli blive sendt til dig.
                    Når du har modtaget verificeringskoden vil du kunne vælge en ny adgangskode til din konto.</p>
                <div class="frm-forgetpass mt30">
                    <?php echo form_open(site_url('user/forgotPassHandler'), array('id'=>'forgotForm', 'class'=>'form-inline'))?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Indtast din e-mail" name="email" required>
                        </div>
                        <button type="submit" class="btn btnSend">Send</button>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>