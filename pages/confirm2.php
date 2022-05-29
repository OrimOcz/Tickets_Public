<?php
if (!isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=login"> ';
}
if(isset($_SESSION['vs'])){
	
	$order = get_info_order($_SESSION['vs'])
?>
<h1>Úspěšně vytvořená objednávka č.<?= $_SESSION['vs'] ?></h1>
<hr>
<h2>Osobní údaje:</h2>
<p>Email: <b><?= $order['Email'] ?></b></p>
<hr>
<h2>Informace o objednávce:</h2>
<p><b><?= $order['atickets'] ?>x</b> vstupenka pro Dospělého / <small>Cena: <?= $order['atickets']*250 ?> Kč</small></p>
<p><b><?= $order['ctickets'] ?>x</b> vstupenka pro Dítě do  10 let / <small>Cena: <?= $order['ctickets']*100 ?> Kč</small></p>
<p>Celkem vstupenek: <b><?= $order['TicketC']	?></b></p>
<p>Celková cena: <b><?= $order['Price']	?>Kč</b></p>
<hr>
<h2>Vstupenky:</h2>
<?php
		$return = getTickets($order['VS'],$order['ID']);
		echo '<div style="display: block;" class="w3-content w3-row">';
		foreach($return as $code){
			
		?>
			<div style="float: left;width: 200px; text-align: center; height: 10em;   margin: 5px;" class="w3-container">
					<img style="w3-center" src="/qrcode.php?filename=<?=$order['VS']?>-<?=$code[0]?>&psw=ZHBNLdJ53PLBDsL" alt="QR Code">
					<p><?=$order['VS']?>-<?=$code[0]?></p>
			</div>
			
		<?php
			}
		echo '</div>';
} else {
	
	echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?"> ';
}
		
?>