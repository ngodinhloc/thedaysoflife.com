<div id="search-container">
    <?= $this->data["searchResult"] ?>
    <img id="loading-tiny" src="<?= getenv("SITE_URL") ?>/assets/images/ajax-loader.gif" class="hidden"/>
</div>
<script type="text/javascript">
    $(function () {
        wookmarkHandle();
        $("#main-search-text").val('<?= $this->data["searchTerm"] ?>');
        $("#top-search-text").val('<?= $this->data["searchTerm"] ?>');
    });
</script>