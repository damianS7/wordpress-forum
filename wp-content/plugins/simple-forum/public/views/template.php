<div class="spf-wrapper container-fluid">
    <div id="userbar" class="row">
        <div class="col-sm-12">
            <?php include_once('navbar.php'); ?>
        </div>
    </div>

    <div id="breadcrumb" class="row">
        <div class="col-sm-12">
            <?php include_once('breadcrumb.php'); ?>
        </div>
    </div>

    <div id="view" class="row">
        <div class="col-sm-12">
            <?php include_once(PLUGIN_DIR . 'public/views/' . $view); ?>
        </div>
    </div>

    <div id="messages" class="row">
        <div class="col-sm-12">
            <?php include_once('message.php'); ?>
        </div>
    </div>
</div>
