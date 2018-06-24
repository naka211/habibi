<div id="content">
    <section class="section_editProfile">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3>Rediger profil</h3>
                    <hr>
                    <?php echo form_open('user/update', array('id'=>'frm_update', 'class'=>'frm_efitProfile'));?>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Navn:</label>
                                    <input type="text" name="name" class="form-control" value="<?php echo $user->name;?>" placeholder="Forstadsfrøken">
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

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Land</label>
                                    <select name="region" class="form-control">
                                        <option value="Tyrkiet" <?php if($user->region == 'Tyrkiet'){echo 'selected="true"';}?>>Tyrkiet</option>
                                        <option value="Syrien" <?php if($user->region == 'Syrien'){echo 'selected="true"';}?>>Syrien</option>
                                        <option value="Irak" <?php if($user->region == 'Irak'){echo 'selected="true"';}?>>Irak</option>
                                        <option value="Libanon" <?php if($user->region == 'Libanon'){echo 'selected="true"';}?>>Libanon</option>
                                        <option value="Pakistan" <?php if($user->region == 'Pakistan'){echo 'selected="true"';}?>>Pakistan</option>
                                        <option value="Palæstina" <?php if($user->region == 'Palæstina'){echo 'selected="true"';}?>>Palæstina</option>
                                        <option value="Somalia" <?php if($user->region == 'Somalia'){echo 'selected="true"';}?>>Somalia</option>
                                        <option value="Afghanistan" <?php if($user->region == 'Afghanistan'){echo 'selected="true"';}?>>Afghanistan</option>
                                        <option value="Bosnien" <?php if($user->region == 'Bosnien'){echo 'selected="true"';}?>>Bosnien</option>
                                        <option value="Iran" <?php if($user->region == 'Iran'){echo 'selected="true"';}?>>Iran</option>
                                        <option value="Marokko" <?php if($user->region == 'Marokko'){echo 'selected="true"';}?>>Marokko</option>
                                        <option value="Albanien" <?php if($user->region == 'Albanien'){echo 'selected="true"';}?>>Albanien</option>
                                        <option value="Algeriet" <?php if($user->region == 'Algeriet'){echo 'selected="true"';}?>>Algeriet</option>
                                        <option value="Egypten" <?php if($user->region == 'Egypten'){echo 'selected="true"';}?>>Egypten</option>
                                        <option value="Makedionen" <?php if($user->region == 'Makedionen'){echo 'selected="true"';}?>>Makedionen</option>
                                        <option value="Andet" <?php if($user->region == 'Andet'){echo 'selected="true"';}?>>Andet</option>
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
                                    <label for="">Etnisk oprindelse:</label>
                                    <select name="ethnic_origin" class="form-control">
                                        <option <?php if($user->ethnic_origin == 'Europæisk'){echo 'selected="true"';}?> value="Europæisk">Europæisk</option>
                                        <option <?php if($user->ethnic_origin == 'Afrikansk'){echo 'selected="true"';}?> value="Sort/afrikansk">Afrikansk</option>
                                        <option <?php if($user->ethnic_origin == 'Latinamerikansk'){echo 'selected="true"';}?> value="Latinamerikansk">Latinamerikansk</option>
                                        <option <?php if($user->ethnic_origin == 'Asiatisk'){echo 'selected="true"';}?> value="Asiatisk">Asiatisk</option>
                                        <option <?php if($user->ethnic_origin == 'Indisk'){echo 'selected="true"';}?> value="Indisk">Indisk</option>
                                        <option <?php if($user->ethnic_origin == 'Arabisk'){echo 'selected="true"';}?> value="Arabisk">Arabisk</option>
                                        <option <?php if($user->ethnic_origin == 'Blandet/andet'){echo 'selected="true"';}?> value="Blandet/andet">Blandet/andet</option>
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

                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Køn:</label>
                                    <select name="gender" class="form-control">
                                        <option <?php if($user->gender == 1){echo 'selected="true"';}?> value="1">Mand</option>
                                        <option <?php if($user->gender == 2){echo 'selected="true"';}?> value="2">Kvinde</option>
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Vælg kodeord (min. 6 karakter):</label>
                                    <input type="text" name="password" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="form-group">
                                    <label for="">Gentag Kodeord:</label>
                                    <input type="text" name="repassword" class="form-control">
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