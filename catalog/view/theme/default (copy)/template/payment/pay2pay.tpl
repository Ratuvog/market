<form action="<?php echo $action; ?>" accept-charset="utf-8" method="post" id="payment">
	<input type="hidden" name="xml" value="<?php echo $xml ?>">
	<input type="hidden" name="sign" value="<?php echo $sign ?>">
</form>
<div class="buttons">
	<div class="right"><a onclick="$('#payment').submit();" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>
