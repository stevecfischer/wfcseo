<nav class="row toolbar wfc-toolbar">
    <span class="col-md-4">
        <p class="navbar-text">Welcome <strong>{{username}}</strong></p>
    </span>
    <span style="text-align:left;" class="col-md-4">
        <span ng-show="debugStatus">Current Property {{stringValue()}}</span>
    </span>
    <span class="col-md-4">
        <a data-toggle="tooltip" data-placement="bottom" title="Sandbox" href="/sandbox/">
            <span class="glyphicon glyphicon-asterisk"></span>
        </a>
        <a data-toggle="tooltip" data-placement="bottom" title="Home" href="#dashboard">
            <span class="glyphicon glyphicon-home"></span>
        </a>
        <a data-toggle="tooltip" data-placement="bottom" title="Refresh" href="index.php?refresh">
            <span class="glyphicon glyphicon-retweet"></span>
        </a>
        <a class="wfc-documentation"
           data-toggle="tooltip"
           data-placement="bottom"
           title="Documentation"
           href="https://github.com/stevecfischer/wfcseo/wiki"
           target="_blank">
            <span class="glyphicon glyphicon-list-alt"></span>
        </a>
        <a class="wfc-logout"
           data-toggle="tooltip"
           data-placement="bottom"
           title="Logout"
           href="<?php echo $revokeUrl; ?>">
            <span class="glyphicon glyphicon-log-out"></span>
        </a>
    </span>
</nav>