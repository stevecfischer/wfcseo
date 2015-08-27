<!--<div class="col-md-12">-->
<!--    <div class="panel panel-default">-->
<!--        <div class="panel-heading">-->
<!--            <h3 class="panel-title"><strong>Report</strong></h3>-->
<!--        </div>-->
<!--        <div class="panel-body">-->
<!--            <div class="table-responsive">-->
<!--                <table class="wfc-metric-table table table-condensed table-bordered">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th class="first-col"></th>-->
<!--                        <th ng-repeat="month in months">{{month}}</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!--                    <tbody ng-repeat="section in reportSections">-->
<!--                    <tr class="section-heading warning">-->
<!--                        <td class="first-col">{{section.label}}:</td>-->
<!--                        <td ng-repeat="month in months track by $index" class="section-heading blank-cell"></td>-->
<!--                    </tr>-->
<!--                    <tr ng-class="{'last-subsection-row':$last}" ng-repeat="sub in section.subsections">-->
<!--                        <td class="no-line first-col">{{sub.label}}</td>-->
<!--                        <td ng-repeat="metric in sub.metrics() track by $index">{{metric}}</td>-->
<!--                    </tr>-->
<!--                    <tr class="success" ng-repeat="total in section.totals">-->
<!--                        <td class="total-heading first-col">{{total.label}}</td>-->
<!--                        <td class="total-cell" ng-repeat="sum in total.sums($index) track by $index">{{sum}}</td>-->
<!--                    </tr>-->
<!--                    <tr class="empty-row"></tr>-->
<!--                    </tbody>-->
<!--                </table>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<section id="directives">
      <div class="page-header">
        <h1>Directives</h1>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12" id="line-chart" ng-controller="LineCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Line Chart</div>
            <div class="panel-body">
              <canvas id="line" class="chart chart-line" data="data" labels="labels" legend="true"
                      click="onClick" hover="onHover" series="series"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-line</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: x axis labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>series</code> (default: <code>[]</code>): series labels</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;line&quot; class=&quot;chart chart-line&quot; data=&quot;data&quot;
  labels=&quot;labels&quot; legend=&quot;true&quot; series=&quot;series&quot;
  click=&quot;onClick&quot;&gt;
