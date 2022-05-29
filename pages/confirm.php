<?php
if(isset($_SESSION['vs'])){
	
	$order = get_info_order($_SESSION['vs']);
?>
<h1>Úspěšně přijatá objednávka č.<?= $_SESSION['vs'] ?></h1>
<hr>
<h2>Osobní údaje:</h2>
<p>Jméno a Přijmení: <b><?= $order['Name'] ?></b></p>
<p>Tel.Číslo: <b><?= $order['Phone'] ?></b></p>
<p>Email: <b><?= $order['Email'] ?></b></p>
<hr>
<h2>Informace o objednávce:</h2>
<p><b><?= $order['atickets'] ?>x</b> vstupenka pro Dospělého / <small>Cena: <?= $order['atickets']*200 ?> Kč</small></p>
<p><b><?= $order['ctickets'] ?>x</b> vstupenka pro Dítě do  10 let / <small>Cena: <?= $order['ctickets']*100 ?> Kč</small></p>
<p>Celkem vstupenek: <b><?= $order['TicketC']	?></b></p>
<hr>
<h2>Informace o platbě:</h2>
<p class="info_msg">Úhradu proveďte pokud možno ihned, aby byla nejpozději <?=$GLOBALS['Pay']?> na našem účtu, jinak bude tato objednávka stornována. Vstupenky Vám budou zaslány na tuto emailovou adresu nejpozději <?=$GLOBALS['Send']?>.</p>
<p>Číslo účtu: <b>158606440/0300</b></p>
<p>Variabilní symbol: <b><?= $_SESSION['vs'] ?></b></p>
<p>Celkem k úhradě: <b><?= $order['Price'] ?> Kč</b></p>
<?php
} else {
	
	echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?"> ';
}
		
?>