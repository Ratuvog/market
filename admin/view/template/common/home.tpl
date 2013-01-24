<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_install) { ?>
  <div class="warning"><?php echo $error_install; ?></div>
  <?php } ?>
  <?php if ($error_image) { ?>
  <div class="warning"><?php echo $error_image; ?></div>
  <?php } ?>
  <?php if ($error_image_cache) { ?>
  <div class="warning"><?php echo $error_image_cache; ?></div>
  <?php } ?>
  <?php if ($error_cache) { ?>
  <div class="warning"><?php echo $error_cache; ?></div>
  <?php } ?>
  <?php if ($error_download) { ?>
  <div class="warning"><?php echo $error_download; ?></div>
  <?php } ?>
  <?php if ($error_logs) { ?>
  <div class="warning"><?php echo $error_logs; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
	<div class="latest">
     <div class="dashboard-heading"><?php echo $text_quick_buttons; ?></div>
      <div class="dashboard-content">
	  <div class="shortcuts">
	  <ul>
		<li> <a href="<?php echo $settings; ?>"> <img src="view/image/settings.png">
		  <h6><?php echo $text_settings; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $modules; ?>"> <img src="view/image/modules.png">
		  <h6><?php echo $text_modules; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $modules_shipping; ?>"> <img src="view/image/mod-shipping.png">
		  <h6><?php echo $text_modules_shipping; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $modules_payment; ?>"> <img src="view/image/mod-payment.png">
		  <h6><?php echo $text_modules_payment; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $add_product; ?>"> <img src="view/image/add-product.png">
		  <h6><?php echo $text_add_product; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $products; ?>"> <img src="view/image/products.png">
		  <h6><?php echo $text_products; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $add_category; ?>"> <img src="view/image/add-category.png">
		  <h6><?php echo $text_add_category; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $categories; ?>"> <img src="view/image/categories.png">
		  <h6><?php echo $text_categories; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $attributes; ?>"> <img src="view/image/attributes.png">
		  <h6><?php echo $text_attributes; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $options; ?>"> <img src="view/image/options.png">
		  <h6><?php echo $text_options; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $manufacturer; ?>"> <img src="view/image/manufacturer.png">
		  <h6><?php echo $text_manufacturer; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $downloads; ?>"> <img src="view/image/downloads.png">
		  <h6><?php echo $text_downloads; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $information; ?>"> <img src="view/image/information_s.png">
		  <h6><?php echo $text_information; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $reviews; ?>"> <img src="view/image/reviews.png">
		  <h6><?php echo $text_reviews; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $order_s; ?>"> <img src="view/image/orders.png">
		  <h6><?php echo $text_orders; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $returns; ?>"> <img src="view/image/returns.png">
		  <h6><?php echo $text_returns; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $customers; ?>"> <img src="view/image/customers.png">
		  <h6><?php echo $text_customers; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $coupons; ?>"> <img src="view/image/coupons.png">
		  <h6><?php echo $text_coupons; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $mail; ?>"> <img src="view/image/sent-mail.png">
		  <h6><?php echo $text_mail; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $purchased; ?>"> <img src="view/image/purchased.png">
		  <h6><?php echo $text_purchased; ?></h6>
		  </a> </li>
		<li> <a href="<?php echo $backup_restore; ?>"> <img src="view/image/backup_restore.png">
		  <h6><?php echo $text_backup_restore; ?></h6>
		  </a> </li>
	  </ul>
	  </div>
	 </div>
	 <br />
	 <div style="clear:both;"></div>
		<?php echo $newspanel; ?>
	 <br />
	 <div style="clear:both;"></div>
      <div class="overview">
        <div class="dashboard-heading"><?php echo $text_overview; ?></div>
        <div class="dashboard-content">
          <table>
            <tr>
              <td><?php echo $text_total_product; ?></td>
              <td align="right"><?php echo $total_product; ?></td>
            </tr>
			<tr>
              <td><?php echo $text_total_sale; ?></td>
              <td><?php echo $total_sale; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_sale_year; ?></td>
              <td><?php echo $total_sale_year; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_order; ?></td>
              <td><?php echo $total_order; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer; ?></td>
              <td><?php echo $total_customer; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_customer_approval; ?></td>
              <td><?php echo $total_customer_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_review_approval; ?></td>
              <td><?php echo $total_review_approval; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate; ?></td>
              <td><?php echo $total_affiliate; ?></td>
            </tr>
            <tr>
              <td><?php echo $text_total_affiliate_approval; ?></td>
              <td><?php echo $total_affiliate_approval; ?></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="statistic">
        <div class="range"><?php echo $entry_range; ?>
          <select id="range" onchange="getSalesChart(this.value)">
            <option value="day"><?php echo $text_day; ?></option>
            <option value="week"><?php echo $text_week; ?></option>
            <option value="month"><?php echo $text_month; ?></option>
            <option value="year"><?php echo $text_year; ?></option>
          </select>
        </div>
        <div class="dashboard-heading"><?php echo $text_statistics; ?></div>
        <div class="dashboard-content">
          <div id="report" style="width: 390px; height: 170px; margin: auto;"></div>
        </div>
      </div>
      <div class="latest">
        <div class="dashboard-heading"><?php echo $text_latest_10_orders; ?></div>
        <div class="dashboard-content">
          <table class="list">
            <thead>
              <tr>
                <td class="right"><?php echo $column_order; ?></td>
                <td class="left"><?php echo $column_customer; ?></td>
                <td class="left"><?php echo $column_status; ?></td>
                <td class="left"><?php echo $column_date_added; ?></td>
                <td class="right"><?php echo $column_total; ?></td>
                <td class="right"><?php echo $column_action; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php if ($orders) { ?>
              <?php foreach ($orders as $order) { ?>
              <tr>
                <td class="right"><?php echo $order['order_id']; ?></td>
                <td class="left"><?php echo $order['customer']; ?></td>
                <td class="left"><?php echo $order['status']; ?></td>
                <td class="left"><?php echo $order['date_added']; ?></td>
                <td class="right"><?php echo $order['total']; ?></td>
                <td class="right"><?php foreach ($order['action'] as $action) { ?>
                  [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                  <?php } ?></td>
              </tr>
              <?php } ?>
              <?php } else { ?>
              <tr>
                <td class="center" colspan="6"><?php echo $text_no_results; ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!--[if IE]>
<script type="text/javascript" src="view/javascript/jquery/flot/excanvas.js"></script>
<![endif]--> 
<script type="text/javascript" src="view/javascript/jquery/flot/jquery.flot.js"></script> 
<script type="text/javascript"><!--
function getSalesChart(range) {
	$.ajax({
		type: 'get',
		url: 'index.php?route=common/home/chart&token=<?php echo $token; ?>&range=' + range,
		dataType: 'json',
		async: false,
		success: function(json) {
			var option = {	
				shadowSize: 0,
				lines: { 
					show: true,
					fill: true,
					lineWidth: 1
				},
				grid: {
					backgroundColor: '#FFFFFF'
				},	
				xaxis: {
            		ticks: json.xaxis
				}
			}

			$.plot($('#report'), [json.order, json.customer], option);
		}
	});
}

getSalesChart($('#range').val());
//--></script> 
<?php echo $footer; ?>