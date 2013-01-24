<?php
if ($category_options) { ?>
<style type="text/css">
  #filters{line-height: 22px;}
  #filters b{display:block;padding: 2px 5px 1px 0px;}
  .filter-item{margin: 0;}
  .filter-item label{margin-left:0px;padding-left:0px;display: block;cursor:pointer;}
  .filter-item label input{margin: 0 3px;}
  .filter-item label a{text-decoration:none;color: #236BBB;}
  .filter-item label.active a{color: #E56101;font-weight:bold;}
  .filter-item select{margin-left:0px;min-width:100px;}
  .filter-item label + label{border-top: 1px solid #ECECEC;}
</style>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <form id="filters">
      <?php foreach ($category_options as $category_option) { ?>
        <b><?php echo $category_option['name']; ?></b>
        <div class="filter-item">
		<select onchange="location = this.value;">
        <?php if ($category_option['values']) { ?>
          <?php foreach ($category_option['values'] as $value) { ?>
            <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
              <option onclick="window.location='<?php echo $value['href']; ?>'" selected="selected"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a></option>
            <?php } else { ?>
              <?php if ($value['products']) { ?>
                <option onclick="window.location='<?php echo $value['href']; ?>'"><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a> (<?php echo $value['products']; ?>)</option>
              <?php } else { ?>
                <option value="<?php echo $value['href']; ?>" disabled="disabled"><?php echo $value['name']; ?> (<?php echo $value['products']; ?>)</option>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        <?php } ?>
		</select>
        </div>
      <?php } ?>
    </form>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
<?php } ?>