<div class="buttons">

     <div class="right"><a href="<?php echo $merchant_url;?>" class="button"><span><?php echo $button_confirm; ?></span></a> </div>

</div>
<script type="text/javascript"><!--
function confirmSubmit() {
	$.ajax({
		type: 'GET',
		url: 'index.php?route=payment/robokassa/confirm',
		success: function() {
			$('#checkout').submit();
		}
	});
}
//--></script>
