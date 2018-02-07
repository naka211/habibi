<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Forside</a></li>
                <li class="active">Tilbud</li>
            </ul>
        </div>
    </div>
</section>
<section class="tilbud">
    <div class="container">
        <?php echo form_open('tilbud/search', array('id' => 'frm_search', 'method' => 'GET')); ?>
        <div class="row">
            <div class="col-lg-12">
                <h2>Tilbud</h2>
                <p>Nu kan du tage Zeduuce.dk med i lommen og lade kærligheden blomstre uanset om du sidder i bussen,
                    eller nyder en kop kaffe på din yndlingscafé. Med vores apps til både iPhone og Android telefoner er
                    din nye flirt altid i nærheden, så I endnu hurtigere kan lære hinanden at kende. Lorem ipsum dolor
                    sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros</p>
                <ul class="list-topic">
                    <li>
                        <div class="radio">
                            <label class="<?php if (!$this->input->get('category_id')) {echo 'bg_active';} ?>">
                                <input name="category_id" value="0" <?php if (!$category_id) {echo 'checked';} ?> type="radio" onclick="">
                                Se alle
                            </label>
                        </div>
                    </li>
                    <?php if ($category) {
                        foreach ($category as $row) { ?>
                            <li <?php if ($this->input->get('category_id') == $row->category_id) {
                                echo 'class="active"';
                            } ?>>
                                <div class="radio">
                                    <label class="<?php if ($this->input->get('category_id') == $row->category_id) {echo 'bg_active';} ?>">
                                        <input name="category_id" value="<?php echo $row->category_id?>" <?php if ($this->input->get('category_id') == $row->category_id) {echo 'checked';} ?> type="radio">
                                        <?php echo $row->name; ?>
                                    </label>
                                </div>
                            </li>
                        <?php }
                    } ?>
                </ul>
            </div>
        </div>
        <div class="row frm-filter">
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="">Fra postnr.</label>
                            <select name="postfrom" id="" class="form-control">
                                <?php for($i = 1000; $i<=9500; $i += 500){?>
                                    <option value="<?php echo $i; ?>" <?php if($this->input->get("postfrom")==$i)echo 'selected';?>><?php echo $i; ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="line"></div>
                            <label for="">Til postnr.</label>
                            <select name="postto" id="" class="form-control">
                                <?php for($i = 1500; $i<=9500; $i += 500){?>
                                    <option value="<?php echo $i; ?>" <?php if($this->input->get("postto")==$i)echo 'selected';?>><?php echo $i; ?></option>
                                <?php }?>
                                <option value="9999" <?php if(empty($this->input->get("postto")) || $this->input->get("postto")==9999)echo 'selected';?>>9999</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <label for="">Pris fra kr.</label>
                            <select name="pricefrom" id="" class="form-control">
                                <?php for($i = 0; $i<=10000; $i += 200){?>
                                    <option value="<?php echo $i; ?>" <?php if($this->input->get("pricefrom")==$i)echo 'selected';?>><?php echo $i; ?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="form-group">
                            <div class="line"></div>
                            <label for="">Pris til kr.</label>
                            <select name="priceto" id="" class="form-control">
                                <?php for($i = 0; $i<10000; $i += 200){?>
                                    <option value="<?php echo $i; ?>" <?php if($this->input->get("priceto")==$i)echo 'selected';?>><?php echo $i; ?></option>
                                <?php }?>
                                <option value="10000" <?php if(empty($this->input->get("priceto")) || $this->input->get("priceto")==10000)echo 'selected';?>>10000</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btnSearch2">Søg</button>
            </div>
        </div>
        <?php echo form_close(); ?>
        <div class="result">
            <div class="row">
                <?php
                if ($list) {
                    $i = 1;
                    $j = 0;
                    foreach ($list as $row) {
                        if ($wishlist) {
                            if ($wishlist[$j]['id'] > 0) {
                                $check = 1;
                            } else {
                                $check = 0;
                            }
                        } else {
                            $check = 0;
                        }
                        ?>
                        <div class="col-md-6 item">
                            <div class="item-img">
                                <a class="i_favourite <?php if ($check) { echo 'i_favourite_active';} ?>" id="wishlist_<?php echo $row->id; ?>"                                 <?php if ($user) { ?>
                                    <?php if (!$check) { ?>
                                        href="javascript:void(0)" onclick="addWishList('<?php echo $row->id; ?>');"
                                    <?php } else {?>
                                        href="javascript:void(0)" onclick="removeWishList('<?php echo $row->id; ?>');"
                                    <?php }
                                    } else { ?> href="#Flogin" data-toggle="modal"
                                <?php } ?>></a>
                                <a href="<?php echo site_url('tilbud/detail/' . $row->id . '/' . seoUrl($row->name)); ?>"><img src="<?php echo base_url(); ?>thumb/timthumb.php?src=<?php echo base_url(); ?>uploads/product/<?php echo $row->image; ?>&w=555&h=350&q=100" alt="" class="img-responsive"></a>
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
                        <?php $i++;
                        $j++;
                    }
                } else {
                    ?>
                    <div class="col-md-6">
                        <p style="min-height: 200px;">Der er ingen produkt, der matcher søgekriterierne.</p>
                    </div>
                <?php } ?>
            </div>
            <div class="row text-center">
                <ul class="pagination">
                    <?php echo $pagination; ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#menu_tilbud').addClass('active');
    });
</script>