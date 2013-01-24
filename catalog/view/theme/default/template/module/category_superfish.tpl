<link rel="stylesheet" type="text/css" media="screen" href="<?=$superfish_path?>/superfish/css/superfish.css" /> 
<link rel="stylesheet" type="text/css" media="screen" href="<?=$superfish_path?>/superfish/css/superfish-vertical.css" /> 
<script type="text/javascript" src="<?=$superfish_path?>/superfish/js/hoverIntent.js"></script> 
<script type="text/javascript" src="<?=$superfish_path?>/superfish/js/superfish.js"></script> 
<script type="text/javascript"> 
	$(document).ready(function(){ 
		$("ul.sf-menu").superfish();
	}); 
</script>
<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
  <div class="middle" style='padding:0;margin:0;height:auto;'>
  
	<div class="sf-vertical" style='padding:0;margin:0;'>		
		<ul id="sample-menu-1" class="sf-menu" style='padding:0;margin:0;width:100%'>
			<?=$category_superfish?>	
		</ul>
	</div>  
  
  </div>
  <div style='clear:left'></div>
  <div class="bottom">&nbsp;</div>
  </div>
</div>
