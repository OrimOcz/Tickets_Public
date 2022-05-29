<?php

function save_order($fname, $lname, $mail, $p, $atickets, $ctickets, $vs, $type){

try{	
	include("mysql.php");
          // prepare sql and bind parameters
  	$stmt = $conn->prepare("INSERT INTO Orders (Order_State, Order_Name, Order_Email, Order_Phone, Order_Started, Order_Price, Order_TicketsCount, Order_Ctickets, Order_Atickets, Order_VS, Order_IP)
  		VALUES (:state, :name, :email, :phone, :started, :price, :tickets, :ctickets, :atickets, :vs, :ip)");
  	$stmt->bindParam(':state', $state);
	$stmt->bindParam(':name', $name); 
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':phone', $phone);
	$stmt->bindParam(':started', $date);
	$stmt->bindParam(':price', $price);
	$stmt->bindParam(':tickets', $tickets);
	$stmt->bindParam(':ctickets', $ctickets);
	$stmt->bindParam(':atickets', $atickets);
	$stmt->bindParam(':vs', $VS);
	$stmt->bindParam(':ip', $IP);

  // insert a row
		$name = 	$fname . " " . $lname;
		$email = 	$mail;
		$phone = 	$p;
		$state = 	0;
		$date = 	date("Y-m-d H:i:s");
		$price;
		if($type =="buy"){
			$price =	($atickets*250)+($ctickets*100);
		} else{
			$price =	($atickets*200)+($ctickets*100);
		}
		$tickets =	$atickets+$ctickets;
		$VS = 		$vs;
		$IP = 		$_SERVER["REMOTE_ADDR"];
  		$stmt->execute();
	
	/*echo  $name. " ".$email. " ".$phone. " ".$state. " ".$date. " ".$price. " ".$tickets. " ".$VS. " ".$IP;*/

}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
	
}

?>