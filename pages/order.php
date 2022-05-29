<?php 
unset($_SESSION['vs']);
$date = date("Y-m-d H:i:s");
if($date >= $GLOBALS['LockTime']){
	echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=lock"> ';
}
?>
<script>
jQuery(function($) {

  $(".quantity-btn").on("click", function(e) {
    e.preventDefault();	// Don't scroll top.
    var $inp = $(this).closest("div").find("input"),  // Get input
		isUp = $(this).is(".quantity-input-up"),      // Is up clicked? (Boolean)
		currVal = parseInt($inp.val(), 10);    			// Get curr val
	$inp.val(Math.max(0, currVal += isUp ? 1 : -1));
	if(parseInt($inp.value)>16){ $inp.value =15; return false; };
  });

  // Other DOM ready code here
  
});
	
	
$(function() {
    var update = function() {
		var atickets = Number(document.getElementsByName("aticket")[0].value);
		var ctickets = Number(document.getElementsByName("cticket")[0].value);
		var tickets = atickets + ctickets;
		var price = (atickets*200) + (ctickets*100);
		
		document.getElementById("name").innerHTML = document.getElementsByName("fname")[0].value +" "+ document.getElementsByName("lname")[0].value;
		document.getElementById("email").innerHTML = document.getElementsByName("mail")[0].value;
		document.getElementById("phone").innerHTML = document.getElementsByName("phone")[0].value;
		document.getElementById("tickets").innerHTML = tickets;
		document.getElementById("price").innerHTML = price + " Kč";
		
		if(tickets < 1){
			document.getElementById("submit").disabled = true;
			document.getElementById("warning").hidden = false;
			
		} else{
			document.getElementById("submit").disabled = false;
			document.getElementById("warning").hidden = true;
		}
    };
    update();
    $('form').change(update);
})
	
		
		//document.getElementById("name").innerHTML  = document.getElementsByName("fname").value;

</script>
<style>
	.detail-order span{
		font-weight: bold;
	}
	h1, h2{
		margin: 0px;
	}
	.w3-card-4{
		margin-right: 20px
	}
.idk{
  border-radius: 10px;
background: white;
}
	.custom-quantity-input{
		padding-left: 30px;
		padding-right: 30px;
	}
	.quantity-btn{
		font-size: 1em;
	}

</style>
<p class="info_msg">
    <b>Platby</b> za všechny objednávky musí být na našem účtu <b>do <?=$GLOBALS['Pay']?></b>. Nezaplacené objednávky budou stornovány.
</p>

<p class="info_msg">
    U předprodeje je možné platit pouze bank. převodem. <b>Konec předprodeje je <?=$GLOBALS['Pay']?>.</b> V případě, že jste nestihli zakoupit vstupenky, tak budou k dispozici na místě (platba pouze v hotovosti).
</p>

<br>
<form class="w3-row" action="?save=save" method="post">
	<a id="warning" class="error_msg w3-center" hidden>Je potřeba zakoupit min. 1 vstupenku</a><br />
	<div class="w3-container w3-card-4 w3-light-grey w3-twothird">	
	  <h3>Nákup vstupenek</h3>
		<div class="w3-row-padding">
			<p class="w3-half">      
				<label>Jméno</label>
				<input name="fname" class="w3-input" type="text" required>
			</p>
			<p class="w3-half">      
				<label>Přijmení</label>
				<input name="lname" class="w3-input" type="text" required>
			</p>
		</div>
		<p class="w3-padding">      
			<label>Tel. Číslo</label>
			<input name="phone" class="w3-input" type="tel" required>
		</p>
		<p class="w3-padding">      
			<label>Email</label>
			<input name="mail" class="w3-input" type="email" required>
		</p>
		<div class="w3-row-padding w3-padding ">

			<div class="custom-quantity-input w3-half w3-center w3-padding" required>
				<div class="idk">
					<h4>Dospělí</h4>
					<p>Cena: 200Kč</p>
					<div class="w3-row-padding">
						<a class="w3-quarter"><br/></a>
						<!--<a href="#" class="quantity-btn quantity-input-down w3-third">-</a>-->
						<div class="w3-twothird">
							<div class="w3-row w3-section">
							  <div class="w3-col" style="width:65px"><a>Počet kusů:</a></div>
								<div class="w3-rest">
								  <input name="aticket" min="0" max="16" pattern="\d+" onkeyup="if(parseInt(this.value)>16){ this.value =16; return false; }" type="number"class="w3-input w3-third" value="0">
								</div>
							</div>
							
						</div>
						<a class="w3-quarter"><br /></a>
						<!--<a href="#" class="quantity-btn quantity-input-up w3-third">+</a>-->
					</div>
					<br />
				</div>
			</div>
			<div class="custom-quantity-input w3-half w3-center w3-padding">
				<div class="idk">
					<h4>Dítě (do 10 let)</h4>
					<p>Cena: 100Kč</p>
					<div class="w3-row-padding">
						<a class="w3-quarter"><br/></a>
						<!--<a href="#" class="quantity-btn quantity-input-down w3-third">-</a>-->
						<div class="w3-twothird">
							<div class="w3-row w3-section">
							  <div class="w3-col" style="width:65px"><a>Počet kusů:</a></div>
								<div class="w3-rest">
								  <input name="cticket" min="0" max="16" pattern="\d+" onkeyup="if(parseInt(this.value)>16){ this.value =16; return false; }" type="number"class="w3-input w3-third" value="0">
								</div>
							</div>
							
						</div>
						<a class="w3-quarter"><br /></a>
						<!--<a href="#" class="quantity-btn quantity-input-up w3-third">+</a>-->
					</div>
					<br />
				</div>
			</div>

		</div>

	</div>
	<div class="w3-quater detail-order">
		<div>
			<h1>Informace o objednávce:</h1>
			<h3><?=$GLOBALS['NameCom']?></h3>
			<hr>
			<a>Datum konání: <b><?=$GLOBALS['DateCom']?></b></a><br />
			<a>Čas zahájení: <b><?=$GLOBALS['Start']?></b></a><br />
			<a>Vstup do sálu od: <b><?=$GLOBALS['Entry']?></b></a><br />
			<a>Místo konání: <b><?=$GLOBALS['AdressCom']?></b></a><br />
			<hr>
			<a>Jméno a Přijmení: <span id="name"></span></a><br />
			<a>Telefon: <span id="phone"></span></a><br />
			<a>Email: <span id="email"></span></a><br />
			<a>Počet vstupenek: <span id="tickets"></span></a><br />
			<a>Celková cena: <span id="price"></span></a><br />
			<p class='info'>Odesláním objednávky souhlasíte s <a href='data/documents/podminky_nakupu_2022.pdf' target='_blank'>podmínkami nákupu</a> a s <a href='data/documents/osobni_udaje.pdf' target='_blank'>podmínkami zpracování osobních údajů</a>.</p>
			<input id="submit" name="submit" type='submit' class='w3-btn w3-ripple w3-green' value='Odeslat objednávku'>
		</div>
	</div>
</form>