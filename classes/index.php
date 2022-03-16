<?php
  define("encryption_method", "AES-128-CBC");
define("key_s", "drsathi123");
define("initialization_vector","9860sangam865421");
define("ciphering","AES-128-CTR");
define("options", 0);
$ar1=["name"=>"sangam","age"=>"22"];

function encrypt1($array1){
$array2=array();
	foreach($array1 as $data){    
        $encryption = openssl_encrypt($data, ciphering,
            key_s, options, initialization_vector);
 		array_push($array2,$encryption);
    }
    return $array2;
}
function decrypt1($array1){
    $array2=array();
        foreach($array1 as $data){
            $encryption = openssl_decrypt($data, ciphering,
                key_s, options, initialization_vector);
             array_push($array2,$encryption);
        }
        return $array2;
    }
    function decrypt2($str){
                $encryption = openssl_decrypt(trim($str), ciphering,
                    key_s, options, initialization_vector);
            return $encryption;
        }
        function encrypt2($str){
                $encryption = openssl_encrypt(trim($str), ciphering,
                    key_s, options, initialization_vector);
                return $encryption;
        }

// echo "<pre>";
// print_r(encrypt1(["sangam","thapa"]));
// echo "<br>".decrypt2(" l0497a7R");
// print_r(decrypt1(encrypt1(["sangam","thapa"])));
// Store a string into the variable which
// need to be Encrypted
// $simple_string = "0";
  
// // Display the original string
// echo "Original String: " . $simple_string.strlen($simple_string);
  
// // Store the cipher method
// $
  
// // Use OpenSSl Encryption method

// $options = 0;
  
// // Non-NULL Initialization Vector for encryption
// $encryption_iv = initialization_vector;
  
// // Store the encryption key
// $encryption_key = key_s;
  
// // Use openssl_encrypt() function to encrypt the data
// $encryption = openssl_encrypt($simple_string, $ciphering,
//             $encryption_key, $options, $encryption_iv);
  
// // Display the encrypted string
// echo "Encrypted String: " . $encryption . strlen($encryption)."<bR>";
  
// // Non-NULL Initialization Vector for decryption
// $decryption_iv = initialization_vector;
  
// // Store the decryption key
// $decryption_key = key_s;
  
// // Use openssl_decrypt() function to decrypt the data
// $decryption=openssl_decrypt ($encryption, $ciphering, 
//         $decryption_key, $options, $decryption_iv);
  
// // Display the decrypted string
// echo "Decrypted String: " . $decryption.strlen($decryption);
  
?>