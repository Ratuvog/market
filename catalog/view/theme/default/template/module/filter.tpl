<?php
if ($category_options) { ?>
<style type="text/css">
  #filters{line-height: 22px;}
  #filters b{display:block;padding: 2px 5px 1px 15px;}
  .filter-item{margin: 0 5px;}
  .filter-item label{margin-left:5px;padding-left:5px;display: block;cursor:pointer;}
  .filter-item label input{margin: 0 3px;}
  .filter-item label a{text-decoration:none;color: #236BBB;}
  .filter-item label.active a{color: #E56101;font-weight:bold;}
  .filter-item select{margin-left:10px;min-width:100px;}
  .filter-item label + label{border-top: 1px solid #ECECEC;}
</style>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <form id="filters">
      <?php foreach ($category_options as $category_option) { ?>
        <b><?php echo $category_option['name']; ?></b>
        <div class="filter-item">
        <?php if ($category_option['values']) { ?>
          <?php foreach ($category_option['values'] as $value) { ?>
            <?php if (in_array($value['value_id'], $filter_values_id)) { ?>
              <label class="active"><input type="checkbox" checked="checked" option_id="<?=$value['option_id'];?>" value_id="<?=$value['value_id'];?>"><a href="#"><?php echo $value['name']; ?></a></label>
            <?php } else { ?>
              <?php if ($value['products']) { ?>
                <label><input type="checkbox" option_id="<?=$value['option_id'];?>" value_id="<?=$value['value_id'];?>"><a href="#"><?php echo $value['name']; ?></a> (<?php echo $value['products']; ?>)</label>
              <?php } else { ?>
                <label><input type="checkbox" disabled="disabled"><span class="grey"><?php echo $value['name']; ?> (<?php echo $value['products']; ?>)</span></label>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        <?php } ?>
        </div>
      <?php } ?>
        <a href="#" id="acceptedFilter">Применить</a>
    </form>
  </div>
  <div class="bottom">&nbsp;</div>
</div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#filters a").click(function(){
            return false;
        })
        $("#filters input:checkbox").change(function(){
            if($(this).is(':checked')) {
                $(this).parents('label').addClass('active');
            } else {
                $(this).parents('label').removeClass('active');
            }
        })
        $("#acceptedFilter").click(function(){
            var address = location.href;
            var indexStartFilter = address.indexOf("filter");
            var baseAddress = address.substr(0,indexStartFilter==-1 ? address.length : indexStartFilter-1);
            var filters = [];
            $('#filters input:checkbox:checked').each(function(){
                if(typeof filters[$(this).attr('option_id')]=='undefined')
                    filters[$(this).attr('option_id')]=[];
                filters[$(this).attr('option_id')].push($(this).attr('value_id'));
            })
            var filtersString = "&filter=";
            for(var i in filters) {
                filtersString = filtersString.concat(i+"=");
                for(var j=0;j<filters[i].length;j++) {
                    filtersString = filtersString.concat(filters[i][j]+",");
                }
                filtersString = filtersString.substr(0,filtersString.length-1);
                filtersString+=";";
            }
            filtersString = filtersString.substr(0,filtersString.length-1);
            location.href = baseAddress+filtersString;
            return false;
        })
    })
</script>