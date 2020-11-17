<?php

require 'functions.php';

$parameters = array(
    "merchantId"=> Merchant_ID,
    "secretKey" => Secret_Key,
    "orderId" => "30",
    "callbackUrl"=> ZIBAL_CALLBACK_URL,
    "amount"=> 150000,
    "description" => "optional description"
);

var_dump($parameters);

$response = postToZibal('addOrder', $parameters, $sandbox=true);
var_dump($response);
if ($response->result == 1)
{
    var_dump("success");
}
else{
    echo "errorCode: ".$response->result."<br>";
    echo "message: ".$response->message;
    echo resultCodes($response->result);
}

?>