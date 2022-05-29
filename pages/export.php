<?php
require './vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
	//GENERATOR CODE

$pdo = new PDO('mysql:host=md202.wedos.net;dbname=d16610_rnr', 'w16610_rnr', '5SvprEar');

$from='Tickets';
$stmtTickets02 = $pdo->prepare("SELECT Ticket_Code, Ticket_Person, Ticket_Type, Ticket_OrderID FROM Tickets");
		$stmtTickets02->execute();
		$Tickets = $stmtTickets02->fetchAll();

$out[] = '<table style="border:1px solid black;">';
foreach($Tickets as $t){
	$id = $t[3];
	$stmtTickets01 = $pdo->prepare("SELECT Order_VS FROM Orders WHERE Order_ID=:id LIMIT 1;");
	$stmtTickets01->bindParam(':id', $id); 
	$stmtTickets01->execute();
	$row = $stmtTickets01->fetch();
	$type;
	if($t[2] == 1){
		$type = "Dítě";
	} else{
		$type = "Dospělý";
	}
	
	$out[] ='<tr style="border:5px solid black;">';
		$out[] = '<td>'. $type .'</td>';
		$out[] = '<td>'. $t[0] .'</td>';
		$out[] = '<td>'. $row[0] .'</td>';
		$out[] = '<td>'. $t[1] .'</td>';
	$out[] = '</tr>';
	
	
	
}
$out[] = '</table>';

$pdf_filename = $_SERVER['DOCUMENT_ROOT'].'/subdom/vstupenky/data/export.pdf';
        generate_pdf(join("\n", $out), $pdf_filename);
?>