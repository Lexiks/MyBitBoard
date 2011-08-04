<?php
function mtgox_query($path, array $req = array()) {
    // API settings
    global $mtgox_key,$mtgox_secret;
 
    // generate a nonce as microtime, with as-string handling to avoid problems with 32bits systems
    $mt = explode(' ', microtime());
    $req['nonce'] = $mt[1].substr($mt[0], 2, 6);
 
    // generate the POST data string
    $post_data = http_build_query($req, '', '&');
 
    // generate the extra headers
    $headers = array(
        'Rest-Key: '.$mtgox_key,
        'Rest-Sign: '.base64_encode(hash_hmac('sha512', $post_data, base64_decode($mtgox_secret), true)),
    );
 
    // our curl handle (initialize if required)
    static $ch = null;
    if (is_null($ch)) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MtGox PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
    }
    curl_setopt($ch, CURLOPT_URL, 'https://mtgox.com/api/'.$path);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
 
    // run the query
    try {
    $res = curl_exec($ch);
    } catch (Exception $e) {
    unset($res);
}
    
    //if ($res === false) throw new Exception('Could not get reply: '.curl_error($ch));
   if (isset($res)) { $dec = json_decode($res, true);}
    //if (!$dec) throw new Exception('Invalid data received, please make sure connection is working and requested API exists');
    return $dec;
}
 
// example 1: get infos about the account, plus the list of rights we have access to
//$q = mtgox_query('0/info.php');
//var_dump($q);
 
//$funds = mtgox_query('0/getFunds.php');
function BuyBTC($amount,$price)
{
  return mtgox_query('0/buyBTC.php', array('amount' => $amount, 'price' => $price));
}

function SellBTC($amount,$price)
{
   return mtgox_query('0/sellBTC.php', array('amount' => $amount, 'price' => $price));
}

function CancelOrder($oid,$type)
{
   return mtgox_query('0/cancelOrder.php', array('oid' => $oid, 'type' => $type));
}

function GetDepth()
{
   return  mtgox_query('0/data/getDepth.php');
}

function GetTrades($since)
{
   return  mtgox_query('0/data/getTrades.php?since='.$since);
}

function GetOrders()
{
   return mtgox_query('0/getOrders.php');
}

  function GetMtGoxData()
  {
    $mtgox_data = CurlGetHttps('https://mtgox.com/api/0/data/ticker.php');
    return $mtgox_data;
  }  

 

?>
