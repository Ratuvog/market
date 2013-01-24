<div class="group" style="display: <?php echo (count($customer_groups) > 1 ? 'div-row' : 'none'); ?>;">
  <h2><?php echo $text_customer_groups; ?></h2>
  <p><?php echo $text_note_groups; ?></p>
  <?php echo $entry_account; ?><br />
  <select name="customer_group_id">
  <?php foreach ($customer_groups as $customer_group) { ?>
  <?php if ($customer_group['customer_group_id'] == $customer_group_id) { ?>
  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
  <?php } else { ?>
  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
  <?php } ?>
  <?php } ?>
  </select>
  <br />
  <br />
</div>
<div class="left">
  <h2><?php echo $text_your_details; ?></h2>
  <span class="required">*</span> <?php echo $entry_firstname; ?><br />
  <input type="text" name="firstname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_lastname; ?><br />
  <input type="text" name="lastname" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_email; ?><br />
  <input type="text" name="email" value="" class="large-field" />
  <br />
  <br />
  <div id="telephone-display"><span class="required">*</span> <?php echo $entry_telephone; ?><br />
  <input type="text" name="telephone" value="&nbsp;&nbsp;&nbsp;" class="large-field" />
  <br />
  <br />
  </div>
  <div id="fax-display"><?php echo $entry_fax; ?><br />
  <input type="text" name="fax" value="" class="large-field" />
  <br />
  <br />
  </div>
  <div id="additional-display">
  <h2><?php echo $text_additional; ?></h2>
  <div id="company-id-display"><span id="company-id-required" class="required">*</span> <?php echo $entry_company_id; ?><br />
    <input type="text" name="company_id" value="" class="large-field" />
    <br />
    <br />
  </div>
  </div>
  <div id="tax-id-display"><span id="tax-id-required" class="required">*</span> <?php echo $entry_tax_id; ?><br />
    <input type="text" name="tax_id" value="" class="large-field" />
    <br />
    <br />
  </div>  
  <h2><?php echo $text_your_password; ?></h2>
  <span class="required">*</span> <?php echo $entry_password; ?><br />
  <input type="password" name="password" value="" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_confirm; ?> <br />
  <input type="password" name="confirm" value="" class="large-field" />
  <br />
  <br />
  <br />
</div>
<div class="right" id="address-display">
  <h2><?php echo $text_your_address; ?></h2>
  <div id="company-display"><?php echo $entry_company; ?><br />
  <input type="text" name="company" value="" class="large-field" />
  <br />
  <br />
  </div>  
  <span class="required">*</span> <?php echo $entry_address_1; ?><br />
  <input type="text" name="address_1" value="&nbsp;&nbsp;&nbsp;" class="large-field" />
  <br />
  <br />
  <div id="address-2-display"><?php echo $entry_address_2; ?><br />
  <input type="text" name="address_2" value="" class="large-field" />
  <br />
  <br />
  </div>  
  <span class="required">*</span> <?php echo $entry_city; ?><br />
  <input type="text" name="city" value="&nbsp;&nbsp;&nbsp;" class="large-field" />
  <br />
  <br />
  <span id="payment-postcode-required" class="required">*</span> <?php echo $entry_postcode; ?><br />
  <input type="text" name="postcode" value="<?php echo $postcode; ?>" class="large-field" />
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_country; ?><br />
  <select name="country_id" class="large-field">
    <option value=""><?php echo $text_select; ?></option>
    <?php foreach ($countries as $country) { ?>
    <?php if ($country['country_id'] == $country_id) { ?>
    <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
    <?php } else { ?>
    <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
    <?php } ?>
    <?php } ?>
  </select>
  <br />
  <br />
  <span class="required">*</span> <?php echo $entry_zone; ?><br />
  <select name="zone_id" class="large-field">
  </select>
  <br />
  <br />
  <br />
</div>
<div style="clear: both; padding-top: 15px;">
  <input type="checkbox" name="newsletter" value="1" id="newsletter" />
  <label for="newsletter"><?php echo $entry_newsletter; ?></label>
  <br />
  <?php if ($shipping_required) { ?>
  <div id="shipping-address-display"><input type="checkbox" name="shipping_address" value="1" id="shipping" checked="checked" />
  <label for="shipping"><?php echo $entry_shipping; ?></label>
  <br />
  </div>
  <?php } ?>
  <br />
  <br />
</div>
<?php if ($text_agree) { ?>
<div class="buttons">
  <div class="right" style="width: 100%;"><?php echo $text_agree; ?>
    <input type="checkbox" name="agree" value="1" />
    <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
  </div>
</div>
<?php } else { ?>
<div class="buttons">
  <div class="right">
    <input type="button" value="<?php echo $button_continue; ?>" id="button-register" class="button" />
  </div>
</div>
<?php } ?>
<script type="text/javascript"><!--
$('#payment-address select[name=\'customer_group_id\']').live('change', function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['telephone_display'] = '<?php echo $customer_group['telephone_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['fax_display'] = '<?php echo $customer_group['fax_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['address_display'] = '<?php echo $customer_group['address_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_display'] = '<?php echo $customer_group['company_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['address_2_display'] = '<?php echo $customer_group['address_2_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['additional_display'] = '<?php echo $customer_group['additional_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['telephone_display'] == '1') {
			$('#telephone-display').show();
		} else {
			$('#telephone-display').hide();
		}
		
		if (customer_group[this.value]['fax_display'] == '1') {
			$('#fax-display').show();
		} else {
			$('#fax-display').hide();
		}
		
		if (customer_group[this.value]['address_display'] == '1') {
			$('#address-display').show();
		} else {
			$('#address-display').hide();
		}
		
		if (customer_group[this.value]['address_display'] == '1') {
			$('#shipping-address-display').show();
		} else {
			$('#shipping-address-display').hide();
		}
		
		if (customer_group[this.value]['company_display'] == '1') {
			$('#company-display').show();
		} else {
			$('#company-display').hide();
		}
		
		if (customer_group[this.value]['address_2_display'] == '1') {
			$('#address-2-display').show();
		} else {
			$('#address-2-display').hide();
		}	
		
		if (customer_group[this.value]['additional_display'] == '1') {
			$('#additional-display').show();
		} else {
			$('#additional-display').hide();
		}
		
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}	
			
	}
});

$('#payment-address select[name=\'customer_group_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('#payment-address select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#payment-address select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#payment-postcode-required').show();
			} else {
				$('#payment-postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {

				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('#payment-address select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#payment-address select[name=\'country_id\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script> 