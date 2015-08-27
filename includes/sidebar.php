<?php
    /**
     *
     * @package ReportHelper
     * @author Steve
     * @date 12/17/13
     */
?>
<ul class="nav nav-pills nav-stacked nav-wfc-properties-container">
    <li class="active">
    <a data-toggle="collapse"
       data-parent=".nav-wfc-properties-container"
       href="#collapseOne"
       class="nav-wfc-properties collapsed">Sites
        <span class="glyphicon glyphicon-plus pull-right"></span>
    </a>
    <ul class="collapse wfc-web-property-list" id="collapseOne">
        <?php
            $get_properties  = file_get_contents( "property_master.json" );
            $property_master = json_decode( $get_properties );
            foreach( $property_master->property_names as $p ){
                $prop   = explode( ",", $p );
                $propID = $prop[0];
                ?>
                <li ng-click="getProfile(<?php echo $propID; ?>)" class="dropdown wfc-web-property">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="wfc-property-url"><?php echo $wfc_core->sanitize_title( $prop[1] ); ?>
                        <span ng-show="debugStatus"> - <?php echo $propID; ?></span>
                    </span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                    <a data-code="<?php echo $propID; ?>"
                       data-toggle="modal"
                       class="table-site-template"
                       data-names="code"
                       data-where="this"
                       data-target="#property_dashboard">Edit Manual Data
                    </a>
                    <a data-code="<?php echo $propID; ?>"
                       data-toggle="modal"
                       class="view-metrics"
                       data-names="code"
                       data-where="this"
                       data-target="#viewmetrics">View Metrics
                    </a>
                    </li>
                </ul>
                </li>
                <?php
            }//endforeach
        ?>
    </ul>
    </li>
</ul>
<!--<ul class="nav nav-pills nav-stacked nav-wfc-templates-container">
    <li class="active">
        <a data-toggle="collapse" data-parent=".nav-wfc-templates-container" href="#collapseTwo" class="nav-wfc-templates collapsed">Templates
            <span class="glyphicon glyphicon-plus pull-right"></span>
        </a>
        <ul class="collapse wfc-template-list" id="collapseTwo">
            <li ng-repeat="template in templates" ng-class="{active: routeIs('/templateedit/{{template.id}}')}" class="dropdown wfc-template-item">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    {{template.name}}
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="#templateedit/{{template.id}}" class="template-toolbar-icon template_edit">Edit</a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>-->