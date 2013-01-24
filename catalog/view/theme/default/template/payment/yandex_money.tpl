<?php if (!$payment_form) { ?>
<div class="content">
 <p><?php echo $text_note; ?></p>
 <p><span class="required">*</span> <?php echo $text_commission; ?> <?php echo $setting['commission']; ?>% <em><?php echo $text_commission_pay; ?></em></p>
 <a class="button" href="<?php echo $action; ?>" target="_blank"><span><?php echo $button_pay; ?></span></a>
</div>
<div class="buttons">
  <div class="right"><a id="button-confirm" class="button"><span><?php echo $button_confirm; ?></span></a></div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({ 
		type: 'GET',
		url: 'index.php?route=payment/yandex_money/confirm',
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
<?php } else { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $heading_title; ?></title>
<style type="text/css">
body {
	margin:0px;
	padding:0px;
}
table#yandex_money {
	width:100%;
	height:100%;
	position:absolute;
	margin:0px;
	font-size:14px;
}
table#yandex_money table {
	margin-bottom:10px;
}
</style>
</head>
<body>
 <table id="yandex_money">
  <tr>
   <td align="center" valign="middle">
    <?php if ($text_shop_name) { ?>
    <h1><?php echo $text_shop_name; ?></h1>
    <?php } ?>
    <table width="450">
     <tr>
      <td align="right"><?php echo $text_amount; ?></td>
      <td align="right"><?php echo $amount; ?> <?php echo $text_currency; ?></td>
     </tr>
     <tr>
      <td align="right"><?php echo $text_commission; ?></td>
      <td align="right"><?php echo $amount_commission; ?> <?php echo $text_currency; ?></td>
     </tr>
     <tr>
      <td align="right"><?php echo $text_total; ?></td>
      <td align="right"><?php echo $amount_total; ?> <?php echo $text_currency; ?></td>
     </tr>
     <tr>
      <td colspan="2">
       <iframe allowtransparency="true" src="https://money.yandex.ru/embed/shop.xml?uid=<?php echo $setting['wallet']; ?>&writer=seller&targets=<?php echo $text_payment; ?><?php echo $order_id; ?>&default-sum=<?php echo $amount_total; ?>&button-text=01&hint=" frameborder="0" width="450" height="163" scrolling="no"></iframe></td>
     </tr>
    </table>
    <?php if ($text_telephone) { ?>
    <p><em><?php echo $text_help; ?> <?php echo $text_telephone; ?></em></p>
    <?php } ?>
   </td>
  </tr>
 </table>
</body>
</html>
<?php } ?>