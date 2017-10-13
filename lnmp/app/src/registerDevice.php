<?php

// Helper method to get a string description for an HTTP status code
// From http://www.gen-x-design.com/archives/create-a-rest-api-with-php/
function getStatusCodeMessage($status)
{
	// these could be stored in a .ini file and loaded
	// via parse_ini_file()... however, this will suffice
	// for an example
	$codes = Array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
					);

	return (isset($codes[$status])) ? $codes[$status] : '';
}

// Helper method to send a HTTP response code/message
function sendResponse($status = 200, $body = '', $content_type = 'text/html')
{
	$status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
	header($status_header);
	header('Content-type: ' . $content_type);
	
	$arr = array(
			'stats' => $status,
			'body' => $body
			);
	
	$json_string = json_encode($arr);
			
	echo $json_string;
}
 
class RegisterDeviceAPI {
	private $db;

	// Constructor - open DB connection
	function __construct() {
		$this->db = new mysqli('localhost', 'daoting', 'qwert1', 'daoting');
		$this->db->autocommit(FALSE);
	}

	// Destructor - close DB connection
	function __destruct() {
		$this->db->close();
	}

	function Register() {
    // Check for required parameters	
	
    	if (isset($_POST["open_id"]))
    	{
        	// Put parameters into local variables
        	$open_id = $_POST["open_id"];
        
        	$result_start_time = null;
        	$result_open_id = null;
        
        	// Look up open_id in database
        	$stmt = $this->db->prepare('SELECT open_id FROM tb_user WHERE open_id = ?');
		
        	$stmt->bind_param("s", $open_id);
        	$stmt->execute();
        	$stmt->bind_result($result_open_id);
        	while ($stmt->fetch()) {
            	break;
        	}
        	$stmt->close();  
        
        	$current_date = date("Y-m-d");
        	
			if ($result_open_id == $open_id) {
        		sendResponse(200, "there is open_id in the database");
        	}
        	else
      		{
        		$stmt = $this->db->prepare("INSERT INTO tb_user (open_id, registDate) VALUES (?, ?)");
        		$stmt->bind_param("ss", $open_id, $current_date);
        	
        		$stmt->execute();
        		$stmt->close();
        	
        		$this->db->commit();
        		
        		sendResponse(200, "Insert device into tb_user");
      		}
    	}
    	else 
    	{
    		sendResponse(400, 'parameter is not set');
    	}
	}
}

$api = new RegisterDeviceAPI;
$api->Register();
 
?>