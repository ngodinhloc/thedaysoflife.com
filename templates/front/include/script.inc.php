<?php
$const = ["SITE_URL" => getenv("SITE_URL"),
    "CONTROLLER_URL" => getenv("CONTROLLER_URL"),
    "LIST_URL" => getenv("SITE_URL") . "/day/",
    "EDIT_URL" => getenv("SITE_URL") . "/edit/",
    "LIST_EXT" => getenv("URL_EXT"),
    "NUM_PER_PAGE" => \thedaysoflife\Sys\Configs::NUM_PER_PAGE,
    "NUM_CALENDAR" => \thedaysoflife\Sys\Configs::NUM_CALENDAR,
    "NUM_PICTURE" => \thedaysoflife\Sys\Configs::NUM_PICTURE,
    "LIST_FADE" => 1000,
    "COM_FADE" => 500,
    "LOADER_FADE" => 3000];
$json = json_encode($const, JSON_UNESCAPED_SLASHES);
?>
    <script>
        var AJAX_LOADER = '<img id="loading-tiny" src="<?= getenv("SITE_URL") ?>/assets/images/ajax-loader.gif"/>';
        var CONST = $.parseJSON('<?= $json ?>');
    </script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/bootstrap/bootstrap.bootbox.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/jquery/jquery.scrolltofixed.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/jquery/jquery.imagesloaded.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/jquery/jquery.wookmark.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/jquery/jquery.easing.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/plugins/jquery/jquery.mousewheel.min.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/assets/js/ajax.js"></script>
    <script type="text/javascript" src="<?= getenv("SITE_URL") ?>/assets/js/thedaysoflife.front.js"></script>
<?= $this->meta["metaTags"]["footer"] ?>