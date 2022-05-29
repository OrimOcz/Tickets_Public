<?php

if (!isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=login"> ';
}
	include("./class/mysql.php");
	$useticket;
	$nonuse;
	$statement2 = $conn->prepare("SELECT * FROM Orders ORDER BY Order_State");
	$statement2->execute();
	$orders = $statement2->fetchAll();

	$statement4 = $conn->prepare("SELECT * FROM Tickets");
	$statement4->execute();
	$tickets = $statement4->fetchAll();
	
	foreach ($tickets as $ticket){
		
		if($ticket[1] == NULL ){
			$nonuse = $nonuse + 1;
		}else {
			$useticket = $useticket + 1;
		}
		
	}

	
	$statement3 = $conn->prepare("SELECT * FROM Orders");
	$statement3->execute();
	$orders2 = $statement3->fetchAll();
	$aticketSellOn = 0;
	$cticketSellOn = 0;
	$aticketReservation = 0;
	$cticketReservation = 0;
	$ordersReservationl = 0;
	$inplace = 0;
	$aticketPlace =0;
	$cticketPlace=0;
	$ordersSell =0;
	$ordersSellOn = 0;
	$ordersCancel = 0;
	foreach ($orders2 as $order){
		$ordersGlobal = $ordersGlobal+1;
		if($order[1] == 0){
			$ordersReservation = (int)$ordersReservation+1;
			$aticketReservation = $aticketReservation + $order[9];
			$cticketReservation = $cticketReservation + $order[8]; 
		} else if ($order[1] == 1){
			$ordersSell = (int)$ordersSell+1;
			$ordersSellOn = (int)$ordersSellOn+1;
			$aticketSellOn = $aticketSellOn  + $order[9];
			$cticketSellOn  = $cticketSellOn + $order[8];
		} else if ($order[1] == 2){
			$ordersCancel = (int)$ordersCancel+1;
		} else if ($order[1] == 3){
			$ordersSell = (int)$ordersSell+1;
			$aticketPlace = $aticketPlace  + $order[9];
			$cticketPlace  = $cticketPlace + $order[8];
		}
	}
$inplace = (int)$aticketPlace+(int)$cticketPlace;
$ticketonline=(int)$aticketSellOn+(int)$cticketSellOn;
	$ticketsella =(int)$aticketSellOn+(int)$aticketPlace ;
	$ticketsellc =(int)$cticketSellOn+(int)$cticketPlace ;
$ticketsell = (int)$aticketSellOn+(int)$cticketSellOn+(int)$aticketPlace+(int)$cticketPlace;
$ticketreservated = (int)$aticketReservation+(int)$cticketReservation;
$allorder = (int)$ordersReservation+(int)$ordersSell+(int)$ordersCancel;
echo'<a href="?page=logout">Odhlásit</a> ︳ <a href="?page=cancel">Zrušení lístků</a> ︳ <a href="?page=buy">Prodej vstupenek na místě</a>';
echo "<h1>Výpis objednávek</h1>";
$alltick = $useticket + $nonuse;
echo '<p>Celkem lístků '. $alltick .' lístků (Použito: '. $useticket .'/Nepožito: '. $nonuse .')';

echo "<p>Celkem prodáno $ticketsell lístků (Do: $ticketsella/Dě: $ticketsellc). ︳Prodáno na místě $inplace (Do: $aticketPlace /Dě: $cticketPlace) </p>  ︳Prodáno online $ticketonline (Do: $aticketSellOn /Dě: $cticketSellOn)";

echo "<p>Celkem rezervováno ". $ticketreservated ." lístků (Do: $aticketReservation/Dě: $cticketReservation)</p>";
echo "<p>Zrušených objednávek: $ordersCancel/Zaplacených objednávek: $ordersSell/Rezervovaných objednávek: $ordersReservation/Celkem objednávek: $allorder </p>";
?>

<table class='w3-table w3-bordered w3-border'>
	<tr class='w3-dark-gray'>
		<td>Stav</td>
		<td>VS</td>
		<td>Jméno</td>
		<td>Email</td>
		<td>Telefon</td>
		<td>Cena</td>
		<td>Počet lístků (Dospělí, dítě)</td>
		<td>Datum objednávky</td>
		<td>Datum zaplacení</td>
		<td>Datum zrušení</td>
		<td>Akce</td>
	</tr>
