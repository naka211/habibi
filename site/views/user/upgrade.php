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
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php echo getContent(20, 'title');?>
                    <br>
                    <?php echo getContent(20, 'content');?>
                    <hr>
                    <div class="box_payment text-center">
                        <?php echo form_open(site_url('payment/upgrade'), array('id'=>'upgradeForm'))?>
                            <div class="radio-tile-group packages_option">
                                <div class="input-container">
                                    <input class="radio-button" name="free" checked type="radio" value="1">
                                    <div class="radio-tile">
                                        <label class="radio-tile-label">3 første måneder er gratis</label>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input class="radio-button" name="package" checked type="radio" value="1">
                                    <div class="radio-tile">
                                        <label class="radio-tile-label">1 måned</label>
                                        <p>Pris: <?php echo number_format($this->config->item('price1Month'), 0,',', '.')?> kr</p>
                                    </div>
                                </div>
                                <!--<div class="input-container">
                                    <input class="radio-button" name="package" type="radio" value="3">
                                    <div class="radio-tile">
                                        <label class="radio-tile-label">3 måneder</label>
                                        <p>Pris: <?php /*echo number_format($this->config->item('price3Months'), 0,',', '.')*/?> kr</p>
                                    </div>
                                </div>
                                <div class="input-container">
                                    <input class="radio-button" name="package" type="radio" value="6">
                                    <div class="radio-tile">
                                        <label class="radio-tile-label">6 måneder</label>
                                        <p>Pris: <?php /*echo number_format($this->config->item('price6Months'), 0,',', '.')*/?> kr</p>
                                    </div>
                                </div>-->
                            </div>
                            <p>Betal med betalingskort: </p>
                            <img src="<?php echo base_url();?>templates/images/1x/betaling01.png" alt="" class="img-responsive">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="tos" value="1" style="position: inherit;">
                                        Jeg accepterer <a target="_blank" class="btn-link" href="<?php echo site_url('home/abonnement');?>">betingelser for abonnement</a>
                                    </label>
                                </div>
                            </div>
                            <button type="submit" class="btn btnPayment">GÅ TIL BETALING</button>
                        <?php echo form_close();?>
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