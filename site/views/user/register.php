<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="<?php echo base_url();?>">Forside</a></li>
                <li class="active">Register</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="contact">
    <div class="container">
        <div class="row mt30">
            <div class="col-xs-12">
                <ul class="steps">
                    <li class="active">TRIN 1</li>
                    <li>TRIN 2</li>
                </ul>
            </div>
        </div>
        <div class="frm_resgister col-md-8">
            <?php echo form_open('user/register', array('id'=>'frm_register'));?>
                <div class="row">
                    <div class="col-xs-12">
                        <h2>Bliv ZeDUUCE medlem</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Vælg dit profil navn <span class="red">*</span>
                            </label>
                            <input type="text" class="form-control" id="" name="name"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">E-mail <span class="red">*</span>
                        </label>
                        <input type="text" class="form-control" id="email" name="email" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Alder <span class="red">*</span></label>
                            <div class="row">
                                <div class="col-xs-4">
                                    <select name="day" class="form-control">
                                        <?php for($i=1; $i<=31; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo sprintf("%02s", $i);?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select name="month" class="form-control">
                                        <?php for($i=1; $i<=12; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo sprintf("%02s", $i);?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-xs-4">
                                    <select name="year" class="form-control">
                                        <?php
                                            $yearend = date('Y',time()) - 18;
                                            $yearstart = date('Y',time()) - 100;
                                            for($i=$yearstart; $i<=$yearend; $i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Postnr. <span class="red">*</span>
                            </label>
                            <input type="text" class="form-control" id="" name="code" maxlength="4"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Vælg kodeord  <span class="red">*</span> (min. 6 karakter)
                            </label>
                            <input type="password" class="form-control" id="password" name="password"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Gentag Kodeord <span class="red">*</span>
                            </label>
                            <input type="password" class="form-control" id="" name="repassword"/>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mb0">
                            <label for="">Vælg medlemskab</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="payment" value="0" checked="checked"/> Sølv medlem (gratis)
                                </label>
                                <label>
                                    <input type="radio" name="payment" value="1"/> Guld medlem (koster 149, - dkr. pr. mdr. inkl. moms)
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <hr/>
                        <div class="checkbox pull-right">
                            <label>
                                <input type="checkbox" name="accepterer" value="1"/>
                                Jeg har læst og accepterer <a href="<?php echo site_url('handelsbetingelser')?>" title="">brugerbetingelserne for Zeduuce</a>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt15 mb30">
                    <div class="col-xs-6">
                        <a href="javascript:history.back()" class="btnBack">TILBAGE</a>
                    </div>
                    <div class="col-xs-6">
                        <a class="pull-right" href="javascript:void(0)" onclick="sendRegister()"><img src="<?php echo base_url();?>/templates/img/gotoskin2.png" alt="" class="img-responsive"/></a>
                    </div>
                </div>
                <input type="submit" name="sendRegister" id="sendRegister" onclick="register()" style="display: none;" value="submit" />
            <?php echo form_close();?>
        </div>
    </div>
</section>
<script>
function sendRegister(){
    $('#sendRegister').click();
}
</script>