<form action="<?php echo $action ?>" method="post" id="payment">
  <input type="hidden" name="pay_for" value="<?php echo $pay_for; ?>" />
  <input type="hidden" name="price" value="<?php echo $order_amount; ?>" />
  <input type="hidden" name="currency" value="<?php echo $order_currency; ?>" />
  <input type="hidden" name="pay_mode" value="<?php echo $pay_mode; ?>" />
 </form>
<div class="buttons">
	<div class="right">
      <a onclick="$('#payment').submit();" class="button"><span><?php echo $button_confirm; ?></span></a>
	</div>
</div>
