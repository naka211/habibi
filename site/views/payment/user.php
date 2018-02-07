<section class="breadcrumb-custom">
    <div class="container">
        <div class="row">
            <ul class="breadcrumb">
                <li><a href="<?php echo base_url();?>">Forside</a></li>
                <li class="active">Betaling</a></li>
            </ul>
        </div>
    </div>
</section>
<section class="contact">
    <div class="container">
    <div class="frm_resgister col-md-8">
        <div class="row">
            <div class="col-xs-12">
                <h2>Betaling</h2>
            </div>
            <div class="col-xs-12" style="min-height: 400px;">
                <p>Du viderestilles nu til ePay. Nem og sikker betaling. <a href="http://www.epay.eu/epay-payment-solutions/"><img style="vertical-align: middle;" src="<?php echo base_url();?>templates/img/logo_epay.png"/></a></p>
                <div class="loading"></div>
                <div>
                    <script type="text/javascript">
                        $(document).ready(function(){
                            $("#epayForm").submit();
                        });
                        function sendPayment(){
                            $("#epayForm").submit();
                        }
                        setTimeout(function(){
                            //location.href = base_url_lang+'user/success';
                        }, 5000);
                    </script>
                    <form id="epayForm" action="<?php echo $action;?>" method="post">
                        <input type="hidden" name="merchantnumber" value="<?php echo $merchantnumber;?>"/>
                        <input type="hidden" name="amount" value="<?php echo $amount;?>"/>
                        <input type="hidden" name="currency" value="<?php echo $currency;?>"/>
                        <input type="hidden" name="windowstate" value="<?php echo $windowstate;?>"/>
                        <input type="hidden" name="orderid" value="<?php echo $orderid;?>" />
                        <input type="hidden" name="accepturl" value="<?php echo $accepturl;?>" />
                        <input type="hidden" name="callbackurl" value="<?php echo $callbackurl;?>"/>
                        <input type="hidden" name="cancelurl" value="<?php echo $cancelurl;?>" />
                        <input type="hidden" name="hash" value="<?php echo $md5;?>" />
                        <input type="hidden" name="subscription" value="1">
                        <input type="hidden" type="submit" value="Go to payment"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>