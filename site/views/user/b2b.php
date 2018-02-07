<section class="min-profile">
    <div class="container">
        <!--<div class="row">
            <div class="col-sm-12">
                <form action="" method="POST" class="form-inline" role="form">
                    <div class="form-group">
                        <input type="text" class="form-control w300" id="" placeholder="Indtast navn eller værdibevis nr.">
                        <button type="submit" class="btnSearch3">SØG</button>
                    </div>
                </form>
            </div>
        </div>-->
        <div class="row">
            <div class="col-sm-12">
                <div class="b2b_box clearfix">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Faktura nr.</th>
                                    <th>Dato & tid</th>
                                    <th>Produktets navn</th>
                                    <th>Antal bestilt</th>
                                    <th>Varens navn</th>
                                    <th>Beløb</th>
                                    <th>Ref. numre</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($deals as $deal){?>
                                <tr>
                                    <td>
                                        <p><?php echo $deal->orderId;?></p>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($deal->dt_create));?></td>
                                    <td><?php echo $deal->product_name;?></td>
                                    <td><?php echo $deal->quantity;?></td>
                                    <td><?php echo $deal->categoryName;?></td>
                                    <td><?php echo number_format($deal->price, 0)?></td>
                                    <td><?php echo $deal->codes;?></td>
                                    <td><div class="checkbox">
                                        <label>
                                            <input class="setUsed" type="checkbox" value="<?php echo $deal->id;?>" <?php if($deal->used == 1) echo 'checked disabled';?> id="deal<?php echo $deal->id;?>">
                                        </label>
                                    </div></td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <ul class="pagination pagination-sm pull-right">
                                <?php echo $pagination; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$(document).ready(function(){
    $('#menu_sold').addClass('active');
});
</script>