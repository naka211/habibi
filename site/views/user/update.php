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
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Dag:</label>
                                        <?php echo generateOptionsInRangeHTML('day', 1, 31, $user->day);?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Måned:</label>
                                        <?php echo generateOptionsInRangeHTML('month', 1, 12, $user->month);?>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="">År:</label>
                                        <?php echo generateOptionsInRangeHTML('year', 1930, date('Y')-18, $user->year, '', 'onchange="checkYear(this.value)"');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Højde (cm):</label>
                                        <?php echo generateOptionsInRangeHTML('height', 100, 230, $user->height);?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="">Vægt (kg):</label>
                                        <?php echo generateOptionsInRangeHTML('weight', 40, 220, $user->weight);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Land</label>
                                <?php echo generateOptionsHTMLInUpdate('land', 'land', $user->land, 0);?>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Region</label>
                                <?php echo generateOptionsHTMLInUpdate('region', 'region', $user->region, 0);?>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Forhold:</label>
                                <?php echo generateOptionsHTMLInUpdate('relationship', 'relationship', $user->relationship);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Uddannelse:</label>
                                <?php echo generateOptionsHTMLInUpdate('training', 'training', $user->training);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Børn:</label>
                                <?php echo generateOptionsHTMLInUpdate('children', 'children', $user->children);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Religion:</label>
                                <?php echo generateOptionsHTMLInUpdate('religion', 'religion', $user->religion);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Kropsbygning:</label>
                                <?php echo generateOptionsHTMLInUpdate('body', 'body', $user->body);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Rygning:</label>
                                <?php echo generateOptionsHTMLInUpdate('smoking', 'smoking', $user->smoking);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Branche:</label>
                                <?php echo generateOptionsHTMLInUpdate('business', 'business', $user->business);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Job type:</label>
                                <?php echo generateOptionsHTMLInUpdate('job_type', 'job_type', $user->job_type);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Hårfarve:</label>
                                <?php echo generateOptionsHTMLInUpdate('hair_color', 'hair_color', $user->hair_color);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Øjenfarve:</label>
                                <?php echo generateOptionsHTMLInUpdate('eye_color', 'eye_color', $user->eye_color);?>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Stjernetegn:</label>
                                <?php echo generateOptionsHTMLInUpdate('zodiac', 'zodiac', $user->zodiac);?>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h5>Jeg søger</h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Land</label>
                                    <?php /*echo generateOptionsHTMLInUpdate('land', 'find_land', $user->find_land);*/?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <?php /*echo generateOptionsHTMLInUpdate('region', 'find_region', $user->find_region);*/?>
                                </div>
                            </div>-->

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="">Skriv et motto</label>
                                <input type="text" name="slogan" class="form-control" value="<?php echo $user->slogan;?>" placeholder="">
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
                                <span style="margin-left: 10px; font-weight: 500; line-height: 25px;">
                                        <span id="chat-info">(<?php if($user->chat == 0) echo 'Her kan du slå din chat til og fra efter ønske'; else echo 'Chatten er åben for alle bruger selv om i ikke er venner';?>)</span>
                                         <a href="javascript:void(0);" data-fancybox data-src="#modalReadmore" class="readmore">Læs mere</a>
                                    </span>
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
                                    <label for="">Guld medlem udløber:</label>
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
                                <label for="">Indtast venligst adgangskoden for at opdatere din profil</label>
                                <input type="password" name="currentPassword" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btnadd_friend">Opdatere</button>
                    <?php echo form_close();?>
                    <?php echo form_open('user/changePassword', array('id'=>'frm_changePass', 'class'=>'frm_efitProfile'));?>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Ændre adgangskode (min. 6 karakter):</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="">Gentag ny adgangskode:</label>
                                <input type="password" name="repassword" class="form-control">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btnadd_friend">Opdatere</button>
                    <?php echo form_close();?>
                    <?php if($user->type == 2){?>
                        <hr>
                        <h3 style="margin: 0;">Opsig dit Guld medlemskab</h3>
                        <?php if($user->stand_by_payment == 0){
                            ?>
                            <a href="javascript:void(0);" data-fancybox data-src="#modalStandBy" class="btn btn_viewSearch">Nedgrader</a>
                        <?php } else {?>
                            <a href="<?php echo site_url('user/setStandByStatus/0')?>" class="btn btn_viewSearch">Start medlemskab igen</a>
                        <?php }}?>

                    <hr>
                    <h3 style="margin: 0;">Konto</h3>
                    <?php if($user->deactivation == 0){?>
                        <a href="javascript:void(0);" data-fancybox data-src="#modalDeactivate" class="btn btn_viewSearch">Deaktiver</a>
                    <?php } else {?>
                        <a href="<?php echo site_url('user/setDeactivation/0')?>" class="btn btn_viewSearch">Aktivér</a>
                    <?php }?>

                    <a href="javascript:void(0);" data-fancybox data-src="#modalDelete" class="btn btnDeleteAcc">Slet konto</a>

                </div>
            </div>

            <div class="row">

            </div>
        </div>
    </section>
