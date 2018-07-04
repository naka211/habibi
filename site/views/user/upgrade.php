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
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit rerum maxime consequuntur non odit optio, minima perferendis quibusdam recusandae veniam?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores eos omnis blanditiis, voluptas non modi pariatur, nihil laudantium cum repellat ab assumenda maxime, dolorem, nostrum odit quaerat eius dolor autem aliquam necessitatibus impedit soluta consequatur! Veniam maxime dolorum delectus nemo corporis nulla ab. Quo error, eligendi enim tempora recusandae officia.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, dolor.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste laboriosam repellat velit commodi inventore quidem voluptatibus facere quam nemo, assumenda voluptas ea dolor deserunt ut error debitis, fuga dolore, quod, magni culpa odio fugiat fugit nulla! Soluta, repudiandae. Quisquam neque ab, quasi cupiditate commodi maiores. Ea tenetur doloremque similique ullam tempora voluptates culpa praesentium repellendus nesciunt, rerum pariatur facere incidunt.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas explicabo maiores amet. Maxime beatae, commodi molestiae est nostrum laboriosam reprehenderit ab, cupiditate possimus eaque maiores hic odit. Unde fuga fugiat architecto sapiente, impedit, animi ducimus odio optio delectus molestiae nesciunt.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id esse ut suscipit adipisci qui modi, optio velit commodi dolorem voluptatibus? Impedit id minima velit suscipit minus labore architecto ullam nobis, sapiente voluptatem fugit dignissimos perferendis sequi ad porro, rem deleniti nisi doloremque. Harum nihil id ex explicabo totam, consectetur tempora fugit illo, enim inventore, nisi! Hic in assumenda sapiente autem beatae, itaque ad praesentium voluptatem, facere cupiditate omnis officia impedit error amet laborum, ducimus saepe illum vitae voluptates sed. Id.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reprehenderit rerum maxime consequuntur non odit optio, minima perferendis quibusdam recusandae veniam?</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores eos omnis blanditiis, voluptas non modi pariatur, nihil laudantium cum repellat ab assumenda maxime, dolorem, nostrum odit quaerat eius dolor autem aliquam necessitatibus impedit soluta consequatur! Veniam maxime dolorum delectus nemo corporis nulla ab. Quo error, eligendi enim tempora recusandae officia.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam, dolor.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste laboriosam repellat velit commodi inventore quidem voluptatibus facere quam nemo, assumenda voluptas ea dolor deserunt ut error debitis, fuga dolore, quod, magni culpa odio fugiat fugit nulla! Soluta, repudiandae. Quisquam neque ab, quasi cupiditate commodi maiores. Ea tenetur doloremque similique ullam tempora voluptates culpa praesentium repellendus nesciunt, rerum pariatur facere incidunt.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas explicabo maiores amet. Maxime beatae, commodi molestiae est nostrum laboriosam reprehenderit ab, cupiditate possimus eaque maiores hic odit. Unde fuga fugiat architecto sapiente, impedit, animi ducimus odio optio delectus molestiae nesciunt.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Id esse ut suscipit adipisci qui modi, optio velit commodi dolorem voluptatibus? Impedit id minima velit suscipit minus labore architecto ullam nobis, sapiente voluptatem fugit dignissimos perferendis sequi ad porro, rem deleniti nisi doloremque. Harum nihil id ex explicabo totam, consectetur tempora fugit illo, enim inventore, nisi! Hic in assumenda sapiente autem beatae, itaque ad praesentium voluptatem, facere cupiditate omnis officia impedit error amet laborum, ducimus saepe illum vitae voluptates sed. Id.</p>
                    <hr>
                    <div class="box_payment text-center">
                        <h4>GULD ABONNEMENT 149 kr. / pr.mdr. (Du kan afmelde når som helst.)</h4>
                        <p>Betal med betalingskort: </p>
                        <img src="<?php echo base_url();?>templates/images/1x/betaling01.png" alt="" class="img-responsive">
                        <?php echo form_open(site_url('payment/upgrade'), array('id'=>'upgradeForm'))?>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="tos" value="1">
                                        Accepter <a target="_blank" class="btn-link" href="#" title="">betingelser</a> om et løbende abonnement
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