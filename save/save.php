<?php

if(isset($_POST["submit"])){
	include("./class/mysql.php");
	
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$phone = $_POST['phone'];
	$mail = $_POST['mail'];
	$atickets = $_POST['aticket'];
	$ctickets = $_POST['cticket'];
	$type = "online";
	$vs = get_VS();
	
	save_order($fname, $lname, $mail, $phone, $atickets, $ctickets, $vs, $type);
	$_SESSION['vs'] = $vs;
	send_email($vs, 0);
	send_email(0, 3);
	echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=confirm"> ';
}
if(isset($_POST["submitBuy"])){
	include("./class/mysql.php");
	
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$phone = '';
	$mail = $_POST['mail'];
	$atickets = $_POST['aticket'];
	$ctickets = $_POST['cticket'];
	$type = "buy";
	$vs = get_VS();
	
	save_order($fname, $lname, $mail, $phone, $atickets, $ctickets, $vs, $type);
	$_SESSION['vs'] = $vs;
	
		$info = get_info_order($vs);
		$id = $info[ID];
	
		$state = 3;
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
		$OrderName =  "Místo";
		$x  = 0;
		$y  = 0;
		
		$stmtINSERT = $conn->prepare("INSERT INTO Tickets (Ticket_Type, Ticket_OrderID, Ticket_Code, Ticket_Person) VALUES (:type, :orderid, :code, :person)");
			$stmtINSERT->bindParam(':type', $type);
			$stmtINSERT->bindParam(':orderid', $id);
			$stmtINSERT->bindParam(':code', $code);
			$stmtINSERT->bindParam(':person', $OrderName);
		//CHILDREN TICKETS
		while($x < $ChildernTickets){
			$type=3;
			$id = $id;
			$code = getTicketCode(12);
			$stmtINSERT->execute();
			$x++;
		}
		//ADULT TICKETS
		while($y < $AdultTickets){
			$type=4;
			$id = $id;
			$code = getTicketCode(12);
			$stmtINSERT->execute();
			$y++;
		}
		if(isset($mail)){
			send_tickets($id, $vs, 1);
		}
	echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=confirm2"> ';
}
?>
