<?php

class Response {
	private $headers = array();
	private $level = 0;
	private $output;

	public function addHeader($header) {
		$this->headers[] = $header;
	}

	public function redirect($url, $status = 302) {
		header('Location: ' . str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $url), true, $status);
		exit();
	}

	public function setCompression($level) {
		$this->level = $level;
	}

	public function getOutput() {
		return $this->output;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}

	private function compress($data, $level = 0) {
		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false)) {
			$encoding = 'gzip';
		}

		if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false)) {
			$encoding = 'x-gzip';
		}

		if (!isset($encoding) || ($level < -1 || $level > 9)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$this->addHeader('Content-Encoding: ' . $encoding);

		return gzencode($data, (int)$level);
	}

	public function output() {
		if ($this->output) {
			if ($this->level) {
				$output = $this->compress($this->output, $this->level);
			} else {
				$output = $this->output;
			}

			if (!headers_sent()) {
				foreach ($this->headers as $header) {
					header($header, true);
				}
			}

			echo $output;
		}
	
	}

	public function sendResponse()
    {

        $statusMessage = $this->getHttpStatusMessage($this->statusCode);

        //fix missing allowed OPTIONS header
        $this->allowedHeaders[] = "OPTIONS";

        if ($this->statusCode != 200) {
            if (!isset($this->json["error"])) {
                $this->json["error"][] = $statusMessage;
            }

            if ($this->statusCode == 405 && $_SERVER['REQUEST_METHOD'] !== 'OPTIONS') {
                $this->res->addHeader('Allow: ' . implode(",", $this->allowedHeaders));
            }

            $this->json["success"] = 0;

            //enable OPTIONS header
            if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
                $this->statusCode = 200;
                $this->json["success"] = 1;
                $this->json["error"] = array();
            }
        }

        if (isset($this->req->server['HTTP_ORIGIN'])) {
            $this->res->addHeader('Access-Control-Allow-Origin: ' . $this->req->server['HTTP_ORIGIN']);
            $this->res->addHeader('Access-Control-Allow-Methods: '. implode(", ", $this->allowedHeaders));
            $this->res->addHeader('Access-Control-Allow-Headers: '. implode(", ", $this->accessControlAllowHeaders));
            $this->res->addHeader('Access-Control-Allow-Credentials: true');
        }

        $this->res->addHeader($this->httpVersion . " " . $this->statusCode . " " . $statusMessage);
        $this->res->addHeader('Content-Type: application/json; charset=utf-8');

        if (defined('JSON_UNESCAPED_UNICODE')) {
            $this->res->setOutput(json_encode($this->json, JSON_UNESCAPED_UNICODE));
        } else {
            $this->res->setOutput($this->rawJsonEncode($this->json));
        }

        $this->res->output();

        die;
    }

    public function getHttpStatusMessage($statusCode)
    {
        $httpStatus = array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed'
        );

        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    private function rawJsonEncode($input, $flags = 0) {
        $fails = implode('|', array_filter(array(
            '\\\\',
            $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
            $flags & JSON_HEX_AMP ? 'u0026' : '',
            $flags & JSON_HEX_APOS ? 'u0027' : '',
            $flags & JSON_HEX_QUOT ? 'u0022' : '',
        )));
        $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
        $callback = function ($m) {
            return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
        };
        return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
    }

    public function validate($paramentri){
           
        if (empty($paramentri['email'])) {
            $this->error[] = "Email mancante";
        };
        if(empty($paramentri['pwd'])) {
            $this->error[] = "Password mancante";
        };
        
        if (empty($paramentri['nome'])) {
            $this->error[] = "Nome proprietario mancante";
        };
        
        if (empty($paramentri['piano'])) {
            $this->error[] = "Piano mancante";
        };

        if (empty($paramentri['companyName'])) {
            $this->error[] = "Ragione sociale mancante";
        };
       
        return !$this->error;
}

    public function upload($uploadedFile, $subdirectory, $pwd)
    {
        $result = array();

        // Make sure we have the correct directory
        if (isset($subdirectory)) {
            $directory = rtrim('catalog/' . $subdirectory, '/');
            $picturePath = 'catalog/' . $subdirectory;
        } else {
            $directory = 'catalog';
            $picturePath = 'catalog';
        }

        // Check its a directory
        if (!is_dir($directory) || substr(str_replace('\\', '/', realpath($directory)), 0, strlen('catalog')) != str_replace('\\', '/', 'catalog')) {
            $this->rmkdir("catalog/" . $subdirectory);
        }

        $file = $uploadedFile;

        if (is_file($file['tmp_name'])) {
            // Sanitize the filename
            $filename = basename(html_entity_decode($file['name']."_". $pwd, ENT_QUOTES, 'UTF-8'));


            // Allowed file extension types
            $allowed = array(
                'xml'
            );

            if (empty($result)) {
                // Allowed file mime types
                $allowed = array(
                    'application/xml',
                );

                if (!in_array($file['type'], $allowed)) {
                    $result['error'][] = "Errore durante l'upload del file";
                }

                // Return any upload error
                if ($file['error'] != UPLOAD_ERR_OK) {
                    $result['error'][] = "Errore durante l'upload del file";
                }
            }
        } else {
            $result['error'][] = $this->language->get('error_upload');
        }

        if (empty($result)) {
            move_uploaded_file($file['tmp_name'], $directory . '/' . $filename);
            $result['file_path'] = $picturePath. '/' . $filename;
        }

        return $result;
    }

    function rmkdir($path, $mode = 0777)
    {

        if (!file_exists($path)) {
            $path = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $path), "/");
            $e = explode("/", ltrim($path, "/"));
            if (substr($path, 0, 1) == "/") {
                $e[0] = "/" . $e[0];
            }
            $c = count($e);
            $cp = $e[0];
            for ($i = 1; $i < $c; $i++) {
                if (!is_dir($cp) && !@mkdir($cp, $mode)) {
                    return false;
                }
                $cp .= "/" . $e[$i];
            }
            return @mkdir($path, $mode);
        }

        if (is_writable($path)) {
            return true;
        } else {
            return false;
        }
    }

    function stringEncryption($action, $string){
        $output = false;
        
        $encrypt_method = 'AES-256-CBC';                // Default
        $secret_key = 'patty#key!';               // Change the key!
        $secret_iv = '!IV@_$2patty';  // Change the init vector!
        
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        
        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }      
        return $output;
      }
}