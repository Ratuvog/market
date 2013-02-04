<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) echo '<?xml version="1.0" encoding="UTF-8"?>'. "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />

<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>

<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>

<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>

<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>


<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<link href="catalog/view/theme/default/stylesheet/bootstrap.css" rel="stylesheet">
<link href="catalog/view/theme/default/stylesheet/bootstrap-responsive.css" rel="stylesheet">
<link rel="stylesheet" href="catalog/view/javascript/jquery/woothemes-FlexSlider-54e6d31/flexslider.css" />
    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/mainStyle.css" />
    <link rel="stylesheet" href="catalog/view/theme/default/stylesheet/market.css" />
    <link rel="stylesheet" href="http://exacttarget.github.com/fuelux/vendor/fuelux/css/fuelux.css" />
<link rel="stylesheet" href="catalog/view/javascript/jquery/jquery.rating/styles/jquery.rating.css" />
<link rel="stylesheet" href="catalog/view/javascript/jquery/jquery.rating/styles/styles.css" />
<link rel="stylesheet" href="catalog/view/javascript/jquery/jQueryRaterPlugin/style.css" />
<link rel="stylesheet" href="/catalog/view/javascript/jquery/star-rating/jquery.rating.css" />

    <script src="catalog/view/javascript/bootstrap/jquery.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
<script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>


<script type="text/javascript" src="catalog/view/javascript/bootstrap/widgets.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/woothemes-FlexSlider-54e6d31/jquery.flexslider-min.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-transition.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-alert.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-modal.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-dropdown.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-scrollspy.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-tab.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-tooltip.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-popover.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-button.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-collapse.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-carousel.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-typeahead.js"></script>
<script src="catalog/view/javascript/bootstrap/bootstrap-affix.js"></script>

<script src="catalog/view/javascript/bootstrap/holder.js"></script>
<script src="catalog/view/javascript/bootstrap/prettify.js"></script>

<script src="catalog/view/javascript/bootstrap/application.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/spinner.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.rating/js/jquery.rating-2.0.js"></script>
<script type="text/javascript"src="catalog/view/javascript/jquery/jQueryRaterPlugin/jquery.rater.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/star-rating/jquery.rating.pack.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('.flexslider').flexslider();
        $(".spinner").spinner();
        /*$("#rating_1").rating({
         fx: 'full',
         image: 'js/jquery.rating/images/stars.png',
         loader: 'js/jquery.rating/images/ajax-loader.gif',
         callback: function(responce){
         this.vote_success.fadeOut(2000);
         }
         })*/
        $("#rating_1,.rating_1").rater();
    });
</script>

<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie8.css" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
<style type="text/css">.holderjs-fluid {font-size:16px;font-weight:bold;text-align:center;font-family:sans-serif;border-collapse:collapse;border:0;vertical-align:middle;margin:0}</style>
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<?php echo $google_analytics; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('input:radio[name^="option"]').change(function() {
            if($(this).is(":checked")) {
                var rawOptions = $(this).next().text();
                var indexOpenSkob  = rawOptions.indexOf("(");
                var indexCloseSkob = rawOptions.indexOf(")");
                var newPrice       = rawOptions.substr(indexOpenSkob+1, indexCloseSkob-indexOpenSkob-1).trim();
                $('#priceUpdate').text(newPrice);
            }
        });
    });
</script>
</head>
<body data-spy="scroll" data-target=".bs-docs-sidebar" data-twttr-rendered="false">
<div class="navbar navbar-fixed-top top-panel">
    <div class="navbar-inner" id="header">
        <div class="container">
            <div class="nav-collapse collapse navbar-responsive-collapse">
                <ul class="nav">
                    <li><a href="#">Подобрать питание</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="#">Оплата и доставка</a></li>
                </ul>
            </div>
            <div class="input-append navbar-search" id="search">
                <input type="text" class="span2" placeholder="Поиск" name="filter_name"/>
                <button class="btn button-search" type="button"><i class="icon-search"></i></button>
            </div>
            <ul class="nav pull-right" id="cart">
                <?=$cart;?>
            </ul>
        </div>
    </div>
</div>
<div class="container market-main-container">
    <div class="mainFrame">
        <div class="row-fluid">
            <span class="span8 button-header">
                <a href="#">Наши акции</a>
                <a href="#">Доставка и оплата</a>
                <a href="#">Подбор питания</a>
            </span>
            <span class="numberTel" >
                <div class="telefon-img"></div>
                <h4 class="numberTelefon">8(846)270-70-70</h4>
            </span>
        </div>












