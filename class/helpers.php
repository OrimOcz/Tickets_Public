<?php
function getTickets($vs, $id){
	include("./class/mysql.php");
	
	$statement = $conn->prepare("SELECT Ticket_Code FROM Tickets WHERE Ticket_OrderID= :id");
	$statement->bindParam(':id', $id); 
	$statement->execute();
	$rows = $statement->fetchAll();
	
	return $rows;
}
		function getTicketCode($length) 
		{		
			include("./class/mysql.php");
					$loop = true;
			
    				$abc = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
    				$string = "";

					do{
						while (strlen($string) < $length) {
        					$string .= $abc[mt_rand(0, count($abc) - 1)];
    					}
						
						$stmtSELECTCODES = $conn->prepare("SELECT COUNT(*) FROM Tickets WHERE Ticket_Code= :code");
						$stmtSELECTCODES->bindParam(':code', $string); 
						$stmtSELECTCODES->execute();
						$exist = $stmtSELECTCODES->fetch();
						if ($exist[0] >= 1){
							$loop = true;
						} else {
							$loop = false;
						}

					} while($loop);
					return $string;
		};
function get_VS(){
include("./class/mysql.php");
	
	$statement = $conn->prepare("SELECT Order_VS FROM Orders ORDER BY Order_ID DESC LIMIT 1");
	$statement->execute();
	$rows = $statement->fetch();
	
	$newVS;
	if ($rows[0] >= 2000) {
		$new =  $rows[0];
		$newVS = $new+1;
	} else{
		$newVS = 2000;
	}
	return $newVS;
}
function get_info_order($orderVS){
include("./class/mysql.php");
	
	$statement = $conn->prepare("SELECT * FROM Orders WHERE Order_VS=$orderVS LIMIT 1");
	$statement->execute();
	$rows = $statement->fetch();
	
	$orderInfo ;
	if (isset($rows)) {
		$orderInfo = array("ID"=>"$rows[0]", "State"=>"$rows[1]", "Name"=>"$rows[2]", "Email"=>"$rows[3]", "Phone"=>"$rows[4]", "Started"=>"$rows[5]", "Canceled"=>"$rows[12]", "Price"=>"$rows[6]", "TicketC"=>"$rows[7]", "ctickets"=>"$rows[8]", "atickets"=>"$rows[9]", "VS"=>"$rows[12]");
	}
	return $orderInfo;
}	
function getRandString($delka = 10) {
    $abc = str_split("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
    $string = "";

    while (strlen($string) < $delka) {
        $string .= $abc[mt_rand(0, count($abc) - 1)];
    }
    return $string;
}

function checkToken($token) {
    if (!isset($_SESSION["token"])) {
        return false;
    }

    return $token === $_SESSION["token"];
}

function isLogin() {
    return isset($_SESSION["login"]) && $_SESSION["login"] === 'on' && isset($_SESSION["token"]);
}

function setLogin() {
    $_SESSION["login"] = 'on';
    $_SESSION["token"] = getRandString(32);
}

function logout() {
    $_SESSION["login"] = "";
    $_SESSION["token"] = "";
    unset($_SESSION["login"]);
    unset($_SESSION["token"]);
}

function include_page($page, $save=false) {
    $page = preg_replace("[^a-z0-9]", "", $page);

    if ($save){
        $include = "./save/$page.php";
    } else {
        $include = "./pages/$page.php";
    }
    if (file_exists($include)) {
		if($page == "order" && strtotime("now") >= $GLOBALS['LockTime']){
			include("./pages/lock.php");
		} else {
			include($include);
		}
        if (!$save && $page == "confirm2") {
            echo "<br><a href='/?page=buy'>↻ Zpět k prodeji vstupenek</a>";
        }
        if (!$save && $page !== "order") {
            echo "<br><a href='?'>↻ Zpět k nákupu vstupenek</a>";
        }
    } else {
        echo "<h1>Error 404. Stránka neexistuje.</h1>";
    }
}
?>