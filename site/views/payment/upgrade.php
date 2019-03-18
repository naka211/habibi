<?php
function sign($params, $api_key) {
    $flattened_params = flatten_params($params);
    ksort($flattened_params);
    $base = implode(" ", $flattened_params);

    return hash_hmac("sha256", $base, $api_key);
}

function flatten_params($obj, $result = array(), $path = array()) {
    if (is_array($obj)) {
        foreach ($obj as $k => $v) {
            $result = array_merge($result, flatten_params($v, $result, array_merge($path, array($k))));
        }
    } else {
        $result[implode("", array_map(function($p) { return "[{$p}]"; }, $path))] = $obj;
    }

    return $result;
}
$version = "v10";
$merchant_id = 83338;
$agreement_id = 290680;
$currency = "DKK";
$language = "da";
$autocapture = 1;
$subscription = 1;
$description = 'vip-member';
$params = array(
    "version"      => $version,
    "merchant_id"  => $merchant_id,
    "agreement_id" => $agreement_id,
    "order_id"     => $orderid,
    "amount"       => $amount,
    "currency"     => $currency,
    "language"     => $language,
    "autocapture"  => $autocapture,
    "subscription"  => $subscription,
    "description"  => $description,
    "continueurl" => $continueurl,
    "cancelurl"   => $cancelurl,
    "callbackurl" => $callbackurl,
);

$checksum = sign($params, "614402e644103754ed00e9450a2b7f7cb20b809b860f8bd5a9a762352c2778c3");
?>
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
            <p>Du viderestilles nu til Quickpay. Nem og sikker betaling.</p>
            <div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        //$("#quickpayForm").submit();
                    });
                    /*function sendPayment(){
                        $("#epayForm").submit();
                    }*/

                </script>

                <form method="POST" action="https://payment.quickpay.net" id="quickpayForm">
                    <input type="hidden" name="version" value="<?php echo $version?>">
                    <input type="hidden" name="merchant_id" value="<?php echo $merchant_id?>">
                    <input type="hidden" name="agreement_id" value="<?php echo $agreement_id?>">
                    <input type="hidden" name="order_id" value="<?php echo $orderid?>">
                    <input type="hidden" name="amount" value="<?php echo $amount?>">
                    <input type="hidden" name="currency" value="<?php echo $currency?>">
                    <input type="hidden" name="language" value="<?php echo $language?>">
                    <input type="hidden" name="autocapture" value="<?php echo $autocapture?>">
                    <input type="hidden" name="subscription" value="<?php echo $subscription?>">
                    <input type="hidden" name="description" value="<?php echo $description?>">
                    <input type="hidden" name="continueurl" value="<?php echo $continueurl?>">
                    <input type="hidden" name="cancelurl" value="<?php echo $cancelurl?>">
                    <input type="hidden" name="callbackurl" value="<?php echo $callbackurl?>">
                    <input type="hidden" name="checksum" value="<?php echo $checksum?>">
                    <input type="submit" value="Continue to payment...">
                </form>
            </div>
        </div>
    </section>
</div>