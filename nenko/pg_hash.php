<?php
function pg_hash($trading_id, $payment_type, $fix_params, $id, $seq_merchant_id, $payment_term_day, $payment_term_min, $payment_class, $use_card_conf_number, $customer_id, $threedsecure_ryaku){
 $hash_key = "sgVPoF7yZjEPWYY";

 // create hash hex string
 $org_str = $trading_id .
           $payment_type .
           $fix_params .
           $id .
           $seq_merchant_id .
           $payment_term_day .
           $payment_term_min .
           $payment_class .
           $use_card_conf_number .
           $customer_id .
           $threedsecure_ryaku .
           $hash_key;
 $hash_str = hash("sha256", $org_str);

 // create random string
 $rand_str = "";
 $rand_char = array('a','b','c','d','e','f','A','B','C','D','E','F','0','1','2','3','4','5','6','7','8','9');
 for($i=0; ($i<20 && rand(1,10) != 10); $i++){
   $rand_str .= $rand_char[rand(0, count($rand_char)-1)];
 }
 
 return $hash_str . $rand_str;
 
}

function pg_hash_maitsuki($seq_merchant_id, $use_card_conf_number, $customer_id){
 $hash_key = "sgVPoF7yZjEPWYY";

 // create hash hex string
 $org_str = $seq_merchant_id .
           $use_card_conf_number .
           $customer_id .
           $hash_key;
 $hash_str = hash("sha256", $org_str);

 // create random string
 $rand_str = "";
 $rand_char = array('a','b','c','d','e','f','A','B','C','D','E','F','0','1','2','3','4','5','6','7','8','9');
 for($i=0; ($i<20 && rand(1,10) != 10); $i++){
   $rand_str .= $rand_char[rand(0, count($rand_char)-1)];
 }
 
 return $hash_str . $rand_str;
 
}

function pg_hash_card($seq_merchant_id, $use_card_conf_number, $customer_id){
 $hash_key = "sgVPoF7yZjEPWYY";

 // create hash hex string
 $org_str = $seq_merchant_id .
           $use_card_conf_number .
           $customer_id .
           $hash_key;
 $hash_str = hash("sha256", $org_str);

 // create random string
 $rand_str = "";
 $rand_char = array('a','b','c','d','e','f','A','B','C','D','E','F','0','1','2','3','4','5','6','7','8','9');
 for($i=0; ($i<20 && rand(1,10) != 10); $i++){
   $rand_str .= $rand_char[rand(0, count($rand_char)-1)];
 }
 
 return $hash_str . $rand_str;
 
}

?>

