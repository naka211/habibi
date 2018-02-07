<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Forside</a></li>
                <li class="active">Indkøbs kurv</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="cart-page">
    <div class="container">
        <div class="row mt30">
            <div class="col-md-12">
                <ul class="steps">
                    <li>TRIN 1</li>
                    <li class="active">TRIN 2</li>
                    <li>TRIN 3</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <h2><strong>Bestilling</strong></h2>
            </div>
            <div class="col-md-4">
                <?php if ($user) { ?>
                    <h4><strong>Personlig information</strong></h4>
                    <p>Profilenr. : <?php echo $user->id; ?></p>
                    <p>Profil navn : <?php echo $user->name; ?></p>
                    <p>Postnr. : <?php echo $user->code; ?></p>
                    <p>E-mail : <a href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a></p>
                <?php } else { ?>
                    <h4><strong>Er du Zeduuce medlem?</strong></h4>
                    <div class="box_member">
                        <p>Husk dine Zeduuce rabatfordele. Login og gå direkte til betaling </p>
                        <a href="#Flogin" data-toggle="modal"><img
                                    src="<?php echo base_url(); ?>templates/img/btnTrykher.png" alt=""
                                    class="img-responsive"></a>
                    </div>
                    <h4><strong>Er du ikke Zeduuce medlem?</strong></h4>
                    <div class="box_member">
                        <p>Gå ikke glip af Zeduuce rabatfordelene. Opret gratis Zeduuce medlemskab og gå til betaling
                            med Sugar rabat </p>
                        <a href="<?php echo site_url('user/register'); ?>"><img
                                    src="<?php echo base_url(); ?>templates/img/btnTrykher.png" alt=""
                                    class="img-responsive"></a>
                    </div>
                <?php } ?>
            </div>
            <div class="col-md-8">
                <h4><strong>Min indkøbskurv</strong></h4>
                <div class="table-responsive table-cart1">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="90%">Produkt</th>
                            <th>Pris</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($list) {
                            foreach ($list as $row) { ?>
                                <tr>
                                    <td>
                                        <div class="img-cart">
                                            <img class="img-responsive"
                                                 src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $row->image; ?>&w=310&h=135&q=100"
                                                 alt=""/>
                                        </div>
                                        <h3 class="name_deal"><?php echo $row->name; ?></h3>
                                        <div class="title-cart"><?php echo $row->description; ?></div>
                                    </td>
                                    <td><?php echo priceFormat($row->price); ?></td>
                                </tr>
                            <?php }
                        } ?>
                        <tr>
                            <td colspan="2">
                                <p class="total-price"><span class="total-price-title">Subtotal inkl. moms:</span>
                                    <span><?php echo priceFormat($total) ?></span></p>
                                <p class="total-price"><span class="total-price-title">Heraf moms: </span>
                                    <span><?php echo priceFormat($total * 0.2) ?></span></p>
                                <p class="total-price"><span class="total-price-title">Total inkl. moms:</span>
                                    <span><?php echo priceFormat($total) ?></span></p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="accept" id="accept"/>
                                        <span class="f13">Jeg har læst og accepterer Zeduuce</span> <a
                                                class="f13 c760672" href="<?php echo site_url('handelsbetingelser') ?>"
                                                target="_blank" title="">vilkår og handelsbetingelser</a>
                                    </label>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mb30">
            <hr/>
            <div class="col-lg-12">
                <a class="pull-right" <?php if ($user) { ?> onclick="checkAcceptShop()" <?php } else { ?> onclick="noLogin()" <?php } ?>
                   href="javascript:void(0)"><img src="<?php echo base_url(); ?>templates/img/btnPayment.png"
                                                  alt=""/></a>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_tilbud').addClass('active');
    });
</script>