<section class="min-profile">
    <div class="container">
        <div class="row">
            <?php echo modules::run('left/left/index',$user->id);?>
            <div class="col-md-7">
                <div class="main_right">
                        <div class="frm_resgister">
                            <?php echo form_open_multipart('user/update', array('id'=>'frm_update'));?>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h3 class="text-uppercase mt0">Rediger profil</h3>
                                    </div>
                                    <?php if(empty($item->facebook)){?>
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <?php if(!empty($listProfilePictures)) { ?>
                                                <label for="">Dit profilbillede</label>
                                                <?php foreach ($listProfilePictures as $pic) { ?>
                                                <label class="avatar fl mr10">
                                                    <input type="radio" name="avatar"
                                                           value="<?php echo $pic->image; ?>" <?php if ($pic->image == $item->avatar) echo 'checked'; ?> />
                                                    <img src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/user/<?php echo $pic->image; ?>&w=150&h=150&q=100"
                                                         alt="" class="img-responsive"/>
                                                </label>
                                                <?php }
                                            } else {?>
                                                Du har ikke noget billede at vælge, <a href="<?php echo site_url('user/myphoto')?>">klik her</a> for at uploade
                                            <?php }?>

                                            <?php /*echo modules::run('left/left/avatar',$item, 270, 270);?>

                                            <?php if(empty($item->facebook)){?>
                                            <br>
                                            <?php if($item->avatar){ ?>
                                            <input type="checkbox" name="deleteProfilePicture" value="1"> Slet profilbillede
                                            <?php }?>
                                            <input type="file" name="newAvatar"/>
                                            <input type="hidden" name="avatar" value="<?php echo $item->avatar;?>"/>
                                            <?php }*/?>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Vælg dit profil navn <span class="red">*</span></label>
                                            <input type="text" class="form-control" id="" name="name" value="<?php echo $item->name;?>" placeholder="<?php echo $item->name;?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">E-mail <span class="red">*</span></label>
                                            <input type="text" class="form-control" disabled="true" value="<?php echo $item->email;?>" placeholder="<?php echo $item->email;?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Fødselsdag <span class="red">*</span></label>
                                            <div class="row">
                                                <?php 
                                                    $birthday = explode("/", $item->birthday);
                                                ?>
                                                <div class="col-xs-4">
                                                    <select name="day" class="form-control">
                                                        <?php for($i=1; $i<=31; $i++){?>
                                                            <option <?php if($birthday[0] == $i){echo 'selected="true"';}?> value="<?php echo $i;?>"><?php echo sprintf("%02s", $i);?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-4">
                                                    <select name="month" class="form-control">
                                                        <?php for($i=1; $i<=12; $i++){?>
                                                            <option <?php if($birthday[1] == $i){echo 'selected="true"';}?> value="<?php echo $i;?>"><?php echo sprintf("%02s", $i);?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                                <div class="col-xs-4">
                                                    <select name="year" class="form-control">
                                                        <?php
                                                            $yearend = date('Y',time()) - 18;
                                                            $yearstart = date('Y',time()) - 100;
                                                            for($i=$yearstart; $i<=$yearend; $i++){?>
                                                            <option <?php if($birthday[2] == $i){echo 'selected="true"';}?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <div class="form-group">
                                            <label for="">Postnr. <span class="red">*</span></label>
                                            <input type="text" class="form-control" name="code" value="<?php echo $item->code;?>" placeholder="<?php echo $item->code;?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Køn</label>
                                            <select name="gender" class="form-control">
                                                <option value="0">Vælg køn</option>
                                                <option <?php if($item->gender == 1){echo 'selected="true"';}?> value="1">Kvinde</option>
                                                <option <?php if($item->gender == 2){echo 'selected="true"';}?> value="2">Mand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Højde</label>
                                            <select name="height" class="form-control">
                                                <?php for($i=100; $i<=230; $i++){?>
                                                    <option <?php if($item->height == $i){echo 'selected="true"';}?> value="<?php echo $i;?>"><?php echo $i.' cm';?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Forhold</label>
                                            <select name="relationship" class="form-control">
                                                <option <?php if($item->relationship == 'Aldrig gift'){echo 'selected="true"';}?> value="Aldrig gift">Aldrig gift</option>
                                                <option <?php if($item->relationship == 'Separeret'){echo 'selected="true"';}?> value="Separeret">Separeret</option>
                                                <option <?php if($item->relationship == 'Skilt'){echo 'selected="true"';}?> value="Skilt">Skilt</option>
                                                <option <?php if($item->relationship == 'Enke/enkemand'){echo 'selected="true"';}?> value="Enke/enkemand">Enke/enkemand</option>
                                                <option <?php if($item->relationship == 'Det får du at vide senere'){echo 'selected="true"';}?> value="Det får du at vide senere">Det får du at vide senere</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Børn</label>
                                            <select name="children" class="form-control">
                                                <option <?php if($item->children == 'Nej'){echo 'selected="true"';}?> value="Nej">Nej</option>
                                                <option <?php if($item->children == 'Ja, hjemmeboende'){echo 'selected="true"';}?> value="Ja, hjemmeboende">Ja, hjemmeboende</option>
                                                <option <?php if($item->children == 'Ja, udeboende'){echo 'selected="true"';}?> value="Ja, udeboende">Ja, udeboende</option>
                                                <option <?php if($item->children == '1'){echo 'selected="true"';}?> value="1">1</option>
                                                <option <?php if($item->children == '2'){echo 'selected="true"';}?> value="2">2</option>
                                                <option <?php if($item->children == '3'){echo 'selected="true"';}?> value="3">3</option>
                                                <option <?php if($item->children == '3+'){echo 'selected="true"';}?> value="3+">3+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Etnisk oprindelse</label>
                                            <select name="ethnic_origin" class="form-control">
                                                <option <?php if($item->ethnic_origin == 'Europæisk'){echo 'selected="true"';}?> value="Europæisk">Europæisk</option>
                                                <option <?php if($item->ethnic_origin == 'Afrikansk'){echo 'selected="true"';}?> value="Sort/afrikansk">Afrikansk</option>
                                                <option <?php if($item->ethnic_origin == 'Latinamerikansk'){echo 'selected="true"';}?> value="Latinamerikansk">Latinamerikansk</option>
                                                <option <?php if($item->ethnic_origin == 'Asiatisk'){echo 'selected="true"';}?> value="Asiatisk">Asiatisk</option>
                                                <option <?php if($item->ethnic_origin == 'Indisk'){echo 'selected="true"';}?> value="Indisk">Indisk</option>
                                                <option <?php if($item->ethnic_origin == 'Arabisk'){echo 'selected="true"';}?> value="Arabisk">Arabisk</option>
                                                <option <?php if($item->ethnic_origin == 'Blandet/andet'){echo 'selected="true"';}?> value="Blandet/andet">Blandet/andet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Religion</label>
                                            <select name="religion" class="form-control">
                                                <option <?php if($item->religion == 'Agnostiker'){echo 'selected="true"';}?> value="Agnostiker">Agnostiker</option>
                                                <option <?php if($item->religion == 'Ateist'){echo 'selected="true"';}?> value="Ateist">Ateist</option>
                                                <option <?php if($item->religion == 'Buddhist'){echo 'selected="true"';}?> value="Buddhist">Buddhist</option>
                                                <option <?php if($item->religion == 'Kristen'){echo 'selected="true"';}?> value="Kristen">Kristen</option>
                                                <option <?php if($item->religion == 'Kristen – katolik'){echo 'selected="true"';}?> value="Kristen – katolik">Kristen – katolik</option>
                                                <option <?php if($item->religion == 'Jøde'){echo 'selected="true"';}?> value="Jøde">Jøde</option>
                                                <option <?php if($item->religion == 'Hindu'){echo 'selected="true"';}?> value="Hindu">Hindu</option>
                                                <option <?php if($item->religion == 'Muslim'){echo 'selected="true"';}?> value="Muslim">Muslim</option>
                                                <option <?php if($item->religion == 'Spirituel'){echo 'selected="true"';}?> value="Spirituel">Spirituel</option>
                                                <option <?php if($item->religion == 'Andet'){echo 'selected="true"';}?> value="Andet">Andet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Uddannelse</label>
                                            <select name="training" class="form-control">
                                                <option <?php if($item->training == 'Ingen eksamen'){echo 'selected="true"';}?> value="Ingen eksamen">Ingen eksamen</option>
                                                <option <?php if($item->training == 'Gymnasium/HF'){echo 'selected="true"';}?> value="Gymnasium/HF">Gymnasium/HF</option>
                                                <option <?php if($item->training == 'Fagskole'){echo 'selected="true"';}?> value="Fagskole">Fagskole</option>
                                                <option <?php if($item->training == 'Bachelorgrad'){echo 'selected="true"';}?> value="Bachelorgrad">Bachelorgrad</option>
                                                <option <?php if($item->training == 'Kandidat/ph.d.'){echo 'selected="true"';}?> value="Kandidat/ph.d.">Kandidat/ph.d.</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Kropsbygning</label>
                                            <select name="body" class="form-control">
                                                <option <?php if($item->body == 'Slank'){echo 'selected="true"';}?> value="Slank">Slank</option>
                                                <option <?php if($item->body == 'Atletisk'){echo 'selected="true"';}?> value="Atletisk">Atletisk</option>
                                                <option <?php if($item->body == 'Gennemsnitlig'){echo 'selected="true"';}?> value="Gennemsnitlig">Gennemsnitlig</option>
                                                <option <?php if($item->body == 'Buttet'){echo 'selected="true"';}?> value="Buttet">Buttet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Ryger</label>
                                            <select name="smoking" class="form-control">
                                                <option <?php if($item->smoking == 'Ja'){echo 'selected="true"';}?> value="Ja">Ja</option>
                                                <option <?php if($item->smoking == 'Nej'){echo 'selected="true"';}?> value="Nej">Nej</option>
                                                <option <?php if($item->smoking == 'Ja, festryger'){echo 'selected="true"';}?> value="Ja, festryger">Ja, festryger</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label for="">Stå ved guld medlem</label>
                                            <div class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-primary standby <?php if($item->stand_by_payment == 0) echo 'active';?>">
                                                    <input type="radio" name="stand_by_payment"  value="0" autocomplete="off" checked> Nej
                                                </label>
                                                <label class="btn btn-primary standby <?php if($item->stand_by_payment == 1) echo 'active';?>">
                                                    <input type="radio" name="stand_by_payment"  value="1" autocomplete="off"> Ja
                                                </label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Skriv et motto</label>
                                            <input type="text" name="slogan" class="form-control" value="<?php echo $item->slogan;?>"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Personbeskrivelse</label>
                                            <textarea name="description" class="form-control" rows="5"><?php echo $item->description;?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Vælg kodeord (min. 6 karakter)</label>
                                            <input type="password" class="form-control" name="password" id="password"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="">Gentag Kodeord</label>
                                            <input type="password" class="form-control" name="repassword"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group">
                                            <p><i>Alle felter med  <span class="red">*</span> skal udfyldes</i></p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <div class="form-group box_gray">
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <?php if(userType()==1){?>
                                                    <p><strong>Sølv medlem</strong></p>
                                                    <p>Gyldig: Ubegrænset</p>
                                                    <?php }else{?>
                                                    <p><strong>Gold medlem</strong></p>
                                                    Gyldig til <span class="w-color"><?php echo date("d-m-Y", strtotime("+1 month", $item->paymenttime));?></span>
                                                    <?php }?>
                                                </div>
                                                <div class="col-xs-6">
                                                    <?php if(userType()==1){?>
                                                    <a class="btnUpgrade_GoldMember" href="<?php echo site_url('user/upgrade');?>">Opgradér til guld medlem</a>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-xs-12">
                                        <p class="mb0"><a href="javascript:void(0)"><strong>Forbind Instagram</strong></a></p>
                                    </div>
                                    <div class="col-xs-12">
                                        <hr/>
                                    </div>
                                    <div class="col-lg-12 col-xs-12 mb30">
                                        <a href="javascript:void(0)" onclick="sendUpdate()" style="display: block;"><img src="<?php echo base_url();?>/templates/img/btnSave2.png" alt="" class="img-responsive"/></a>
                                    </div>
                                </div>
                                <!--<div class="row">
                                    <div class="col-xs-12">
                                        <hr/>
                                    </div>
                                </div>
                                <div class="row mb30">
                                    <div class="col-xs-12">
                                        <a href="javascript:void(0)" onclick="sendUpdate()"><img src="<?php /*echo base_url();*/?>/templates/img/btnSave2.png" alt="" class="img-responsive"/></a>
                                    </div>
                                </div>-->
                            <input type="hidden" name="userID" value="<?php echo $item->id;?>" />
                            <input type="submit" id="btnUpdate" onclick="update()" style="display: none;" value="submit" />
                            <?php echo form_close();?>
                            
                        </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</section>
<script>
function sendUpdate(){
    $('#btnUpdate').click();
}
$(document).ready(function(){
    $('#menu_minprofil').addClass('active');
});
</script>