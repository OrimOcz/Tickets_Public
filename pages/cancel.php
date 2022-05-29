<?php
if (!isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=login"> ';
}
if(isset($_POST[submit])){
	include("./class/mysql.php");
		$stmt = $conn->prepare("UPDATE Tickets SET Ticket_Canceled= :date WHERE Ticket_Code= :code");
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':code', $code); 
		$date = date("Y-m-d H:i:s");
		$code = $_POST[code];
		$stmt->execute();
		
		$stmt2 = $conn->prepare("SELECT Ticket_Type FROM Tickets WHERE Ticket_Code= :code");
		$stmt2->bindParam(':code', $code); 
		$code = $_POST[code];
		$stmt2->execute();
		$tickettype = $stmt2->fetch();;	
		
		$price;
		$type;
	
		switch ($tickettype[0]){
				
			case 1:
				$price = (int)100;
				$type = "Dětský lístek do 10 let";
				break;
			case 2:
				$price = (int)200;
				$type = "Dospělí lístek";
				break;
			case 3:
				$price = (int)100;
				$type = "Dětský lístek do 10 let (Koupený na místě)";
				break;
			case 4:
				$price = (int)250;
				$type = "Dospělí lístek (Koupený na místě)";
				break;
				
		}
		$msg = 'Úspěšně deaktivován lístek s kódem "'. $code .'". Cena lístku: '. $price.'Kč/Typ lístku: '. $type;
		$_POST[submit] = "";
}
?>

<form class="w3-container w3-card-4" method="post">
	<?php 
	if(isset($msg)){
		echo '<p class="info_msg">'.$msg.'</p>';
	}
	?>
	<h2 class="w3-text-red">Zrušení vstupenky</h2>
  <p>      
  <label class="w3-text-red"><b>Kód vstupenky:</b></label>
  <input class="w3-input w3-border" name="code" type="text">
	</p>
     
  <p><button name="submit" type="submit" class="w3-btn w3-red">Zrušit lístek</button></p>
</form>
<br />
<a href='?page=admin'>↻Zpět do administrace</a>