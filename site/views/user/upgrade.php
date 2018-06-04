<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Opgradere til guldmedlem</h3>
                    </div>
                </div>
            </div>


            <p>Guld medlem (koster 149, - dkr. pr. mdr. inkl. moms)</p><br>
                <?php echo form_open(site_url('payment/upgrade'), array('id'=>'upgradeForm', 'class'=>'form-inline'))?>
                <button type="submit" class="btn bntMessage">Opgradering</button>
                <?php echo form_close();?>

        </div>
    </section>
</div>