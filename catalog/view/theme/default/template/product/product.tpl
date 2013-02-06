<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<div id="thisIsOriginal" style="visibility: hidden; height:0px;"><?php echo $price; ?></div>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="row-fluid">
            <div class="span9 description-product product-info">
                <div class="row-fluid">
                    <!-- Картинки -->
                    <div class="span5">
                        <table class="additional-foto">
                            <?php foreach ($images as $image) { ?>
                            <tr>
                                <td>
                                    <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                                </td>
                            </tr>
                            <?php } ?>
<!--                            <tr>
                                <td><a href="#"><img src="/catalog/view/theme/default/image/1.jpg" alt="#" /></a></td>
                            </tr>
                            <tr>
                                <td><a href="#"><img src="/catalog/view/theme/default/image/2.jpg" alt="#" /></a></td>
                            </tr>
                            <tr>
                                <td><a href="#"><img src="/catalog/view/theme/default/image/3.jpg" alt="#" /></a></td>
                            </tr>-->
                        </table>
                        <div class="main-foto">
                            <?php if ($thumb) { ?>
                            <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox"><img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" /></a>
                            <?php } ?>
                            <!--<a href="#"><img src="/catalog/view/theme/default/image/apple.jpg" alt="" /></a>-->
                        </div>
                    </div>
                    <!-- Основное описание товара -->
                    <div class="span6">
                                <span class="span12 row product-card"><span class="span12"><h3 class="product-headers"><?php echo $heading_title; ?> </h3> </span>
                                    <?php if ($options) {
                                    $i=0;
                                    ?>
                                    <?php foreach ($options as $option) { ?>
                                        <? if($option['type'] == 'radio') { ?>
                                        <span class="span3"><?php echo $option['name']; ?>: </span>
                                        <span class="span7 change-weight product-info">
                                            <?php foreach ($option['option_value'] as $option_value) {
                                            if($i!=0) {
                                            ?>
                                            <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                                            <?} else { ?>
                                            <input type="radio" checked="checked" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>" id="option-value-<?php echo $option_value['product_option_value_id']; ?>" />
                                            <? }?>
                                            <label for="option-value-<?php echo $option_value['product_option_value_id']; ?>"><?php echo $option_value['name']; ?>
                                                <?php if ($option_value['price']) { ?>
                                                (<?php echo $option_value['price']; ?>)
                                                <?php } ?>
                                            </label><br>
<!--                                            <label>100 г </label><input type="radio" name="1" value="100" /><br>
                                            <label>200 г </label><input id="l1_200" type="radio" name="1" value="200" /><br>
                                            <label>300 г </label><input id="l1_300" type="radio" name="1" value="300" /><br>-->
                                            <?
                                            $i++;
                                            }?>
                                        </span>
                                        <?}?>
                                    <?}?>
                                    <?php foreach ($options as $option) { ?>
                                        <? if($option['type'] == 'select') { ?>
                                        <span class="span3 flavor-product"><?php echo $option['name']; ?>: </span>
                                        <span class="span6">
                                            <select name="option[<?php echo $option['product_option_id']; ?>]">
.                                                <?php foreach ($option['option_value'] as $option_value) { ?>
                                                <option value="<?php echo $option_value['product_option_value_id']; ?>">
                                                    <?php echo $option_value['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </span>
                                        <?}?>
                                    <?}?>
                                    <?}?>
                                    <span class="span3">Цена: </span><span class="span6 price-product"><h5 style="float: left"><span id="priceUpdate"><?php echo $price; ?></span></h5></span>

                                    <span class="span3">Рейтинг: </span>
                                    <span class="span6">
                                        <? $i=1;
                                        for($j=1;$j<=5;$j++) {
                                        ?>
                                        <? if($j==$rating) { ?>
                                        <input name="star1" type="radio" class="star" checked="checked" disabled="disabled"/>
                                        <? } else { ?>
                                        <input name="star1" type="radio" class="star" disabled="disabled"/>
                                        <? } ?>
                                        <? }?>
                                    </span>
                                    <span class="span2 number-product">Количество: </span>
                                    <span class="span8">
                                        <span class="fuelux"><div class="spinner">
                                                <input type="text" name="quantity" class="spinner-input" maxlength="3" value="1" />
                                                <div class="spinner-buttons  btn-group btn-group-vertical">
                                                    <button class="btn spinner-up">
                                                        <i class="icon-chevron-up"></i>
                                                    </button>
                                                    <button class="btn spinner-down">
                                                        <i class="icon-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <table>
                                                <input type="hidden" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                                                <tr class="cart-button"  id="button-cart" >
                                                    <td class="cart-button-image"></td>
                                                    <td class="cart-button-text">Добавить в корзину</td>
                                                </tr>
                                            </table>
                                        </span>

                                    </span>
                                </span>
                    </div>
                </div>
                <!-- Словесное описание товара -->
                <div class="row-fluid">
                    <span class="span12 product-description">
                        <?php echo $description; ?>
                    </span>
                </div>
            </div>
            <!-- Рекомендуемые товары -->
            <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
            <div class="category-product-card span3 row-fluid ">
                <div class="minicard-header"><?=$product['name'];?></div>
                <div class="minicard-content">
                    <table style="width: 100%">
                        <tbody><tr>
                                <td style="width: 40%"><img class="product-img" src="<?=$product['thumb'];?>" alt="<?=$product['name'];?>"></td>
                                <td style="width: 60%">
                                    <span class="span12 muted" style="margin-left: 5px;">Протеин</span>
                                    <span class="span12 price-product"><h5><?=$product['price'];?></h5></span>
                                    <span class="span12">от 950 грамм</span>
                                    <span class="span12" >
                                        <? $i=1;
                                        for($j=1;$j<=5;$j++) {
                                        ?>
                                        <? if($j==$rating) { ?>
                                        <input name="star<?=$product['name'].$j;?>" type="radio" class="star" checked="checked" disabled="disabled"/>
                                        <? } else { ?>
                                        <input name="star<?=$product['name'].$j;?>" type="radio" class="star" disabled="disabled"/>
                                        <? } ?>
                                        <? }?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div class="span6">
                                        <table>
                                            <tbody><tr class="cart-button">
                                                    <td class="cart-button-image"></td>
                                                    <td class="cart-button-text">В корзину</td>
                                                </tr>
                                            </tbody></table>
                                    </div>
                                    <div class="span4">
                                        <a href="<?=$product['href'];?>">Подробнее...</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody></table>
                </div>
            </div>
            <?}?>
            <? }?>
        </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	overlayClose: true,
	opacity: 0.5
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').bind('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
		dataType: 'json',
		success: function(json) {
			$('.success, .warning, .attention, information, .error').remove();

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						$('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
					}
				}
			}

			if (json['success']) {
				$('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');

				$('.success').fadeIn('slow');

                                $("#cart-total").html('<a href=""><i class="icon-download-alt"></i> <span id="quantityProduct">'+json['text_count_product']
                                    + '</span> <i class="icon-shopping-cart"></i><span id="totalProduct">'+json['text_price']+'</span></a>');

//                                $("#quantityProduct").html(json['text_count_product']);
//                                $("#totalProduct").html(json['text_price']);

//				$('#cart-total').html(json['total']);

				$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		}
	});
});
//--></script>
<?php if ($options) { ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
<?php foreach ($options as $option) { ?>
<?php if ($option['type'] == 'file') { ?>
<script type="text/javascript"><!--
new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	action: 'index.php?route=product/product/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);

		$('.error').remove();

		if (json['success']) {
			alert(json['success']);

			$('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
		}

		if (json['error']) {
			$('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
		}

		$('.loading').remove();
	}
});
//--></script>
<?php } ?>
<?php } ?>
<?php } ?>
<script type="text/javascript"><!--
$('#review .pagination a').live('click', function() {
	$('#review').fadeOut('slow');

	$('#review').load(this.href);

	$('#review').fadeIn('slow');

	return false;
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').bind('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']:checked').val() ? $('input[name=\'rating\']:checked').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-review').attr('disabled', true);
			$('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-review').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#review-title').after('<div class="warning">' + data['error'] + '</div>');
			}

			if (data['success']) {
				$('#review-title').after('<div class="success">' + data['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').attr('checked', '');
				$('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript"><!--
if ($.browser.msie && $.browser.version == 6) {
	$('.date, .datetime, .time').bgIframe();
}

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script>
<?php echo $footer; ?>