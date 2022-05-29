<?php

include("../class/mysql.php");
$myObj = new stdClass();
$psw = $_GET['psw'];
$pseudo = $_GET['pseu'];
$code = $_GET['code'];
$update = $_GET['u'] ;

if(isset($psw) && isset($code) && isset($pseudo)){
	
	if ($_GET['psw'] == "8Slw0xi6yxJ"){
		if(strlen($code) == 17){
			$onlycode = substr($code, 5,12 );
			$vs = substr($code, 0,4 );

			$stmtTickets = $conn->prepare("SELECT Ticket_Validate, Ticket_Type, Ticket_OrderID, Ticket_Canceled, Ticket_Person FROM Tickets WHERE Ticket_Code= :code LIMIT 1");
			$stmtTickets->bindParam(':code', $onlycode); 
			$stmtTickets->execute();
			$rows = $stmtTickets->rowCount();
			$Ticket = $stmtTickets->fetch();

			if($rows==1){

				$myObj->status = 202;
				if($Ticket['Ticket_Validate'] != "0000-00-00 00:00:00"){
					$myObj->ticket_validated = $Ticket['Ticket_Validate'];
				} else {
					$myObj->ticket_validated = null;
				}

				if($Ticket['Ticket_Canceled'] != "0000-00-00 00:00:00"){
					$myObj->ticket_canceled = $Ticket['Ticket_Canceled'];
				} else {
					$myObj->ticket_canceled = null;
				}
				if($Ticket['Ticket_Type'] == 1){
					$myObj->ticket_type = 'Dítě do 10 let (předprodej)';
				}else if($Ticket['Ticket_Type'] == 2){
					$myObj->ticket_type = 'Dospělý (předprodej)';
				}else if($Ticket['Ticket_Type'] == 3){
					$myObj->ticket_type = 'Dítě (místo)';
				}else if($Ticket['Ticket_Type'] == 4){
					$myObj->ticket_type = 'Dospělý (místo)';
				} else {
					$myObj->ticket_type = null;
				}
				
				$myObj->ticket_table = '/';
				$myObj->ticket_chair = '/';
				$myObj->ticket_person = $Ticket[4];

				if($update == "updatevalidate"){
					if($myObj->ticket_validated == null){
						$date = date("Y-m-d H:i:s");
					$stmtUpdateTicket = $conn->prepare("UPDATE Tickets SET Ticket_Validate= :validate WHERE Ticket_Code= :code");
					$stmtUpdateTicket->bindParam(':validate', $date); 
					$stmtUpdateTicket->bindParam(':code', $onlycode); 
					$stmtUpdateTicket->execute();
						
					}
				}

			} else{
				$myObj->status = 404;
			}


		} else {
			$myObj->status = 403;	
		}

	} else {
		$myObj->status = 401;
	}
} else {
	$myObj->status = 402;
}
$myJSON = json_encode($myObj);

echo $myJSON;

	



?>