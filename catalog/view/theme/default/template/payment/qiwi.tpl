<div class="content">
<p><?php echo $sub_text_info; ?></p>
<form action="<?php echo $action; ?>" method="get" id="payments" >
	<input type="hidden" name="from" value="<?php echo $from; ?>" />
	<input type="hidden" name="summ" value="<?php echo $summ; ?>" />
	<input type="hidden" name="com" value="<?php echo $com; ?>" />
	<input type="hidden" name="txn_id" value="<?php echo $txn_id; ?>" />
	<input type="hidden" name="lifetime" value="<?php echo $lifetime; ?>" />


	<div style="text-align: right;"><?php echo $sub_text_info_phone; ?> +7 <input type="text" name="to" value="<?php echo $phone; ?>" size="10" maxlength="10"></div>
</form>
</div>
<div class="buttons">
    <div class="right"><a id="payment" class="button"><span><?php echo $button_confirm; ?></span></a> </div>
</div>


<script type="text/javascript">


$(document).ready(function(){
   $("#payment").click(function(event){
$.ajax({
 type: 'GET',
		url: 'index.php?route=payment/qiwi/confirm',
success: function () {
     $('#payments').submit();
},

   });

return false;
});
 });


 </script>

