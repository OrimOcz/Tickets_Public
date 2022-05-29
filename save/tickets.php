<?php

if (!isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=login"> ';
    exit();
}

if (!isset($_GET["id"]) || !isset($_GET["state"]) || !isset($_GET["token"])) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=admin"> ';
    exit();
}

    $id = (int)$_GET["id"];
	$vs = (int)$_GET["vs"];
    $state = $_GET["state"];
	$date = date("Y-m-d H:i:s");
    $success = false;
	
	if($state == 1){
		include("./class/mysql.php");
	
	
		$stmt = $conn->prepare("UPDATE Orders SET Order_State= :state, Order_Paied = :date WHERE Order_ID= :id");
		$stmt->bindParam(':state', $state);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':id', $id); 
		$stmt->execute();
		
		$stmtSELECT = $conn->prepare("SELECT Order_Ctickets, Order_Atickets, Order_Name FROM Orders WHERE Order_ID= :id LIMIT 1");
		$stmtSELECT->bindParam(':id', $id); 
		$stmtSELECT->execute();
		$dataTickets = $stmtSELECT->fetch();
		
		$ChildernTickets = $dataTickets[0];
		$AdultTickets =  $dataTickets[1];
		$OrderName =  $dataTickets[2];
		$x  = 0;
		$y  = 0;
		
		$stmtINSERT = $conn->prepare("INSERT INTO Tickets (Ticket_Type, Ticket_OrderID, Ticket_Code, Ticket_Person) VALUES (:type, :orderid, :code, :person)");
			$stmtINSERT->bindParam(':type', $type);
			$stmtINSERT->bindParam(':orderid', $id);
			$stmtINSERT->bindParam(':code', $code);
			$stmtINSERT->bindParam(':person', $OrderName);
		//CHILDREN TICKETS
		while($x < $ChildernTickets){
			$type=1;
			$id = $id;
			$code = getTicketCode(12);
			$OrderName = $OrderName;
			$stmtINSERT->execute();
			$x++;
		}
		//ADULT TICKETS
		while($y < $AdultTickets){
			$type=2;
			$id = $id;
			$code = getTicketCode(12);
			$OrderName = $OrderName;
			$stmtINSERT->execute();
			$y++;
		}
		
		send_tickets($id, $vs, 20);
		
	} else if ($state == 2){
		
		include("./class/mysql.php");
	
	
		$stmt = $conn->prepare("UPDATE Orders SET Order_State= :state, Order_Canceled = :date WHERE Order_ID= :id");
		$stmt->bindParam(':state', $state);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':id', $id); 
		$stmt->execute();
		
		echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=admin"> ';
		send_email($vs, 2);
	} else if($state == 3){
		include("./class/mysql.php");
		$stmtSELECT02 = $conn->prepare("SELECT Ticket_ID FROM Tickets WHERE Ticket_OrderID= :id");
		$stmtSELECT02->bindParam(':id', $id);
		$stmtSELECT02->execute();
		$TicketsID = $stmtSELECT02->fetchAll();
		$str = 2;
		$ptime = "0000-00-00 00:00:00";
		
		$stmtUpdate = $conn->prepare("UPDATE Orders SET Order_State= :state, Order_Paied = :pdate, Order_Canceled = :cdate WHERE Order_ID= :id");
		$stmtUpdate->bindParam(':state', $str);
		$stmtUpdate->bindParam(':pdate', $ptime);
		$stmtUpdate->bindParam(':cdate', $date);
		$stmtUpdate->bindParam(':id', $id); 
		$stmtUpdate->execute();
		
		$stmt2 = $conn->prepare("UPDATE Tickets SET Ticket_Canceled = :date WHERE Ticket_ID= :id");
		
		if(isset($TicketsID)){
			foreach ($TicketsID as $ticket) {
				$stmt2->bindParam(':date', $date);
				$stmt2->bindParam(':id', $ticket[0]); 
				$stmt2->execute();
			}
		}
		send_email($vs, 2);
		echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=admin"> ';
	}

	


?>