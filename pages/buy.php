<?php
if (!isLogin()) {
    echo'<meta http-equiv="refresh" content="0;url='.$_SESSION["url"].'?page=login"> ';
}
?>
<form class="w3-row" action="?save=save" method="post">
	<a id="warning" class="error_msg w3-center" hidden>Je potřeba zakoupit min. 1 lístek</a><br />
	<div class="w3-container w3-card-4 w3-light-grey">	
	  <h3>Nákup lístků:</h3>
		<p class="w3-padding">      
			<label>Email (Pokud chce vstupenky na e-mial)</label>
			<input name="mail" class="w3-input" type="email">
		</p>
		<div class="w3-row-padding w3-padding ">

			<div class="custom-quantity-input w3-half w3-center w3-padding">
				<div class="idk">
					<h4>Dospělí</h4>
					<p>Cena: 250Kč</p>
					<div class="w3-row-padding">
						<a class="w3-third"><br /></a>
						<!--<a href="#" class="quantity-btn quantity-input-down w3-third">-</a>-->
						<input name="aticket" min="0" max="16" onkeyup="if(parseInt(this.value)>16){ this.value =16; return false; }" type="number"class="w3-input w3-third" value="0">
						<a class="w3-third"><br /></a>
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
						<a class="w3-third"><br /></a>
						<!--<a href="#" class="quantity-btn quantity-input-down w3-third">-</a>-->
						<input name="cticket" min="0" max="16" onkeyup="if(parseInt(this.value)>16){ this.value =16; return false; }" type="number" minlength="0" class="w3-input w3-third" value="0">
						<a class="w3-third"><br /></a>
						<!--<a href="#" class="quantity-btn quantity-input-up w3-third">+</a>-->
					</div>
					<br />
				</div>
			</div>

		</div>

	</div>
	<input name="submitBuy" type='submit' class='w3-btn w3-ripple w3-green' value='Odeslat objednávku'>
</form>