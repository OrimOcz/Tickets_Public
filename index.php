<?php
header('Content-Type: text/html; charset=utf-8');
$_SESSION["url"] = "https://rnr.sokoljinonice.cz/";
$GLOBALS['NameCom'] = "Jarní pohár Sokola Jinonice";
$GLOBALS['DateCom'] = "sobota 2.4.2022";
$GLOBALS['Entry'] = "9:00";
$GLOBALS['Start'] = "11:00";
$GLOBALS['LockTime'] = strtotime("01-04-2022 10:00:00");
$GLOBALS['Pay'] = "1.4.2022 v 10:00";
$GLOBALS['Send'] = "1.4.2022 ve 14:00";
$GLOBALS['AdressCom'] = "Sportovní centrum Řepy, Na chobotě 1420/16, Praha 6 - Řepy, 163 00";


require_once("class/init.php");

if (isset($_GET["save"])) {
    require_once("lib/PHPMailer/class.phpmailer.php");
    require_once("lib/PHPMailer/class.smtp.php");
    include_page($_GET["save"], true);
} else {
	require_once("lib/PHPMailer/class.phpmailer.php");
    require_once("lib/PHPMailer/class.smtp.php");
?>
<!doctype html>
<html>
<html lang="cs">
<head>
<link rel="apple-touch-icon" sizes="57x57" href="/data/favicon/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="/data/favicon/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="/data/favicon/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="/data/favicon/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="/data/favicon/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="/data/favicon/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="/data/favicon/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="/data/favicon/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="/data/favicon/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="/data/favicon/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="/data/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="/data/favicon/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="/data/favicon/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/data/favicon/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
	
    <meta charset="utf-8">
	<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>RRC Domino - Prodej lístků</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/main.css?v=<?=$file_version?>">
	<link rel="stylesheet" href="js/form.js?v=<?=$file_version?>">

    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/functions.js?v=<?=$file_version?>"></script>
</head>
<body>
    <div class="header">
        <div class="img">
        </div>
    </div>

    <div class="main_content">
        <?php
        if (isset($_GET["page"])) {
            include_page($_GET["page"]);
        } else {
            include_page("order");
        }
        ?>
    </div>

    <div class="footer">
        <a href="http://rnr.sokoljinonice.cz">Zpět na stránky RRC Domino</a>
    </div>
</body>
</html>
	<?php
}