</div>
<div style="display: none;" id="modalReadmore" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p class="f19" id="message-content">
                <?php if($user->chat == 0) echo 'Her kan du slå din chat til og fra efter eget ønske, accepteres en venneanmodning fra en anden bruger åbner chatten for vedkommende og chatten vil stadigvæk være lukket for andre bruger.'; else echo 'Har du sat chatten "on" så er du åben for at enhver bruger på Habibidating kan skrive til dig, skulle du på et tidspunkt sætte chatten på "off" så er det kun dine venner på Habibidating der vil kunne skrive til dig.';?></p>
            <button type="button" class="btn btn_viewSearch" style="margin-bottom: 0px;" onclick="$.fancybox.close();">Luk</button>
        </div>
    </div>
</div>
<div style="display: none;" id="modalStandBy" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php echo form_open('user/setStandByStatus/1', array('class'=>'standByForm'));?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Når du nedgrader dit Guldmedlemskab bliver du efterfølgende gratismedlem.<br><br>
                    Betalingsperioden kan være som følgende.:<br><br>
                    Du har betalt den 1. i en måned og f.eks. nedgradere du den 12 i samme måned.<br><br>
                    Ved udløbet af måneden bliver du automatisk nedgraderet til gratismedlem
                    og du vil ikke længere blive opkrævet beløb for Guldmedlemskab.
                </p>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Indtast venligst adgangskoden</label>
                        <input type="password" name="currentPassword" class="form-control">
                    </div>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn_viewSearch" style="margin: 0px auto;" onclick="$.fancybox.close();">Nej</a>
            <button type="submit" class="btn btn_viewSearch" style="margin: 0px auto;">Ja</button>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<div style="display: none;" id="modalDeactivate" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php echo form_open('user/setDeactivation/1', array('class'=>'deactivateForm'));?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Når du deaktiver din konto så sker følgende.<br><br>
                    Din profil er ikke længere synlig for andre brugere.<br><br>
                    Genaktiver du din profil så vil alle dine kontakter, beskeder, blink og favoritter være genskabt som de var tidligere.<br><br>
                    Når du deaktiverer din profil vil din automatiske betaling stoppe med at blive trukket ved udgangen af betalingsperioden.<br><br>
                    Vælger du at genaktivere din profil efter udløbet af betalingsperioden må du opgradere dig selv på ny til guldmedlem.
                </p>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Indtast venligst adgangskoden</label>
                        <input type="password" name="currentPassword" class="form-control">
                    </div>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn_viewSearch" style="margin: 0px auto;" onclick="$.fancybox.close();">Nej</a>
            <button type="submit" class="btn btn_viewSearch" style="margin: 0px auto;">Ja</button>
            <?php echo form_close();?>
        </div>
    </div>
</div>

