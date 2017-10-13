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

class TransferItem {

    private $db;

    function __construct() {
        $this->db = new mysqli('localhost', 'lu', 'qwert1', 'lu');
        $this->db->autocommit(FALSE);
    }


    function UpdateTransferList()
    {
        if (isset($_POST['productID'])) {

            if ($_POST['productStatus'] == 'ONLINE') {
                
                $productID = $_POST['productID'];
                $interestRateDisplay =  $_POST['interestRateDisplay'];
                $price =  $_POST['price'];
                $reducePrice =  $_POST['reducePrice'];
                $investPeriodDays =  $_POST['investPeriodDays'];
                $originalInterestRate =  $_POST['originalInterestRate'];
                $canRealized =  $_POST['canRealized'];
                $isDanbao =  $_POST['isDanbao'];
                $minHoldingDays =  $_POST['minHoldingDays'];
                $riskLevelDisplay =  $_POST['riskLevelDisplay'];
                $lastUpdateTime =  $_POST['lastUpdateTime'];
                $productStatus = $_POST['productStatus'];
                $publishedAtDateTime = $_POST['publishedAtDateTime'];
          
                $stmt = $this->db->prepare('UPDATE tb_transferinvestment SET
                
                InterestRateDisplay = ?,
                Price = ?, 
                ReducePrice = ?,
                investPeriodDays = ?,
                OriginalInterestRate = ?,
                canRealized = ?,
                IsDanbao = ?,
                minHoldingDays = ?,
                RiskLevelDisplay = ?,
                LastUpdateTime = ?,
                productStatus = ?,
                publishedAtDateTime = ?
                WHERE ProductID = ?');

                $stmt->bind_param("dddsdddssssss",
                    $interestRateDisplay, 
                    $price, 
                    $reducePrice, 
                    $investPeriodDays, 
                    $originalInterestRate, 
                    $isDanbao, 
                    $canRealized, 
                    $minHoldingDays, 
                    $riskLevelDisplay, 
                    $lastUpdateTime,  
                    $productStatus, 
                    $publishedAtDateTime,
                    $productID);
            }

            if ($_POST['productStatus'] == 'CANCELED') {

                $productID = $_POST['productID'];
                $productStatus = $_POST['productStatus'];
          
                $stmt = $this->db->prepare('DELETE FROM tb_transferinvestment WHERE ProductID = ?');

                $stmt->bind_param("s", $productID);
            }

            if ($_POST['productStatus'] == 'DONE') {

                $productID = $_POST['productID'];
                $interestRateDisplay =  $_POST['interestRateDisplay'];
                $price =  $_POST['price'];
                $reducePrice =  $_POST['reducePrice'];
                $investPeriodDays =  $_POST['investPeriodDays'];
                $originalInterestRate =  $_POST['originalInterestRate'];
                $canRealized =  $_POST['canRealized'];
                $isDanbao =  $_POST['isDanbao'];
                $minHoldingDays =  $_POST['minHoldingDays'];
                $riskLevelDisplay =  $_POST['riskLevelDisplay'];
                $lastUpdateTime =  $_POST['lastUpdateTime'];
                $productStatus = $_POST['productStatus'];
                $publishedAtDateTime = $_POST['publishedAtDateTime'];
                $buyerUserName = $_POST['buyerUserName'];
          
                $stmt = $this->db->prepare('INSERT INTO tb_transferinvestment_archive
                (`ProductID`,
                 `InterestRateDisplay`,
                 `Price`, 
                 `ReducePrice`, 
                 `investPeriodDays`, 
                 `OriginalInterestRate`, 
                 `canRealized`, 
                 `IsDanbao`, 
                 `MinHoldingDays`, 
                 `RiskLevelDisplay`, 
                 `LastUpdateTime`, 
                 `productStatus`, 
                 `publishedAtDateTime`, 
                 `buyerUserName`
                    ) VALUES
                (?,?,?,?,?,?,?,?,?,?,?,?,?,?
                    )'
                );

                $stmt->bind_param("dddsdddsssssss", 
                    $productID,
                    $interestRateDisplay, 
                    $price, 
                    $reducePrice, 
                    $investPeriodDays, 
                    $originalInterestRate, 
                    $canRealized, 
                    $isDanbao, 
                    $minHoldingDays, 
                    $riskLevelDisplay, 
                    $lastUpdateTime,  
                    $productStatus, 
                    $publishedAtDateTime,
                    $buyerUserName
                    );

                $stmt->execute();

                $stmt->prepare('DELETE FROM tb_transferinvestment WHERE ProductID = ?');
                $stmt->bind_param("s", $productID);
            }

            $stmt->execute();
            $stmt->close();

            $this->db->commit();

            sendResponse( 200, $productStatus );
        }

    }
}

$api = new TransferItem;
$api->UpdateTransferList();
