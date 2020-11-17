<?php

/**
 * put your merchant ID here.
 */
define("Merchant_ID","your merchantId");

/**
 * put your secret key here.
 */
define("Secret_Key","your secretKey");


define("ZIBAL_CALLBACK_URL","https://yourapiurl.com/callback.php");

/**
 * connects to zibal's rest api
 * @param $path
 * @param $parameters
 * @return stdClass
 */
function postToZibal($path, $parameters, $sandbox=false)
{
    if ($sandbox) {
        $url = 'https://sandbox-api.zibal.ir/merchant/'.$path;
    } else {
        $url = 'https://api.zibal.ir/merchant/'.$path;
    }    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($parameters));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response  = curl_exec($ch);
    curl_close($ch);
    return json_decode($response);
}

/**
 * returns a string message based on result parameter from curl response
 * @param $code
 * @return String
 */
function resultCodes($code)
{
    switch ($code) 
    {
        case 1:
            return "با موفقیت انجام شد.";
        case 2:
            return "احراز هویت با خطا همراه بود.";
        case 3:
            return "سفارشی با orderId ارسالی شما در سیستم زیبال موجود نمی‌باشد.";
        case 5:
            return "percentMode نامعتبر می‌باشد. (تنها 0 و 1 قابل قبول هستند)";
        case 6:
            return "amount بایستی بزرگتر از 10,000 ریال باشد.";
        case 7:
            return "یک یا چند ذی‌نفع در multiplexingInfos نامعتبر می‌باشند. اطلاعات بیشتر";
        case 8:
            return "یک یا چند ذی‌نفع در multiplexingInfos غیرفعال می‌باشند. اطلاعات بیشتر";
        case 9:
            return "id = self در multiplexingInfos وجود ندارد.";
        case 10:
            return "amount با مجموع سهم‌ها در multiplexingInfos برابر نمی‌باشد.";
        case 11:
            return "callbackUrl نامعتبر می‌باشد. (شروع با http و یا https)";
        case 18:
            return "موجودی کیف‌پول اصلی شما جهت ثبت این سفارش کافی نمی‌باشد. (در صورتی که feeMode == 1 )";

        default:
            return "وضعیت مشخص شده معتبر نیست";
    }
}