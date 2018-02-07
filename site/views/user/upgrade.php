<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="index.php">Forside</a></li>
                <li class="active">Opgradere til guldmedlem</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="forget-pass">
    <div class="container">
        <div class="row mt30 mb30">
            <div class="col-md-9">
                <h2>Opgradere til guldmedlem</h2>
                <p class="f14">Guld medlem (koster 149, - dkr. pr. mdr. inkl. moms) </p>
                <div class="frm-forgetpass mt30">
                    <?php echo form_open(site_url('payment/upgrade'), array('id'=>'upgradeForm', 'class'=>'form-inline'))?>
                        <button type="submit" class="btn btnSend">Opgradering</button>
                    <?php echo form_close();?>
                </div>
            </div>
        </div>
    </div>
</section>