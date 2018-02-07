<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url('home') ?>">Forside</a></li>
                <li><a href="<?php echo site_url('tilbud/index') ?>">Tilbud</a></li>
                <li class="active"><?php echo $item->name; ?></li>
            </ul>
        </div>
    </div>
</section>
<section class="tilbud">
    <div class="container">
        <div class="row mt30 mb30">
            <div class="col-md-12">
                <div id="ninja-slider" class="col-md-9 col-xs-12 col-sm-10 w_slider">
                    <div class="slider-inner">
                        <a class="i_favourite <?php if ($check) { echo 'i_favourite_active';} ?>" id="wishlist_<?php echo $item->id; ?>"                                 <?php if ($user) { ?>
                            <?php if (!$check) { ?>
                                href="javascript:void(0)" onclick="addWishList('<?php echo $item->id; ?>');"
                            <?php } else {?>
                                href="javascript:void(0)" onclick="removeWishList('<?php echo $item->id; ?>');"
                            <?php }
                        } else { ?> href="#Flogin" data-toggle="modal" <?php } ?>></a>
                        <ul>
                            <li>
                                <a class="ns-img"
                                   href="<?php echo base_url(); ?>/uploads/product/<?php echo $item->image; ?>"></a>
                                <span class="cate"><?php echo $item->company; ?></span>
                                <div class="info-bottom2 clearfix">
                                    <p class="deal-name"><?php echo $item->name; ?></p>
                                    <a href="javascript:void(0)" onclick="addCart('<?php echo $item->id; ?>')"
                                       class="btn btnOderNow">Bestil nu</a>
                                    <p class="price2">Pris: <?php echo priceFormat($item->price); ?></p>
                                </div>
                            </li>
                            <?php if ($image) {
                                foreach ($image as $row) { ?>
                                    <li>
                                        <a class="ns-img"
                                           href="<?php echo base_url(); ?>/uploads/product/<?php echo $row->image; ?>"></a>
                                        <span class="cate"><?php echo $item->company; ?></span>
                                        <div class="info-bottom2 clearfix">
                                            <p class="deal-name"><?php echo $item->name; ?></p>
                                            <a href="javascript:void(0)" onclick="addCart('<?php echo $item->id; ?>')"
                                               class="btn btnOderNow">Bestil nu</a>
                                            <p class="price2">Pris: <?php echo priceFormat($item->price); ?></p>
                                        </div>
                                    </li>
                                <?php }
                            } ?>
                            <input type="hidden" name="id_<?php echo $item->id; ?>" id="id_<?php echo $item->id; ?>"
                                   value="<?php echo $item->id; ?>"/>
                            <input type="hidden" name="qty_<?php echo $item->id; ?>" id="qty_<?php echo $item->id; ?>"
                                   value="1"/>
                            <input type="hidden" name="price_<?php echo $item->id; ?>"
                                   id="price_<?php echo $item->id; ?>" value="<?php echo $item->price; ?>"/>
                        </ul>
                        <div class="fs-icon" title="Expand/Close"></div>
                    </div>
                </div>
                <div id="thumbnail-slider" class="col-md-3 col-xl-12 col-sm-2">
                    <div class="inner">
                        <ul>
                            <li>
                                <a class="thumb"
                                   href="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $item->image; ?>&w=255&h=100&q=100"></a>
                            </li>
                            <?php if ($image) {
                                foreach ($image as $row) { ?>
                                    <li>
                                        <a class="thumb"
                                           href="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $row->image; ?>&w=255&h=100&q=100"></a>
                                    </li>
                                <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <?php echo $item->content; ?>
            </div>
        </div>
        <?php if($item->map_code){?>
        <div class="row mb30">
            <div class="col-lg-12">
                <div class="map">
                    <?php echo $item->map_code; ?>
                </div>
            </div>
        </div>
        <?php }?>
        <div class="row mb30">
            <div class="col-lg-12">
                <a class="btnBack" href="<?php echo site_url('tilbud/index'); ?>">Tilbage</a>
            </div>
        </div>

        <div class="row">
            <div class="related-deals">
                <div class="col-lg-12">
                    <h2>Related deals</h2>
                </div>
                <div class="result">
                    <?php if ($list) {
                        $i = 1;
                        foreach ($list as $row) { ?>
                            <div class="col-md-6 <?php if ($i % 2) {
                                echo "pl0-r10";
                            } else {
                                echo "pl0-r0";
                            } ?>">
                                <div class="item">
                                    <div class="item-img">
                                        <a href="<?php echo site_url('tilbud/detail/' . $row->id . '/' . seoUrl($row->name)); ?>"><img src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $row->image; ?>&w=570&h=350&q=100" alt="" class="img-responsive"></a>
                                        <span class="cate"><?php echo $row->company; ?></span>
                                        <div class="item-content clearfix">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h3><?php echo $row->name; ?></h3>
                                                    <p><?php echo $row->description; ?></p>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="price">Pris: <?php echo priceFormat($row->price); ?></div>
                                                    <a href="<?php echo site_url('tilbud/detail/' . $row->id . '/' . seoUrl($row->name)); ?>" class="btn btnOderNow">Bestil nu</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <?php $i++;
                        }
                    } ?>
                </div>
            </div>
        </div>

    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_tilbud').addClass('active');
    });
</script>