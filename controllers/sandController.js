app.controller("MetricController", function ($scope, ngTableParams, $filter, sandService, $timeout, transpose, transposeB) {
    $scope.months = ["June", "July", 'Aug'];
    $scope.metricMap = {
        'Unique Visits': 2,
        'Bounce Rate': 3,
        'Impressions': 4,
        'Clicks': 5,
        'SEM Spend': 6,
        'CTR': 7,
        'Total Monthly Conversions': 8
    };
    $scope.manualMetricMap = {
        'Direct': 1,
        'Display': 2,
        'Organic': 3,
        'SEM': 4,
        'Referral': 5,
        'Social': 6,
    };
    $scope.reportSections = [
        {
            label: 'General Performance',
            subsections: [
                {label: 'Unique Visits', metrics: getMetricData},
                {label: 'Bounce Rate', metrics: getMetricData}
            ]
        },
        {
            label: 'Phone Conversions',
            subsections: [
                {label: 'Direct', metrics: getManualMetricData},
                {label: 'Display', metrics: getManualMetricData},
                {label: 'Organic', metrics: getManualMetricData},
                {label: 'SEM', metrics: getManualMetricData},
                {label: 'Referral', metrics: getManualMetricData},
                {label: 'Social', metrics: getManualMetricData},
            ],
            totals: [
                {label: 'Total Phone Conversions', sums: sumByKey}
            ]
        },
        {
            label: 'Form Conversions',
            subsections: [
                {label: 'Direct', metrics: getMetricData},
                {label: 'Display', metrics: getMetricData},
                {label: 'Organic', metrics: getMetricData},
                {label: 'SEM', metrics: getMetricData},
                {label: 'Referral', metrics: getMetricData},
                {label: 'Social', metrics: getMetricData},
            ],
            totals: [
                {label: 'Total Form Conversions', sums: [4, 4]}
            ]
        },
        {
            label: 'SEM Metrics',
            subsections: [
                {label: 'Impressions', metrics: getMetricData},
                {label: 'Clicks', metrics: getMetricData},
                {label: 'CTR', metrics: getMetricData},
                {label: 'SEM Spend', metrics: getMetricData},
            ]
        },
        {
            label: 'ROI Summary',
            subsections: [
                {label: 'Total Monthly Conversions', metrics: [4, 4]},
                {label: 'Total Monthly Budget', metrics: [4, 4]},
                {label: 'Cost Per Conversion', metrics: [4, 4]}
            ]
        },
        {
            label: 'Custom Client Metrics',
            subsections: [
                {label: 'Total Inbound Phone Calls', metrics: getMetricData},
                {label: 'Replacement Appointments ', metrics: getMetricData},
                {label: 'Repair & Tune-up Appointments', metrics: getMetricData},
                {label: 'Replacement Opportunities', metrics: getMetricData},
                {label: 'Replacement Quotes', metrics: getMetricData},
                {label: 'Thumbtack Lead Source', metrics: getMetricData},
                {label: 'Craigslist Lead Source', metrics: getMetricData}
            ],
            totals: [
                {label: 'MTD Acutal Sales', sums: [4, 4]},
                {label: 'MTD Sales Trending', sums: [4, 4]},
                {label: 'Total Monthly Sales Goal', sums: [4, 4]}
            ]
        }
    ];

    $scope.manualReportData = [];
    sandService.getManualMetrics()
        .then(function (d) {
            $timeout(function () {
                console.log(1);
                $scope.manualReportData = transpose(d);
                console.log($scope.manualReportData);
            }, 1000);
        });

    $scope.googleReportData = [];

    $scope.googleReportData2 = [];

    sandService.getGoogleMetrics()
        .then(function (d) {
            $timeout(function () {
                $scope.googleReportData = transpose(d.rows);
            }, 1000);
        });
    sandService.getGoogleMetrics2()
        .then(function (d) {
            $timeout(function () {
                $scope.googleReportData2 = transposeB(d.rows);
            }, 1000);
        });

    function getMetricData() {
        if ($scope.metricMap[this.label] != undefined) {
            var i = $scope.metricMap[this.label];
            if ($scope.googleReportData[i] != undefined) {
                return $scope.googleReportData[i];
            }
        }
    }

    function getManualMetricData() {
        if ($scope.manualMetricMap[this.label] != undefined) {
            var i = $scope.manualMetricMap[this.label];
            if ($scope.manualReportData[i] != undefined) {
                return $scope.manualReportData[i];
            }
        }
    }

    function sumByKey(index) {
        console.log(index);

        if (typeof (data) === 'undefined' || typeof (key) === 'undefined') {
            return 0;
        }

        var sum = 0;
        for (var i = data.length - 1; i >= 0; i--) {
            sum += parseInt(data[i][key]);
        }

        return sum;

    }
});