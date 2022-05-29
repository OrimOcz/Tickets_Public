<?php

# process login form (if sended)
if (isset($_POST)) {
    if (isset($_POST["name"]) && $_POST["name"] === "---" && isset($_POST["passwd"]) && $_POST["passwd"] === "---") {
		echo 'Přihlášen';
        setLogin();
    }
}

# check for login
if (isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=admin"> ';
    exit();
}

?>
<form class="w3-container w3-card-4 w3-light-grey" method="post">
  <h2>Přihlášení do administračního prostředí</h2>
  <p>
  <label>Přihlašovací jméno:</label>
  <input class="w3-input w3-border w3-round-large" name="name" type="text" required></p>
  <p>
  <label>Heslo:</label>
  <input class="w3-input w3-border w3-round-large" name="passwd" type="password" required></p>
  <p>
	
	<input name="submitLogin" type='submit' class='w3-btn w3-ripple w3-green' value='Přihlásit se'>
</form>
