<?php use thedaysoflife\Com\Com; ?>
<div class="menu">
    <div class="navbar-header">
        <button class="navbar-toggle" type="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar glyphicon glyphicon-align-justify"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <nav class="nav-content collapse navbar-collapse bs-navbar-collapse">
        <ul class="nav navbar-nav">
            <?= Com::getDashboardMenu($this->meta["route"]) ?>
        </ul>
    </nav>
    <div class="pull-right">
        <?= $this->meta["userData"]["name"] ?> | <a href="/back/logout/">Logout</a>
    </div>
</div>