&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("LineCtrl", function ($scope) {

  $scope.labels = ["January", "February", "March", "April", "May", "June", "July"];
  $scope.series = ['Series A', 'Series B'];
  $scope.data = [
    [65, 59, 80, 81, 56, 55, 40],
    [28, 48, 40, 19, 86, 27, 90]
  ];
  $scope.onClick = function (points, evt) {
    console.log(points, evt);
  };
});
              </code></pre>
            </tab>
          </tabset>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-bar</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: x axis labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>series</code> (default: <code>[]</code>): series labels</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;bar&quot; class=&quot;chart chart-bar&quot; data=&quot;data&quot;
  labels=&quot;labels&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("BarCtrl", function ($scope) {
  $scope.labels = ['2006', '2007', '2008', '2009', '2010', '2011', '2012'];
  $scope.series = ['Series A', 'Series B'];

  $scope.data = [
    [65, 59, 80, 81, 56, 55, 40],
    [28, 48, 40, 19, 86, 27, 90]
  ];
});
              </code></pre>
            </tab>
          </tabset>
        </div>
        <div class="col-lg-6 col-sm-12" id="bar-chart" ng-controller="BarCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Bar Chart</div>
            <div class="panel-body">
              <canvas id="bar" class="chart chart-bar" data="data" labels="labels" series="series"
                      options="options"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12" id="doughnut-chart" ng-controller="DoughnutCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Doughnut Chart</div>
            <div class="panel-body">
              <canvas id="doughnut" class="chart chart-doughnut chart-xs" data="data" labels="labels" legend="false"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-doughnut</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: series labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;doughnut&quot; class=&quot;chart chart-doughnut&quot; data=&quot;data&quot;
  labels=&quot;labels&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("DoughnutCtrl", function ($scope) {
  $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales"];
  $scope.data = [300, 500, 100];
});
              </code></pre>
            </tab>
          </tabset>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-radar</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: series labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>series</code> (default: <code>[]</code>): series labels</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;radar&quot; class=&quot;chart chart-radar&quot; data=&quot;data&quot;
  labels=&quot;labels&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("RadarCtrl", function ($scope) {
  $scope.labels =["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"];

  $scope.data = [
    [65, 59, 90, 81, 56, 55, 40],
    [28, 48, 40, 19, 96, 27, 100]
  ];
});
              </code></pre>
            </tab>
          </tabset>
        </div>
        <div class="col-lg-6 col-sm-12" id="radar-chart" ng-controller="RadarCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Radar Chart</div>
            <div class="panel-body">
              <canvas id="area" class="chart chart-radar" data="data" labels="labels" click="onClick"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12" id="pie-chart" ng-controller="PieCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Pie Chart</div>
            <div class="panel-body">
              <canvas id="pie" class="chart chart-pie chart-xs" data="data" labels="labels"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-pie</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: series labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;pie&quot; class=&quot;chart chart-pie&quot; data=&quot;data&quot;
  labels=&quot;labels&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("PieCtrl", function ($scope) {
  $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales"];
  $scope.data = [300, 500, 100];
});
              </code></pre>
            </tab>
          </tabset>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-polar-area</code>
                <ul>
                  <li><code>data</code>: series data</li>
                  <li><code>labels</code>: series labels</li>
                  <li><code>legend</code> (default: <code>false</code>): show legend below the chart</li>
                  <li><code>options</code> (default: <code>{}</code>): Chart.js options</li>
                  <li><code>click</code> (optional): onclick event handler</li>
                  <li><code>hover</code> (optional): onmousemove event handler</li>
                  <li><code>colours</code> (default to global colours): colours for the chart</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;polar-area&quot; class=&quot;chart chart-polar-area&quot; data=&quot;data&quot;
  labels=&quot;labels&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("PolarAreaCtrl", function ($scope) {
  $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales", "Tele Sales", "Corporate Sales"];
  $scope.data = [300, 500, 100, 40, 120];
});
              </code></pre>
            </tab>
          </tabset>
        </div>
        <div class="col-lg-6 col-sm-12" id="polar area-chart" ng-controller="PolarAreaCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Polar Area Chart</div>
            <div class="panel-body">
              <canvas id="polar" class="chart chart-polar-area" data="data" labels="labels"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-sm-12" id="base-chart" ng-controller="BaseCtrl">
          <div class="panel panel-default">
            <div class="panel-heading">Dynamic Chart</div>
            <div class="panel-body">
              <canvas id="base" class="chart chart-base" chart-type="type" data="data" labels="labels" legend="true"></canvas>
            </div>
          </div>
          <button type="button" class="btn btn-primary pull-right" ng-click="toggle()">Toggle</button>
        </div>
        <div class="col-lg-6 col-sm-12 code">
          <tabset>
            <tab heading="Settings" class="settings">
              <div class="settings">
                <code>.chart-base</code>
                <ul>
                  <li><code>chart-type</code>: chart type e.g. Bar, PolarArea, etc. or other plugins</li>
                  <li>other options according to chart type</li>
                </ul>
              </div>
            </tab>
            <tab heading="Markup">
              <pre><code data-language="html">&lt;canvas id=&quot;base&quot; class=&quot;chart-base&quot; chart-type=&quot;type&quot; data=&quot;data&quot;
  labels=&quot;labels&quot; legend=&quot;true&quot;&gt;&lt;/canvas&gt; </code></pre>
            </tab>
            <tab heading="Javascript">
              <pre><code data-language="javascript">angular.module("app", ["chart.js"]).controller("BaseCtrl",
  function ($scope) {
    $scope.labels = ["Download Sales", "In-Store Sales", "Mail-Order Sales", "Tele Sales", "Corporate Sales"];
    $scope.data = [300, 500, 100, 40, 120];
    $scope.type = 'PolarArea';

    $scope.toggle = function () {
      $scope.type = $scope.type === 'PolarArea' ?
        'Pie' : 'PolarArea';
    };
});
              </code></pre>
            </tab>
          </tabset>
        </div>
      </div>
    </section>
