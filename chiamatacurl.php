<?php
class Chiamatacurl {
   
	public function call($method, $url, $data=array()) {
        if($method == "GET"){
			// create a new cURL resource
			// $curl is the handle of the resource
			$ch = curl_init();
			// set the URL and other options
			curl_setopt($ch, CURLOPT_URL, $url);
			// We set parameter CURLOPT_RETURNTRANSFER to read output
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// execute and pass the result to browser
			$response = curl_exec($ch);
			// Check HTTP status code
			if (!curl_errno($ch)) {
				switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
					case '200':  # OK
						//$response = '200';
					    break;
					case '409': 
						$response = '409';
						break;
					case '400': 
						$response = '400';					
						break;
					case '403': 
						$response = '403';
						break;
					case '404': 
						$response = '404';
						break;
					default:
						break;
					}
			}
			// Close the connection
			curl_close($ch);
			return $response;
		}  

		if($method == "POST"){
			//se c'è l'ownerid significa che non dobbiamo inviare il template xml perché siamo nell'aggiornamento
			//dell'account
			
			// Create a new cURL resource with URL to POST
			$ch = curl_init($url);	
			$headers = array("Content-Type" => "multipart/form-data");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			if(!isset($data['ownerid'])){
					if (function_exists('curl_file_create')) { // For PHP 5.5+
								$file = curl_file_create("templateEcwid/template.xml", "application/xml","template");
							} else {
								$file = '@' . realpath("templateEcwid/template.xml");
							}
					$data['template'] = $file;
					curl_setopt($ch, CURLOPT_POSTFIELDS, $data);   
			} else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			}
			// We set parameter CURLOPT_RETURNTRANSFER to read output
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// We execute our request, and get output in a $response variable
			$response = curl_exec($ch);
			
			// $info = curl_getinfo($ch);
			// echo curl_errno($ch); die();
			// Check HTTP status code
			if (!curl_errno($ch)) {
				switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
					case '200':  # OK
						break;
					case '409': 
						$response = '409';
						break;
					case '400': 
						$response = '400';					
						break;
					case '403': 
						$response = '403';
						break;
					case '404': 
						$response = '404';
						break;
					default:
						break;
					}
			}
			// Close the connection
			curl_close($ch);
			return $response;
		}
		
		if($method == "PUT"){	
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($data)));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($ch);
			curl_close($ch);
			// Check HTTP status code
			if (!curl_errno($ch)) {
				switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
					case '200':  # OK
						break;
					case '409': 
						$response = '409';
						break;
					case '400': 
						$response = '400';					
						break;
					case '403': 
						$response = '403';
						break;
					case '404': 
						$response = '404';
						break;
					default:
						break;
					}
			}
			// Close the connection
			curl_close($ch);
			//print_r($response); die();
			return $response;
		}
		if($method == "DELETE"){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response  = curl_exec($ch);
			curl_close($ch);
			// Check HTTP status code
			if (!curl_errno($ch)) {
				switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
					case '200':  # OK
						break;
					case '409': 
						$response = '409';
						break;
					case '400': 
						$response = '400';					
						break;
					case '403': 
						$response = '403';
						break;
					case '404': 
						$response = '404';
						break;
					default:
						break;
					}
			}
			// Close the connection
			curl_close($ch);
			return $response;
		}
	}
}
?>
