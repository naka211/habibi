<script src='https://www.google.com/recaptcha/api.js?hl=da'></script>
<div class="create_profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <a class="logo_sub" href="index.php"><img src="<?php echo base_url().'templates/';?>images/1x/logo.png" alt="" class="img-respsonsive"></a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12">
                <?php echo form_open('user/register', array('id'=>'frm_register', 'class'=>'frm_createprofile'))?>
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
                                    <?php for($i = 1930; $i <= 2010; $i++){?>
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
                                <select class="form-control" name="gender">
                                    <option value="">Køn</option>
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
                                <input type="password" class="form-control" placeholder="Kodeord" name="password" id="password">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Gentag Kodeord" name="confirmPassword">
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-2 col-md-12">
                            <h3>Jeg søger</h3>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6">
                            <div class="form-group">
                                <select class="form-control" name="find_gender">
                                    <option value="">Køn</option>
                                    <option value="1">Mand</option>
                                    <option value="2">Kvinde</option>
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
                                <span class="filled">Alle felter skal udfyldes</span>
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
                    </div>

                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LfOWysUAAAAAEkWl12Ndg0kzMaw2oDnulVsJFUl"></div>
                        <!--<img src="images/1x/img_capcha.png" alt="" class="img-responsive">-->
                    </div>

                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="term"> Jeg accepterer brugerbetingelserne
                            </label>
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="personaldata"> Jeg accepterer vilkår for brug af cookies og persondatapolitikken
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
                    remote: 'Denne email er i brug'
                },
                "name":{
                    required: 'Indtast din navn',
                    remote: 'Denne brugernavn er i brug'
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
            }/*,
            submitHandler: function(form){
                $.fancybox.close();
                var formData = new FormData(form);
                $('.se-pre-con').show();
                $.ajax({
                    type: "POST",
                    url: base_url+"user/register",
                    data: formData,
                    dataType: 'json',
                    mimeType:"multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(data){
                        if(data.status === false){
                            $('.se-pre-con').fadeOut();
                            $('#error-content').html(data.message);
                            $.fancybox.open({src: '#modalError'});
                        } else {
                            location.reload();
                        }
                    }
                });
                return false;
            }*/
        });
    });
</script>