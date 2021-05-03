<?php

use Carbon\Carbon;
use App\User;
use App\Models\Marketing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Invoice;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}

function return_date_wo_time($date){
    return Carbon::parse($date)->format('j F, Y.');
}

function return_date_pdf($date)
{
    return Carbon::parse($date)->format('j F, Y');
}

function return_todays_date()
{
    return Carbon::now();
}

function return_user_name($id)
{
    $user = User::find($id);
    return optional($user)->name;
}

function return_decimal_number($foo)
{
    return number_format((float)$foo, 2, '.', '');
}

function curl($handle)
{
    // phpinfo();
    $curl = curl_init();

    $nonce = mt_rand();
    $timestamp = time();

    $header[] = 'Authorization: OAuth '.
            'Bearer="AAAAAAAAAAAAAAAAAAAAAAlLPAEAAAAAdQyFQK%2Fc26eiUKdzjKZvI%2F24rgA%3DIEgYW2V3ZkLDwCAAGRWmg8agofyFEDESDPyoqTDk1rwH68cu3d"'.
            ',oauth_consumer_key="IRkKFMhbSCJ4EdyrWBgIT3yur"'.
            ',oauth_consumer_secret="TwZX4f1MN2yl8V7BUr7jEEw883PvOEd8ey8RLNgNl0FrGry9RC"'.
            ',oauth_token_secret="QjdNkgj9wr4hjYdNOZuAS7ulcgOlNCvHdpVXrvSwkDwzH"'.
            ',oauth_signature_method="HMAC-SHA1"'.
            ',oauth_nonce="'.$nonce.'"'.
            ',oauth_timestamp="'.$timestamp.'"'.
            ',oauth_version="1.0"'.
            ',oauth_token="1512823328-VToWBx6qwvXaxiyOiIFq9DvyROxkNtX7zyqAzHH"'.
            ',Content-Type=application/json'
            ;

    curl_setopt($curl, CURLOPT_URL, 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name='.$handle.'&count=10');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $result = curl_exec($curl);

    if(!$result){
        die("Connection Failure");
    }

    curl_close($curl);
    return json_decode($result, true);
}