<?php 
	foreach ($orders as $order){ 
		$state = $order["Order_State"];
		$val = str_replace([0, 1, 2, 3], ["Rezervováno", "Zaplaceno", "Zrušeno", "Zakoupeno na místě"], $state);
		if ($state == 1 || $state == 3) {
        	echo "<tr class='w3-pale-green'>";
				
		} else if ($state == 2) {
        	echo "<tr class='w3-gray'>";
    	} else if ($state == 0){
			echo "<tr>";
		}
		if($order['Order_Paied'] == '0000-00-00 00:00:00'){
			$order['Order_Paied'] = '';
		}
		if($order['Order_Canceled'] == '0000-00-00 00:00:00'){
			$order['Order_Canceled'] = '';
		}
		echo '<td>'.$val.'</td>';
		echo '<td>'.$order['Order_VS'].'</td>';
		echo '<td>'.$order['Order_Name'].'</td>';
		echo '<td>'.$order['Order_Email'].'</td>';
		echo '<td>'.$order['Order_Phone'].'</td>';
		echo '<td>'.$order['Order_Price'].'</td>';
		echo '<td>'.$order['Order_TicketsCount'].'('.$order['Order_Atickets'].', '.$order['Order_Ctickets'].')</td>';
		echo '<td>'.$order['Order_Started'].'</td>';
		echo '<td>'.$order['Order_Paied'].'</td>';
		echo '<td>'.$order['Order_Canceled'].'</td>';
		echo '<td>';
          	if ($state == 0) {
                	echo "<a href='?save=tickets&state=1&id=$order[Order_ID]&token=$_SESSION[token]&vs=$order[Order_VS]' onclick='return confirm(\"Opravdu zaplaceno?\\n\\n$order[Order_Name], VS: $order[Order_VS], Cena: $order[Order_Price] Kč\");'>Zaplaceno</a><br>";
					 echo "<a href='?save=tickets&amp;state=2&id=$order[Order_ID]&token=$_SESSION[token]&vs=$order[Order_VS]' onclick='return prompt(\"Opravdu ZRUŠIT?\\n\\n$order[Order_Name], VS: $order[Order_VS], Cena: $order[Order_Price] Kč\\n\\nTouto akcí zrušíte tuto objednávku\\n\\nPro potvrzení napište slovo ZRUŠIT:\") === \"ZRUŠIT\";'>Zrušit</a>";
            	} else if ($state == 1) {
				    echo "<a href='?save=tickets&amp;state=3&id=$order[Order_ID]&token=$_SESSION[token]&vs=$order[Order_VS]' onclick='return prompt(\"Opravdu ZRUŠIT?\\n\\n$order[Order_Name], VS: $order[Order_VS], Cena: $order[Order_Price] Kč\\n\\nTouto akcí zrušíte tuto objednávku\\n\\nPro potvrzení napište slovo ZRUŠIT:\") === \"ZRUŠIT\";'>Zrušit</a>";
            }
            //if ($order["state"] !== "canceled") {
                //$val .= "<a href='?save=change_state&amp;state=not-paid&amp;id=$order[id]&amp;token=$_SESSION[token]' onclick='return prompt(\"Opravdu NEZAPLACENO?\\n\\n$order[name], VS: $order[vs], Cena: $order[price] Kč\\n\\nTouto akcí se zneplatní vstupenky. Rezervace míst zůstane.\\n\\nPro potvrzení napište slovo NEZAPLACENO:\") === \"NEZAPLACENO\";'>Nezaplaceno</a><br>";
            //}
		echo '</td>';
		echo '</tr>';
	}
	echo'</table>';
?>
<!--
echo "<table class='w3-table w3-bordered w3-border'>";
echo "<tr class='w3-dark-gray'>";
foreach ($items as $key => $item) {
    echo "<td>$item</td>";
}
echo "</tr>";
$one_day = 24 * 60 * 60;
foreach ($orders as $order) { 
    if ($order["state"] === 2) {
        echo "<tr class='w3-pale-green'>";
    } else if ($order["state"] === 1) {
        echo "<tr class='w3-gray'>";
    } else if ($order["state"] === 0) {
        $exp_days = get_setting_int("reservation_exp_days");
        $reserved = strtotime($order["reserved"]);
        $expiration = $reserved - $reserved % ($one_day) + $one_day;
        for ($i = 0; $i < $exp_days; $i++) {
            while (date("w", $expiration) === "6" || date("w", $expiration) === "0") {
                $expiration += $one_day;
            }
            while (in_array(date("d.m.", $expiration), $holidays)) {
                $expiration += $one_day;
            }
            $expiration += $one_day;
        }
        $is_expired = time() > $expiration;
        if ($is_expired) {
            echo "<tr class='w3-pale-red'>";
        } else {
            echo "<tr>";
        }
    }
    foreach ($items as $key => $item) {
        $val = null;
        if (isset($order[$key])) {
            $val = $order[$key];
        }
        if ($key === "state") {
            $val = str_replace([0, 1, 2], ["Rezervováno", "Zrušeno", "Zaplaceno"], $val);
        } else if (in_array($key, [0, 1, 2])) {
            if ($val !== null) {
                $val = strtotime($val);
                $val = date("d.m.Y", $val) . "<br>" . date("H:i:s", $val);
            }
        } else if ($key === "action") {
            $val = "";
            if ($order["state"] === "reserved") {
                $val .= "<a href='?save=change_state&amp;state=paid&amp;id=$order[Order_ID]&amp;token=$_SESSION[token]' onclick='return confirm(\"Opravdu zaplaceno?\\n\\n$order[name], VS: $order[vs], Cena: $order[price] Kč\");'>Zaplaceno</a><br>";
            } else if ($order["state"] === "paid") {
                //$val .= "<a href='?save=change_state&amp;state=not-paid&amp;id=$order[id]&amp;token=$_SESSION[token]' onclick='return prompt(\"Opravdu NEZAPLACENO?\\n\\n$order[name], VS: $order[vs], Cena: $order[price] Kč\\n\\nTouto akcí se zneplatní vstupenky. Rezervace míst zůstane.\\n\\nPro potvrzení napište slovo NEZAPLACENO:\") === \"NEZAPLACENO\";'>Nezaplaceno</a><br>";
            }
            if ($order["state"] !== "canceled") {
                $val .= "<a href='?save=change_state&amp;state=canceled&amp;id=$order[id]&amp;token=$_SESSION[token]' onclick='return prompt(\"Opravdu ZRUŠIT?\\n\\n$order[name], VS: $order[vs], Cena: $order[price] Kč\\n\\nTouto akcí se zneplatní vstupenky a zruší rezervace míst.\\n\\nPro potvrzení napište slovo ZRUŠIT:\") === \"ZRUŠIT\";'>Zrušit</a>";
            }
        }
        echo "<td>$val</td>";
    }
    echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<a href='?page=logout'>Odhlásit</a><br>";
-->
