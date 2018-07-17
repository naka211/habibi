<div id="content">
    <section class="section_editProfile">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 style="margin: 0;">Rediger profil</h3>
                    <hr>
                    <?php echo form_open('user/update', array('id'=>'frm_update', 'class'=>'frm_efitProfile'));?>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Brugernavn:</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $user->name;?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Email:</label>
                                    <input type="text" name="email" class="form-control" value="<?php echo $user->email;?>">
                                </div>
                            </div>


                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Land</label>
                                    <select name="land" class="form-control">
                                        <option value="Tyrkiet" <?php if($user->land == 'Tyrkiet'){echo 'selected="true"';}?>>Tyrkiet</option>
                                        <option value="Syrien" <?php if($user->land == 'Syrien'){echo 'selected="true"';}?>>Syrien</option>
                                        <option value="Irak" <?php if($user->land == 'Irak'){echo 'selected="true"';}?>>Irak</option>
                                        <option value="Libanon" <?php if($user->land == 'Libanon'){echo 'selected="true"';}?>>Libanon</option>
                                        <option value="Pakistan" <?php if($user->land == 'Pakistan'){echo 'selected="true"';}?>>Pakistan</option>
                                        <option value="Palæstina" <?php if($user->land == 'Palæstina'){echo 'selected="true"';}?>>Palæstina</option>
                                        <option value="Somalia" <?php if($user->land == 'Somalia'){echo 'selected="true"';}?>>Somalia</option>
                                        <option value="Afghanistan" <?php if($user->land == 'Afghanistan'){echo 'selected="true"';}?>>Afghanistan</option>
                                        <option value="Bosnien" <?php if($user->land == 'Bosnien'){echo 'selected="true"';}?>>Bosnien</option>
                                        <option value="Iran" <?php if($user->land == 'Iran'){echo 'selected="true"';}?>>Iran</option>
                                        <option value="Marokko" <?php if($user->land == 'Marokko'){echo 'selected="true"';}?>>Marokko</option>
                                        <option value="Albanien" <?php if($user->land == 'Albanien'){echo 'selected="true"';}?>>Albanien</option>
                                        <option value="Algeriet" <?php if($user->land == 'Algeriet'){echo 'selected="true"';}?>>Algeriet</option>
                                        <option value="Egypten" <?php if($user->land == 'Egypten'){echo 'selected="true"';}?>>Egypten</option>
                                        <option value="Makedionen" <?php if($user->land == 'Makedionen'){echo 'selected="true"';}?>>Makedionen</option>
                                        <option value="Andet" <?php if($user->land == 'Andet'){echo 'selected="true"';}?>>Andet</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <select name="region" class="form-control">
                                        <option value="København" <?php if($user->region == 'København'){echo 'selected="true"';}?>>København</option>
                                        <option value="Storkøbenhavn" <?php if($user->region == 'Storkøbenhavn'){echo 'selected="true"';}?>>Storkøbenhavn</option>
                                        <option value="Århus" <?php if($user->region == 'Århus'){echo 'selected="true"';}?>>Århus</option>
                                        <option value="Aalborg" <?php if($user->region == 'Aalborg'){echo 'selected="true"';}?>>Aalborg</option>
                                        <option value="Odense" <?php if($user->region == 'Odense'){echo 'selected="true"';}?>>Odense</option>
                                        <option value="Nordsjælland" <?php if($user->region == 'Nordsjælland'){echo 'selected="true"';}?>>Nordsjælland</option>
                                        <option value="Midt/Vestsjælland" <?php if($user->region == 'Midt/Vestsjælland'){echo 'selected="true"';}?>>Midt/Vestsjælland</option>
                                        <option value="Sydsjælland" <?php if($user->region == 'Sydsjælland'){echo 'selected="true"';}?>>Sydsjælland</option>
                                        <option value="Lolland/Falster" <?php if($user->region == 'Lolland/Falster'){echo 'selected="true"';}?>>Lolland/Falster</option>
                                        <option value="Fyn" <?php if($user->region == 'Fyn'){echo 'selected="true"';}?>>Fyn</option>
                                        <option value="Nordjylland" <?php if($user->region == 'Nordjylland'){echo 'selected="true"';}?>>Nordjylland</option>
                                        <option value="Østjylland" <?php if($user->region == 'Østjylland'){echo 'selected="true"';}?>>Østjylland</option>
                                        <option value="Vestjylland" <?php if($user->region == 'Vestjylland'){echo 'selected="true"';}?>>Vestjylland</option>
                                        <option value="Sydjylland" <?php if($user->region == 'Sydjylland'){echo 'selected="true"';}?>>Sydjylland</option>
                                        <option value="Midtjylland" <?php if($user->region == 'Midtjylland'){echo 'selected="true"';}?>>Midtjylland</option>
                                        <option value="Sønderjylland" <?php if($user->region == 'Sønderjylland'){echo 'selected="true"';}?>>Sønderjylland</option>
                                        <option value="Bornholm" <?php if($user->region == 'Bornholm'){echo 'selected="true"';}?>>Bornholm</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Forhold:</label>
                                    <select name="relationship" class="form-control">
                                        <option <?php if($user->relationship == 'Aldrig gift'){echo 'selected="true"';}?> value="Aldrig gift">Aldrig gift</option>
                                        <option <?php if($user->relationship == 'Separeret'){echo 'selected="true"';}?> value="Separeret">Separeret</option>
                                        <option <?php if($user->relationship == 'Skilt'){echo 'selected="true"';}?> value="Skilt">Skilt</option>
                                        <option <?php if($user->relationship == 'Enke/enkemand'){echo 'selected="true"';}?> value="Enke/enkemand">Enke/enkemand</option>
                                        <option <?php if($user->relationship == 'Det får du at vide senere'){echo 'selected="true"';}?> value="Det får du at vide senere">Det får du at vide senere</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Uddannelse:</label>
                                    <select name="training" class="form-control">
                                        <option <?php if($user->training == 'Ingen eksamen'){echo 'selected="true"';}?> value="Ingen eksamen">Ingen eksamen</option>
                                        <option <?php if($user->training == 'Gymnasium/HF'){echo 'selected="true"';}?> value="Gymnasium/HF">Gymnasium/HF</option>
                                        <option <?php if($user->training == 'Fagskole'){echo 'selected="true"';}?> value="Fagskole">Fagskole</option>
                                        <option <?php if($user->training == 'Bachelorgrad'){echo 'selected="true"';}?> value="Bachelorgrad">Bachelorgrad</option>
                                        <option <?php if($user->training == 'Kandidat/ph.d.'){echo 'selected="true"';}?> value="Kandidat/ph.d.">Kandidat/ph.d.</option>
                                    </select>
                                </div>
                            </div>

                            <!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Køn:</label>
                                    <select name="gender" class="form-control">
                                        <option <?php /*if($user->gender == 1){echo 'selected="true"';}*/?> value="1">Mand</option>
                                        <option <?php /*if($user->gender == 2){echo 'selected="true"';}*/?> value="2">Kvinde</option>
                                    </select>
                                </div>
                            </div>-->
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Born:</label>
                                    <select name="children" class="form-control">
                                        <option <?php if($user->children == 'Nej'){echo 'selected="true"';}?> value="Nej">Nej</option>
                                        <option <?php if($user->children == 'Ja, hjemmeboende'){echo 'selected="true"';}?> value="Ja, hjemmeboende">Ja, hjemmeboende</option>
                                        <option <?php if($user->children == 'Ja, udeboende'){echo 'selected="true"';}?> value="Ja, udeboende">Ja, udeboende</option>
                                        <option <?php if($user->children == '1'){echo 'selected="true"';}?> value="1">1</option>
                                        <option <?php if($user->children == '2'){echo 'selected="true"';}?> value="2">2</option>
                                        <option <?php if($user->children == '3'){echo 'selected="true"';}?> value="3">3</option>
                                        <option <?php if($user->children == '3+'){echo 'selected="true"';}?> value="3+">3+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Religion:</label>
                                    <select name="religion" class="form-control">
                                        <option <?php if($user->religion == 'Suni'){echo 'selected="true"';}?> value="Suni">Suni</option>
                                        <option <?php if($user->religion == 'Shia'){echo 'selected="true"';}?> value="Shia">Shia</option>
                                        <option <?php if($user->religion == 'Andet'){echo 'selected="true"';}?> value="Andet">Andet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Kropsbygning:</label>
                                    <select name="body" class="form-control">
                                        <option <?php if($user->body == 'Slank'){echo 'selected="true"';}?> value="Slank">Slank</option>
                                        <option <?php if($user->body == 'Atletisk'){echo 'selected="true"';}?> value="Atletisk">Atletisk</option>
                                        <option <?php if($user->body == 'Gennemsnitlig'){echo 'selected="true"';}?> value="Gennemsnitlig">Gennemsnitlig</option>
                                        <option <?php if($user->body == 'Buttet'){echo 'selected="true"';}?> value="Buttet">Buttet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Ryger:</label>
                                    <select name="smoking" class="form-control">
                                        <option <?php if($user->smoking == 'Ja'){echo 'selected="true"';}?> value="Ja">Ja</option>
                                        <option <?php if($user->smoking == 'Nej'){echo 'selected="true"';}?> value="Nej">Nej</option>
                                        <option <?php if($user->smoking == 'Ja, festryger'){echo 'selected="true"';}?> value="Ja, festryger">Ja, festryger</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Dag:</label>
                                            <select name="day" class="form-control">
                                                <?php for($i = 1; $i <= 31; $i++){?>
                                                    <option value="<?php echo $i;?>" <?php if($i == $user->day) echo 'selected'?>><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Måned:</label>
                                            <select name="month" class="form-control">
                                                <?php for($i = 1; $i <= 12; $i++){?>
                                                    <option value="<?php echo $i;?>" <?php if($i == $user->month) echo 'selected'?>><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="">År:</label>
                                            <select name="year" class="form-control">
                                                <?php for($i = 1930; $i <= 2010; $i++){?>
                                                    <option value="<?php echo $i;?>" <?php if($i == $user->year) echo 'selected'?>><?php echo $i;?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h5>Jeg søger</h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Land</label>
                                    <select name="find_land" class="form-control">
                                        <option value="Tyrkiet" <?php if($user->find_land == 'Tyrkiet'){echo 'selected="true"';}?>>Tyrkiet</option>
                                        <option value="Syrien" <?php if($user->find_land == 'Syrien'){echo 'selected="true"';}?>>Syrien</option>
                                        <option value="Irak" <?php if($user->find_land == 'Irak'){echo 'selected="true"';}?>>Irak</option>
                                        <option value="Libanon" <?php if($user->find_land == 'Libanon'){echo 'selected="true"';}?>>Libanon</option>
                                        <option value="Pakistan" <?php if($user->find_land == 'Pakistan'){echo 'selected="true"';}?>>Pakistan</option>
                                        <option value="Palæstina" <?php if($user->find_land == 'Palæstina'){echo 'selected="true"';}?>>Palæstina</option>
                                        <option value="Somalia" <?php if($user->find_land == 'Somalia'){echo 'selected="true"';}?>>Somalia</option>
                                        <option value="Afghanistan" <?php if($user->find_land == 'Afghanistan'){echo 'selected="true"';}?>>Afghanistan</option>
                                        <option value="Bosnien" <?php if($user->find_land == 'Bosnien'){echo 'selected="true"';}?>>Bosnien</option>
                                        <option value="Iran" <?php if($user->find_land == 'Iran'){echo 'selected="true"';}?>>Iran</option>
                                        <option value="Marokko" <?php if($user->find_land == 'Marokko'){echo 'selected="true"';}?>>Marokko</option>
                                        <option value="Albanien" <?php if($user->find_land == 'Albanien'){echo 'selected="true"';}?>>Albanien</option>
                                        <option value="Algeriet" <?php if($user->find_land == 'Algeriet'){echo 'selected="true"';}?>>Algeriet</option>
                                        <option value="Egypten" <?php if($user->find_land == 'Egypten'){echo 'selected="true"';}?>>Egypten</option>
                                        <option value="Makedionen" <?php if($user->find_land == 'Makedionen'){echo 'selected="true"';}?>>Makedionen</option>
                                        <option value="Andet" <?php if($user->find_land == 'Andet'){echo 'selected="true"';}?>>Andet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <select name="find_region" class="form-control">
                                        <option value="København" <?php if($user->find_region == 'København'){echo 'selected="true"';}?>>København</option>
                                        <option value="Storkøbenhavn" <?php if($user->find_region == 'Storkøbenhavn'){echo 'selected="true"';}?>>Storkøbenhavn</option>
                                        <option value="Århus" <?php if($user->find_region == 'Århus'){echo 'selected="true"';}?>>Århus</option>
                                        <option value="Aalborg" <?php if($user->find_region == 'Aalborg'){echo 'selected="true"';}?>>Aalborg</option>
                                        <option value="Odense" <?php if($user->find_region == 'Odense'){echo 'selected="true"';}?>>Odense</option>
                                        <option value="Nordsjælland" <?php if($user->find_region == 'Nordsjælland'){echo 'selected="true"';}?>>Nordsjælland</option>
                                        <option value="Midt/Vestsjælland" <?php if($user->find_region == 'Midt/Vestsjælland'){echo 'selected="true"';}?>>Midt/Vestsjælland</option>
                                        <option value="Sydsjælland" <?php if($user->find_region == 'Sydsjælland'){echo 'selected="true"';}?>>Sydsjælland</option>
                                        <option value="Lolland/Falster" <?php if($user->find_region == 'Lolland/Falster'){echo 'selected="true"';}?>>Lolland/Falster</option>
                                        <option value="Fyn" <?php if($user->find_region == 'Fyn'){echo 'selected="true"';}?>>Fyn</option>
                                        <option value="Nordjylland" <?php if($user->find_region == 'Nordjylland'){echo 'selected="true"';}?>>Nordjylland</option>
                                        <option value="Østjylland" <?php if($user->find_region == 'Østjylland'){echo 'selected="true"';}?>>Østjylland</option>
                                        <option value="Vestjylland" <?php if($user->find_region == 'Vestjylland'){echo 'selected="true"';}?>>Vestjylland</option>
                                        <option value="Sydjylland" <?php if($user->find_region == 'Sydjylland'){echo 'selected="true"';}?>>Sydjylland</option>
                                        <option value="Midtjylland" <?php if($user->find_region == 'Midtjylland'){echo 'selected="true"';}?>>Midtjylland</option>
                                        <option value="Sønderjylland" <?php if($user->find_region == 'Sønderjylland'){echo 'selected="true"';}?>>Sønderjylland</option>
                                        <option value="Bornholm" <?php if($user->find_region == 'Bornholm'){echo 'selected="true"';}?>>Bornholm</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Skriv et motto</label>
                                    <input type="text" name="slogan" class="form-control" value="<?php echo $user->slogan;?>" placeholder="Postnr.">
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Personbeskrivelse</label>
                                    <textarea name="description" class="form-control" rows="5"><?php echo $user->description;?></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="">Chat:</label><br>
                                    <label class="radio-inline"><input type="radio" name="chat" value="0" <?php echo $user->chat == 0?'checked':'';?> style="margin-top: 2px;"> Off</label>
                                    <label class="radio-inline"><input type="radio" name="chat" value="1" <?php echo $user->chat == 1?'checked':'';?> style="margin-top: 2px;"> On</label>
                                </div>
                            </div>
                            <?php if($user->type == 2){?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Medlem:</label>
                                        <label for="">Guld</label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Abonnement udløber:</label>
                                        <label for=""><?php echo date('d/m/Y', $user->expired_at);?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Kortnummer:</label>
                                        <label for=""><?php echo $user->cardno;?></label>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <a href="<?php echo site_url('payment/changeCard')?>" class="btn btnadd_friend">Skift kort</a>
                                    </div>
                                </div>
                            <?php }?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Vælg kodeord (min. 6 karakter):</label>
                                    <input type="password" name="password" class="form-control" id="password">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Gentag Kodeord:</label>
                                    <input type="password" name="repassword" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Indtast venligst adgangskoden for at opdatere din profil</label>
                                    <input type="password" name="currentPassword" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btnadd_friend">Opdateret</button>
                    <?php echo form_close();?>
                </div>
            </div>

            <div class="row">

            </div>
        </div>
    </section>
</div>
<script type="application/javascript">
    $(document).ready(function () {
        $("#frm_update").validate({
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
                },/*
                "password":{
                    required:true,
                },
                "repassword": {
                    equalTo: {
                        depends: isPasswordPresent,
                        param: "#password"
                    }
                },*/
                "currentPassword": {
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
                },/*
                "password":{
                    minlength: "Adgangskoden skal være på mellem {0} tegn."
                },
                "repassword": {
                    equalTo: 'Genadgangskoden er ikke som kodeord'
                },*/
                "currentPassword": {
                    required: 'Indtast din nuværende adgangskode',
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        isPasswordPresent = function () {
            return $('#password').val().length > 0;
        }
    });
</script>