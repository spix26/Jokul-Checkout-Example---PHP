<?php

/*
Developer: Ari Abimanyu
*/

// refererece  class jokul config
require_once('jokul_config.php');

// refererece  class jokul functions
require_once('class_jokul_functions.php'); 


if($_POST)
{
    $c_jokul_functions = new Class_Jokul_Functions();

    $request_id = $c_jokul_functions->jokul_create_request_id();
    $request_timestamp = $c_jokul_functions->jokul_create_request_timestamp();
    $target_path = JOKUL_URL_API_PATH_CHECKOUT;

    // Prepare for Jokul Url
    $url = $c_jokul_functions->jokul_create_url().$target_path;
    if(JOKUL_DEBUG)
    {
        echo "URL:";
        echo "<br>";
        print_r($url);
        echo "<br><br>"; 
    } 


    // Prepare for Jokul requestBody 
    $requestBody =array();
    if(isset($_POST))
        $requestBody = $_POST;


    if(JOKUL_DEBUG)
    {
        echo "requestBody:";
        echo "<br>";
        echo "<pre>";
        print_r($requestBody);
        echo "</pre>";
        echo "<br><br>";
    }


    // Prepare for Signature
    $signature = $c_jokul_functions->jokul_signature_create($request_id, $request_timestamp, $target_path, $requestBody);
    if(JOKUL_DEBUG)
    {
        echo "signature:";
        echo "<br>";
        echo "<pre>";
        print_r($signature);
        echo "</pre>";
        echo "<br><br>";
    }

    // Prepare for Header
    $header = $c_jokul_functions->jokul_header_create($request_id, $request_timestamp, $signature);
    if(JOKUL_DEBUG)
    {
        echo "header:";
        echo "<br>";
        echo "<pre>";
        print_r($header);
        echo "</pre>";
        echo "<br><br>";
    }
     


    // $postdata = $requestBody;
    $postdata = json_encode($requestBody);

    $curl = curl_init();        

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    // curl_setopt($curl, CURLOPT_POST, sizeof($postdata));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata); 
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
       
    $server_output = curl_exec ($curl);
       
    curl_close ($curl);      

     
    echo $server_output;
}
else
{
    echo '{"status": "failed", "error_message": "Please send your data!"}';
}
 


?>