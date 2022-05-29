<?php
require './vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
	//GENERATOR CODE

function send_tickets($id, $vs, $code) {
		include("./class/mysql.php");
        require_once("./lib/phpqrlib/qrlib.php");
		
		$stmtTickets = $conn->prepare("SELECT Ticket_Code, Ticket_Person, Ticket_Type FROM Tickets WHERE Ticket_OrderID= :id");
		$stmtTickets->bindParam(':id', $id); 
		$stmtTickets->execute();
		$Tickets = $stmtTickets->fetchAll();
		
        $out = [];
        foreach ($Tickets as $ticket) {
            $qr_content = $vs.'-'.$ticket[0];
            $qr_filename = "./data/qr/$qr_content.png";
            QRcode::png($qr_content, $qr_filename, QR_ECLEVEL_H, 3);
            chmod($qr_filename, 0664);
			
			
			
			
            $out[] = "<div style='border: 1px solid black; margin: 20px 20px; width: 600px; height: 194px;'>";

                $out[] = "<div style='position: relative;'>";
                    
					$out[] = "<img src='./data/tickets/listek0$ticket[2]-v02.png' style='width: 100%'>";

                    $out[] = "<div style='position: absolute; top: 40px; right: 5px'>";
                        $out[] = "<img src='$qr_filename' style='width: 100px;'>";
                    $out[] = "</div>";

                    $out[] = "<div style='position: absolute; bottom: 5px; right: 5px;'>";
                        $out[] = "<p style='color: white'>$qr_content</p>";
                    $out[] = "</div>";

                $out[] = "</div>";
            $out[] = "</div>";
        }
		
		
        // echo join("\n", $out);
        //$pdf_filename = $this->get_tickets_path();
		///subdom/vstupenky/data/pdf/
		$pdf_filename = $_SERVER['DOCUMENT_ROOT'].'/subdom/vstupenky/data/pdf/Objednavka-'. $vs .'.pdf';
        generate_pdf(join("\n", $out), $pdf_filename);
        chmod($pdf_filename, 0664);

		if($code == 1){
			send_email($vs, "4");
		} else if ($code == 2){
		} else {
			send_email($vs, "1");
		}
		echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=admin"> ';
    }

function generate_pdf($content, $file) {
    $html2pdf = new Html2Pdf('P', 'A4', 'cs', true, 'UTF-8');
    $html2pdf->setDefaultFont('dejavusans');
    $html2pdf->writeHTML("<page style='font-size: 10px'>" . $content . "</page>");
    $html2pdf->output($file, "F"); 
}