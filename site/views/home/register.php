<script src='https://www.google.com/recaptcha/api.js?hl=da'></script>
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
                <?php echo form_open('user/register', array('id'=>'frm_register', 'class'=>'frm_createprofile'))?>
                    <div class="w_login2">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <a class="btnBack" href="javascript:history.back();">« Tilbage</a>
                            </div>
                            <div class="col-xs-12 col-sm-8 col-md-8">
                                <div class="box_login">
                                    <p class="hidden-xs">Er du allerede medlem?</p>
                                    <a data-fancybox="" data-src="#modalLogin" href="javascript:;" class="btn btnLogin">Log ind</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2>Opret din profil</h2>
                    <p class="description">Det er hurtigt og helt gratis at tilmelde sig</p>
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Vælg dit brugernavn" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="year">
                                    <option value="">Fødselsår</option>
                                    <?php for($i = 1930; $i <= date('Y')-18; $i++){?>
                                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="E-mail" name="email" id="email">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="land">
                                    <option value="">Land</option>
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
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="gender" id="gender">
                                    <option value="1">Mand</option>
                                    <option value="2">Kvinde</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="region">
                                    <option value="">Region</option>
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
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Adgangskode" name="password" id="password">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Gentag adgangskode" name="confirmPassword">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-2 col-md-12">
                            <h3>Jeg søger</h3>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="find_gender" id="find_gender" disabled>
                                    <option value="1">Mand</option>
                                    <option value="2" selected>Kvinde</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="find_land">
                                    <option value="">Land</option>
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
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control"  name="find_region">
                                    <option value="">Region</option>
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
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <span class="filled">Alle felter skal udfyldes</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfOWysUAAAAAEkWl12Ndg0kzMaw2oDnulVsJFUl"></div>
                        <!--<img src="images/1x/img_capcha.png" alt="" class="img-responsive">-->
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="term"> Jeg accepterer <a href="<?php echo site_url('home/handelsbetingelser');?>" style="color: #f19906;">brugerbetingelserne</a>
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="personaldata"> Jeg accepterer <a href="<?php echo site_url('home/cookie');?>" style="color: #f19906;">vilkår for brug af cookies og persondatapolitikken</a>
                            </label>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btnCreateprofile">OPRET GRATIS PROFIL</button>
                    </div>
                <?php echo form_close();?>
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
                <label for="">Adgangskode</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btnSeefull">Log ind</button>
            <div class="clearfix text-center">
                <a href="<?php echo site_url('register');?>" class="btn btn-link">Opret medlemskab</a>
                <a data-fancybox data-src="#modalFP" onclick="$.fancybox.close();" href="javascript:;" class="btn btn-link">Glemt adgangskode?</a>
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
<script>
    $(document).ready(function () {
        $("#frm_register").validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "email":{
                    required:true,
                    email: true,
                    remote: {
                        url: base_url+"ajax/checkEmail",
                        type: "POST",
                        data: {
                            csrf_site_name: token_value
                        }
                    }
                },
                "name":{
                    required:true,
                    remote: {
                        url: base_url+"ajax/checkName",
                        type: "POST",
                        data: {
                            csrf_site_name: token_value
                        }
                    }
                },
                "year":{
                    required:true
                },
                "gender":{
                    required:true
                },
                "land":{
                    required:true
                },
                "region":{
                    required:true
                },
                "password":{
                    required:true,
                    minlength: 6
                },
                "confirmPassword": {
                    required: true,
                    equalTo: "#password"
                },
                "find_gender":{
                    required:true
                },
                "find_land":{
                    required:true
                },
                "find_region":{
                    required:true
                },
                "term":{
                    required:true
                },
                "personaldata":{
                    required:true
                }
            },
            messages: {
                "email":{
                    required: 'Indtast din email',
                    email: 'Indtast venligst en gyldig e-mailadresse',
                    remote: 'Dette email er i brug'
                },
                "name":{
                    required: 'Vælg dit brugernavn',
                    remote: 'Dette brugernavn er i brug'
                },
                "year":{
                    required: 'Vælg dit fødselsår'
                },
                "gender":{
                    required: 'Vælg dit køn'
                },
                "land":{
                    required: 'Vælg dit land'
                },
                "region":{
                    required: 'Vælg dit region'
                },
                "password":{
                    required: 'Skriv dit kodeord',
                    minlength: "Adgangskoden skal være på mellem {0} tegn."
                },
                "confirmPassword": {
                    required: 'Indtast dit kodeord igen',
                    equalTo: 'Genadgangskoden er ikke som kodeord'
                },
                "find_gender":{
                    required:'Vælg det køn, du vil søge'
                },
                "find_land":{
                    required:'Vælg det land, du vil søge'
                },
                "find_region":{
                    required:'Vælg det region, du vil søge'
                },
                "term":{
                    required:'Accepterer brugerbetingelserne'
                },
                "personaldata":{
                    required:'Accepterer vilkår for brug af cookies og persondatapolitikken'
                }
            }
        });

        $('#gender').change(function () {
            if($('#gender').val() == 1){
                $("#find_gender").val(2);
            } else {
                $("#find_gender").val(1);
            }
        })
    });
</script>