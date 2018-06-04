<div id="content">
    <section class="friend_list mt52">
        <div class="container">
            <div class="friend_list_lead">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Betaling</h3>
                    </div>
                </div>
            </div>
            <p>Du viderestilles nu til ePay. Nem og sikker betaling. <a href="http://www.epay.eu/epay-payment-solutions/"><img style="vertical-align: middle;" src="<?php echo base_url();?>templates/images/logo_epay.png"/></a></p>
            <div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $("#epayForm").submit();
                    });
                    /*function sendPayment(){
                        $("#epayForm").submit();
                    }*/

                </script>
                <form id="epayForm" action="https://ssl.ditonlinebetalingssystem.dk/integration/ewindow/Default.aspx" method="post">
                    <input type="hidden" name="merchantnumber" value="<?php echo $merchantnumber;?>"/>
                    <input type="hidden" name="amount" value="<?php echo $amount;?>"/>
                    <input type="hidden" name="currency" value="<?php echo $currency;?>"/>
                    <input type="hidden" name="windowstate" value="<?php echo $windowstate;?>"/>
                    <input type="hidden" name="orderid" value="<?php echo $orderid;?>" />
                    <input type="hidden" name="accepturl" value="<?php echo $accepturl;?>" />
                    <input type="hidden" name="callbackurl" value="<?php echo $callbackurl;?>"/>
                    <input type="hidden" name="cancelurl" value="<?php echo $cancelurl;?>" />
                    <input type="hidden" name="subscription" value="1">
                    <input type="hidden" type="submit" value="Go to payment"/>
                </form>
            </div>
        </div>
    </section>
</div>