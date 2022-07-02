<?php

	// refererece  class jokul config
	require_once('jokul_config.php');

	class Class_Jokul_Functions
	{

		// ================== JOKUL Functions
		public function jokul_create_url()
		{
			$JOKUL_URL_API = JOKUL_URL_API;
			if (!JOKUL_TESTING)
			    $JOKUL_URL_API = JOKUL_URL_API_PRODUCTION ;

			return $JOKUL_URL_API; 
		}

		public function jokul_create_request_id()
		{
			$requestid = $this->gen_uuid();
			return $requestid;
		}

		public function jokul_create_request_timestamp()
		{
			$dt = new DateTime();
			$dt->setTimezone(new DateTimeZone('UTC'));
			$request_timestamp = $dt->format('Y-m-d\TH:i:s\Z');
			return $request_timestamp;
		} 

		public function jokul_header_create($request_id, $request_timestamp, $signature)
		{ 
			$header = array(
			    'Accept: application/json', 
			    'Content-Type: application/json',
			    'Client-Id: '.JOKUL_CLIENT_ID, 
			    'Request-Id: '.$request_id, 
			    'Request-Timestamp: '.$request_timestamp, 
			    'Signature: '.$signature

			);  
			return $header;
		}


		public function jokul_signature_create($request_id, $request_timestamp, $target_path, $requestBody)
		{

			$clientId = JOKUL_CLIENT_ID;
			$requestId = $request_id;
			$requestDate = $request_timestamp;
			$targetPath = $target_path; 
			$secretKey = JOKUL_CLIENT_SECRET;
			

			// Generate Digest
			$digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));
			// echo "Digest: " . $digestValue;
			// echo "<br><br>";

			// Prepare Signature Component
			$componentSignature = "Client-Id:" . $clientId . "\n" . 
			                      "Request-Id:" . $requestId . "\n" .
			                      "Request-Timestamp:" . $requestDate . "\n" . 
			                      "Request-Target:" . $targetPath . "\n" .
			                      "Digest:" . $digestValue;
			// echo "Component Signature: \n" . $componentSignature;
			// echo "<br><br>";
			 
			// Calculate HMAC-SHA256 base64 from all the components above
			$signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));
			// echo "Signature: " . $signature;
			// echo "<br><br>";

			// Sample of Usage
			$headerSignature =  "Client-Id:" . $clientId ."\n". 
			                    "Request-Id:" . $requestId . "\n".
			                    "Request-Timestamp:" . $requestDate ."\n".
			                    // Prepend encoded result with algorithm info HMACSHA256=
			                    "Signature:" . "HMACSHA256=" . $signature;
			// echo "your header request look like: \n".$headerSignature;
			// echo "<br><br>";

			$SignatureOnly = "HMACSHA256=" . $signature;   

			return $SignatureOnly;
		}
		// ================== End  of JOKUL Functions


		// ================== Other functions

		public function gen_uuid() {
		    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		        // 32 bits for "time_low"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

		        // 16 bits for "time_mid"
		        mt_rand( 0, 0xffff ),

		        // 16 bits for "time_hi_and_version",
		        // four most significant bits holds version number 4
		        mt_rand( 0, 0x0fff ) | 0x4000,

		        // 16 bits, 8 bits for "clk_seq_hi_res",
		        // 8 bits for "clk_seq_low",
		        // two most significant bits holds zero and one for variant DCE1.1
		        mt_rand( 0, 0x3fff ) | 0x8000,

		        // 48 bits for "node"
		        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		    );
		}

		// ================== End of Other functions

	}

?>