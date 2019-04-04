<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <h3>Opgradere til guldmedlem</h3>
                    </div>
                </div>
            </div>
            <div class="banner_upgrade">
                <div class="col-12">
                    <img src="<?php echo base_url().'templates/';?>images/1x/banner_upgrade.jpg" alt="" class="img-responsive">
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="w_table_upgradeMembership">
                        <h3>Fordele guld medlemskab</h3>
                        <table class="table table-condensed mt30 table_membership table_upgradeMembership">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Sølv</th>
                                <th class="text-center">Guld</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Personlig profilside</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Upload profil billed</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Upload billeder til album</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Unik personlig log in </td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Søgning mellem alle profiler på siden</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Sende venneanmodninger</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Se modtaget venneanmodninger</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_noOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Sende besked</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_noOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Læse modtaget besked</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_noOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Sende blink</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Se modtaget blink</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_noOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Tilføj favorit</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Se besøgende</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_noOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            <tr>
                                <td>Tilføj ven</td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                                <td><img src="<?php echo base_url().'templates/';?>images/1x/i_checkOption.png" alt=""></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="box_gopayment text-center">
                        <h4>De første 3 måneder er gratis<br>
                            Herefter koster det 99,- om måneden</h4>
                        <div class="box_gopayment_mid">
                            <p>Betal med betalingskort:</p>
                            <img src="<?php echo base_url().'templates/';?>images/1x/betaling01.png" alt="" class="img-responsive>
                <form action="" method="POST" role="form">
                            <?php echo form_open(site_url('payment/upgrade'), array('id'=>'upgradeForm'))?>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="tos" value="1">
                                        <span>Jeg accepterer <a target="_blank" class="btn-link" href="<?php echo site_url('home/abonnement');?>" title="">betingelser for abonnement</a></span>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btnPayment">GÅ TIL BETALING</button>
                            <input type="hidden" name="package" value="1">
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="application/javascript">
    $(document).ready(function () {
        $("#upgradeForm").validate({
            errorPlacement: function(error, element) {
                error.appendTo(element.parent().parent().after());
            },
            rules: {
                "tos":{
                    required:true,
                }
            },
            messages: {
                "tos":{
                    required: 'Du accepterer vilkår og betingelser for at fortsætte',
                }
            },
            submitHandler: function(form){
                form.submit();
            }
        });
    });
</script>