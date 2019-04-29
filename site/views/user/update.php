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
                                            <?php echo generateOptionsInRangeHTML('year', 1930, 2010, $user->year);?>
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
                                    <?php echo generateOptionsHTMLInUpdate('land', 'land', $user->land);?>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <?php echo generateOptionsHTMLInUpdate('region', 'region', $user->region);?>
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h5>Jeg søger</h5>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Land</label>
                                    <?php echo generateOptionsHTMLInUpdate('land', 'find_land', $user->find_land);?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <?php echo generateOptionsHTMLInUpdate('region', 'find_region', $user->find_region);?>
                                </div>
                            </div>

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
                                    <span style="margin-left: 10px; font-weight: 500;">
                                        (Her kan du slå din chat til og fra efter ønske.)
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
                        <button type="submit" class="btn btnadd_friend">Opdatere</button>

                    <?php if($user->type == 2){?>
                        <hr>
                        <h3 style="margin: 0;">Standby af dit medlemskab</h3>
                        <?php if($user->stand_by_payment == 0){
                        ?>
                            <a href="javascript:void(0);" data-fancybox data-src="#modalStandBy" class="btn btn_viewSearch">Sæt medlemskab I bero</a>
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
                    <?php echo form_close();?>
                </div>
            </div>

            <div class="row">

            </div>
        </div>
    </section>
</div>
<div style="display: none;" id="modalStandBy" class="animated-modal modalLogin">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php echo form_open('user/setStandByStatus/1', array('class'=>'standByForm'));?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p class="f19" id="error-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim a arcu et rutrum. Phasellus vel fringilla mi. Nunc convallis sapien sit amet pretium aliquam. Integer nec pharetra elit, nec aliquam justo.<br><br>
                    Quisque est massa, lobortis eu efficitur sed, tempus scelerisque orci. Suspendisse interdum massa non nisl mollis mollis. Nullam lacinia, metus interdum accumsan feugiat, arcu mi venenatis neque, quis tristique dui arcu ut lectus.</p>
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
                <p class="f19" id="error-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim a arcu et rutrum. Phasellus vel fringilla mi. Nunc convallis sapien sit amet pretium aliquam. Integer nec pharetra elit, nec aliquam justo.<br><br>
                    Quisque est massa, lobortis eu efficitur sed, tempus scelerisque orci. Suspendisse interdum massa non nisl mollis mollis. Nullam lacinia, metus interdum accumsan feugiat, arcu mi venenatis neque, quis tristique dui arcu ut lectus.</p>
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
                <p class="f19" id="error-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum dignissim a arcu et rutrum. Phasellus vel fringilla mi. Nunc convallis sapien sit amet pretium aliquam. Integer nec pharetra elit, nec aliquam justo.<br><br>
                    Quisque est massa, lobortis eu efficitur sed, tempus scelerisque orci. Suspendisse interdum massa non nisl mollis mollis. Nullam lacinia, metus interdum accumsan feugiat, arcu mi venenatis neque, quis tristique dui arcu ut lectus.</p>
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
                    remote: 'Dette brugernavn er i brug'
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

    });
</script>