<div style="display: none;" id="modalDelete" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php echo form_open('user/deleteAccount', array('class'=>'deleteForm'));?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Slet konto.:<br><br>
                    Vælger du at slette din konto så slettes alt, herunder billeder og al historik som du har haft på siden.<br><br>
                    Det betyder at hvis du vil benytte siden igen så skal du starte helt forfra med en ny profil samt billeder.</p>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="">Indtast venligst adgangskoden</label>
                        <input type="password" name="currentPassword" class="form-control">
                    </div>
                </div>
            </div>
            <a href="javascript:void(0);" class="btn btn_viewSearch" style="margin: 0px auto;" onclick="$.fancybox.close();">Nej</a>
            <button type="submit" class="btn btn_viewSearch" style="margin: 0px auto;">Ja</button>
            <?php echo form_close();?>
        </div>
    </div>
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
                },
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
                    remote: 'Dette brugernavn er i brug'
                },
                "currentPassword": {
                    required: 'Indtast din nuværende adgangskode',
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        $("#frm_changePass").validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "password":{
                    required:true,
                    minlength: 6
                },
                "repassword": {
                    equalTo: "#password"
                }
            },
            messages: {
                "password":{
                    required: "Indtast din ny adgangskode",
                    minlength: "Ny adgangskoden skal være på mellem {0} tegn."
                },
                "repassword": {
                    equalTo: 'Genadgangskoden er ikke som adgangskoden'
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        $('.standByForm').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "currentPassword": {
                    required:true,
                    minlength: 6
                }
            },
            messages: {
                "currentPassword": {
                    required: 'Indtast din nuværende adgangskode',
                    minlength: "Adgangskoden skal være på mellem {0} tegn."
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        $('.deactivateForm').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "currentPassword": {
                    required:true,
                    minlength: 6
                }
            },
            messages: {
                "currentPassword": {
                    required: 'Indtast din nuværende adgangskode',
                    minlength: "Adgangskoden skal være på mellem {0} tegn."
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        $('.deleteForm').validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().after());
            },
            rules: {
                "currentPassword": {
                    required:true,
                    minlength: 6
                }
            },
            messages: {
                "currentPassword": {
                    required: 'Indtast din nuværende adgangskode',
                    minlength: "Adgangskoden skal være på mellem {0} tegn."
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });

        isPasswordPresent = function () {
            return $('#password').val().length > 0;
        }

        $('input[name="chat"]').change(function(){
            if($(this).val() == 1){
                var chatMessage = '(Chatten er åben for alle bruger selv om i ikke er venner)';
                var chatInfo= 'Har du sat chatten "on" så er du åben for at enhver bruger på Habibidating kan skrive til dig, skulle du på et tidspunkt sætte chatten på "off" så er det kun dine venner på Habibidating der vil kunne skrive til dig.';
            } else {
                var chatMessage = '(Her kan du slå din chat til og fra efter ønske)';
                var chatInfo= 'Her kan du slå din chat til og fra efter eget ønske, accepteres en venneanmodning fra en anden bruger åbner chatten for vedkommende og chatten vil stadigvæk være lukket for andre bruger.';
            }
            $('#chat-info').html(chatMessage);
            $('#modalReadmore #message-content').html(chatInfo);
        });

        checkYear = function (year) {
            if(year == <?php echo date('Y') - 18;?>){
                var i;
                for (i = <?php echo date('m') + 1;?>; i <= 12; i++) {
                    $("select[name='month'] option[value='"+i+"']").attr('hidden', 'hidden');
                }
                for (i = <?php echo date('d') + 1;?>; i <= 31; i++) {
                    $("select[name='day'] option[value='"+i+"']").attr('hidden', 'hidden');
                }
            } else {
                $("select[name='month'] option[hidden='hidden']").removeAttr('hidden');
                $("select[name='day'] option[hidden='hidden']").removeAttr('hidden');
            }
        }
    });
</script>