<?php
if ($category_options) { ?>
<style type="text/css">
  #filters{line-height: 22px;}
  #filters b{display:block;padding: 2px 5px 1px 15px;}
  .filter-item{margin:0;}
  .filter-item label{margin-left:5px;padding-left:5px;display: block;cursor:pointer;}
  .filter-item label input{margin: 0 3px;}
  .filter-item label a{text-decoration:none;color: #236BBB;}
  .filter-item label.active a{color: #E56101;font-weight:bold;}
  .filter-item select{margin-left:10px;min-width:100px;}
  .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active{border:1px solid #CCCCCC !important;}
</style>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
    <form id="filters">
	 <div id="accordion-filter">
      <?php foreach ($category_options as $category_option) { ?>
        <div style="text-align:left;"><a style="color:#000000;"><?php echo $category_option['name']; ?></a></div>
        <div class="filter-item" style="text-align:left;background:none;padding:5px;">
        <?php if ($category_option['values']) { ?>
          <?php foreach ($category_option['values'] as $value) { ?>
            <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
              <label class="active"><input type="checkbox" onclick="window.location='<?php echo $value['href']; ?>'" checked="checked"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a></label>
            <?php } else { ?>
              <?php if ($value['products']) { ?>
                <label><input type="checkbox" onclick="window.location='<?php echo $value['href']; ?>'"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a> (<?php echo $value['products']; ?>)</label>
              <?php } else { ?>
                <label><input type="checkbox" disabled="disabled"><span class="grey"><?php echo $value['name']; ?> (<?php echo $value['products']; ?>)</span></label>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        <?php } ?>
        </div>
      <?php } ?>
	 </div>
    </form>
</div>
<?php } ?>
<script>
$(function() {
	$( "#accordion-filter" ).accordion();
});
</script>