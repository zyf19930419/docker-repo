<?php

function getStatusCodeMessage($status)
{
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
 
class AddtoSong {
	private $db;

	// Constructor - open DB connection
	function __construct() {
		$this->db = new mysqli('localhost', 'daoting', 'daoting', 'daoting');
		$this->db->autocommit(FALSE);
	}

	// Destructor - close DB connection
	function __destruct() {
		$this->db->close();
	}

	// Main method to redeem a code
	function addSong() {
    // Check for required parameters	
	
    	if (isset($_POST["Title"]) 
			//&& isset($_POST["Price"]) 
    	    //&& isset($_POST["Description"]) 
			//&& isset($_POST["Url"]) 
    	    //&& isset($_POST["Album_id"])
			//&& isset($_POST["Number"])
    	    )
    	{
    	    // Put parameters into local variables
            $Title = $_POST["Title"];
            $Price = $_POST["Price"];
            $Description = $_POST["Description"];
            $Url = $_POST["Url"];
            $Album_id = $_POST["Album_id"];
			$Number = $_POST["Number"];
			
        	$stmt = $this->db->prepare("INSERT INTO tb_song 
        	    (Title, Price, Description, Url, Album_id, Number) VALUES (?, ?, ?, ?, ?, ?)");
        	
       		$stmt->bind_param("ssssss", $Title, $Price, $Description, $Url, $Album_id, $Number);
       		
        	$stmt->execute();
        	$stmt->close();
        	$this->db->commit();

        	sendResponse(200, 'done');
    	}
    	else
    	{
    		sendResponse(400, 'failed');
    	}
	}
}

$api = new AddtoSong;
$api->addSong();
 
?>