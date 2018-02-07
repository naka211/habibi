<?php
if($kisses){
    foreach ($kisses as $kiss) {
        $kissTime = strtotime($kiss->dt_create);
        ?>
        <div class="row kiss_log" id="kiss<?php echo $kiss->id;?>">
            <div class="col-md-8">
                <div class="info_people_attending">
                    <img src="<?php echo base_url();?>/templates/img/i_lip_small.png" alt="" class="img-responsive mt5">
                    <?php echo date('d/m/Y', $kissTime).' Kl.'.date('H:i', $kissTime);?>
                </div>
            </div>
            <div class="col-md-4">
                <a class="btn_Delete1" href="javascript:void(0);" value="<?php echo $kiss->id;?>">Slet</a>
            </div>
        </div>
        <?php
    }
} else {
    echo 'Intet kys at vise';
}
?>