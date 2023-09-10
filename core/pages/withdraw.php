<?php 
	$Config = new Config();       
	$captcha = $Config->api("recaptcha")["key"];

	$Settings = $Config->settings();
	$MainCurrency = $Settings["currency"];
	
	if(isset($_POST["step"]) && $_POST["step"]==2 && isset($_POST["gateway"]) && $_POST["gateway"] == "crypto")
	{
?>
<div class="deposit">
  <div class="btns">
    <button class="back" onclick="window.location='/';">
      <i class="fa fa-arrow-left"></i>
      <span>Back</span>
    </button>
  </div>

  <div class="c">
    <h3>
      Metamask withdraw
    </h3>

    <div class="input">
        <form action="" method="POST">
        	<input type="text" placeholder="Enter address" id="currency_coin_from"/>
            <br>
            <br>
			<select style="width: 100%;" name="vault" id="vault">
        			<option value="select">Select vault</option>
					<?php foreach($metamask as $key => $token){ ?>
            			<option value="<?php echo $token["short"]; ?>"><?php echo $token["name"]; ?></option>
        			<?php } ?>
    		</select>
			<br>
			<br>
			<div style="display: flex;justify-content: center;align-items: center;" class="g-recaptcha" id="gcaptcha" data-theme="dark"  data-sitekey="<?php echo $captcha; ?>"></div>
			<br>
            <input name="step" value="2" type="number" style="display:none;" id="depositAmount" step="any">
            <button onclick="withdraw()" id="depositButton">Withdraw</button>
        </form>
    </div>
  </div>
</div>
<?php } else if(isset($_POST["step"]) && $_POST["step"]==2 && isset($_POST["gateway"]) && $_POST["gateway"] == "metamask")  { ?>
<div class="deposit">
  <div class="btns">
    <button class="back" onclick="window.location='/';">
      <i class="fa fa-arrow-left"></i>
      <span>Back</span>
    </button>
  </div>

  <div class="c">
    <h3>
      Metamask withdraw
    </h3>

    <div class="input">
        <form action="" method="POST">
        	<input type="text" placeholder="Enter address" id="currency_coin_from"/>
            <br>
            <br>
			<select style="width: 100%;" name="vault" id="vault">
        			<option value="select">Select vault</option>
					<?php foreach($metamask as $key => $token){ ?>
            			<option value="<?php echo $token["short"]; ?>"><?php echo $token["name"]; ?></option>
        			<?php } ?>
    		</select>
			<br>
			<br>
			<div style="display: flex;justify-content: center;align-items: center;" class="g-recaptcha" id="gcaptcha" data-theme="dark"  data-sitekey="<?php echo $captcha; ?>"></div>
			<br>
            <input name="step" value="2" type="number" style="display:none;" id="depositAmount" step="any">
            <button onclick="withdraw()" id="depositButton">Withdraw</button>
        </form>
    </div>
  </div>
</div>
<?php } else if(isset($_POST["step"]) && $_POST["step"]==2 && isset($_POST["gateway"]) && $_POST["gateway"] == "creditcard")  { ?>	
<div class="deposit">
  <div class="btns">
    <button class="back" onclick="window.location='/';">
      <i class="fa fa-arrow-left"></i>
      <span>Back</span>
    </button>
  </div>

  <div class="c">
    <h3>
      Credit Card withdraw
    </h3>

    <div class="input">
        <form action="" method="POST">
			<input type="text" maxlength="16" pattern="[0-9]{16}" title="Please enter a 16-digit number" required/>
		    <br>
            <br>
        	<input type="number" id="ccmonth" name="expiration-month" min="1" max="12" required>
		    <br>
            <br>
        	<input type="number" id="ccyear" name="expiration-year" min="2023" required>
			<br>
			<br>
			<div style="display: flex;justify-content: center;align-items: center;" class="g-recaptcha" id="gcaptcha" data-theme="dark"  data-sitekey="<?php echo $captcha; ?>"></div>
			<br>
            <input name="step" value="2" type="number" style="display:none;" id="depositAmount" step="any">
            <button onclick="withdraw()" id="depositButton">Withdraw</button>
        </form>
    </div>
  </div>
</div>
<?php } else if(isset($_POST["step"]) && $_POST["step"]==2 && isset($_POST["gateway"]) && $_POST["gateway"] == "pix") { ?>	
<div class="deposit">
  <div class="btns">
    <button class="back" onclick="window.location='/';">
      <i class="fa fa-arrow-left"></i>
      <span>Back</span>
    </button>
  </div>

  <div class="c">
    <h3>
      Credit Card withdraw
    </h3>

    <div class="input">
        <form action="" method="POST">
			<input type="text" placeholder="Enter address" id="currency_coin_from"/>
			<br>
			<br>
			<div style="display: flex;justify-content: center;align-items: center;" class="g-recaptcha" id="gcaptcha" data-theme="dark"  data-sitekey="<?php echo $captcha; ?>"></div>
			<br>
            <input name="step" value="2" type="number" style="display:none;" id="depositAmount" step="any">
            <button onclick="withdraw()" id="depositButton">Withdraw</button>
        </form>
    </div>
</div>
<?php } else { ?>
<div class="deposit">
  <div class="btns">
    <button class="back" onclick="window.location='/';">
      <i class="fa fa-arrow-left"></i>
      <span>Back</span>
    </button>
  </div>

  <div class="c">
    <h3>
      Withdraw
    </h3>

    <div class="input">
        <form action="" method="POST">
            <input name="amount" min="1" max="<?php echo $user["balance"]; ?>" placeholder="Enter in <?php echo $MainCurrency; ?> amount" type="number" id="depositAmount" step="any">
            <br>
            <br>
			<select style="width: 100%;" name="gateway" id="gateway">
        			<option value="select">Select gateway</option>
					<option value="crypto">Crypto</option>
					<option value="metamask">Metamask</option>
					<option value="creditcard">Credit Card</option>
					<option value="pix">PIX</option>
    		</select>
			<br>
			<br>
            <input name="step" value="2" type="number" style="display:none;" id="depositAmount" step="any">
            <button id="depositButton">Next</button>
        </form>
    </div>
  </div>
</div>
<?php } ?>


<script>
	function withdraw() {
		event.preventDefault();
    	var formData = new FormData();
    	var xhr = new XMLHttpRequest();
   		xhr.open('POST', '/api/withdraw', true);
    		xhr.onload = function() {
        		if (xhr.status >= 200 && xhr.status < 400) {
            		var response = JSON.parse(xhr.responseText);
					if(response.status == "ok") {
						toastr['success'](response.messages, '', {
							timeOut: 3000,
							extendedTimeOut: 0
						});
            		} else {
						toastr['warning'](response.messages, '', {
							timeOut: 3000,
							extendedTimeOut: 0
						});
					}
        		} else {
					toastr['warning']("Something went wrong!", '', {
							timeOut: 3000,
							extendedTimeOut: 0
					});
        		}
    	};
    	xhr.onerror = function() {
			toastr['warning']("Something went wrong!", '', {
							timeOut: 3000,
							extendedTimeOut: 0
			});
    	};
   		xhr.send(formData);
	}
</script>