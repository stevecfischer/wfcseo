app.service('sandService', function ($http, $q, $routeParams, $filter) {
    return ({
        getManualMetrics: getManualMetrics,
        getGoogleMetrics: getGoogleMetrics,
        getGoogleMetrics2: getGoogleMetrics2,
    });
    function getManualMetrics() {

        var data1 = {
            action: 'manualmetrics',
            postdata: {propertyID: 30359942},
            posttype: $routeParams.type
        };
        var request = $http({
            method: 'POST',
            url: wfcLocalized.ajaxurl,
            data: data1
        });

        return ( request.then(handleSuccess, handleError) );
    }

    function getGoogleMetrics() {
        var request = $http({
            method: 'GET',
            url: "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A30359942&start-date=2015-06-01&end-date=2015-08-31&metrics=ga%3AnewUsers%2Cga%3AbounceRate%2Cga%3Aimpressions%2Cga%3AadClicks%2Cga%3AadCost%2Cga%3ACTR%2Cga%3AgoalCompletionsAll&dimensions=ga%3Amonth&samplingLevel=FASTER&access_token=" + wfcLocalized.access_token
        });
        return ( request.then(handleSuccess, handleError) );
    }

    function getGoogleMetrics2() {
        var request = $http({
            method: 'GET',
            url: "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A30359942&start-date=2015-06-01&end-date=2015-08-31&metrics=ga%3AgoalCompletionsAll&dimensions=ga%3Amonth%2Cga%3AchannelGrouping&samplingLevel=FASTER&access_token=" + wfcLocalized.access_token
        });
        return ( request.then(handleSuccess, handleError) );
    }

    function handleError(response) {
        if (!angular.isObject(response.data) || !response.data.message) {
            return ( $q.reject("An unknown error occurred.") );
        }
        return ( $q.reject(response.data.message) );
    }

    function handleSuccess(response) {
        return ( response.data );
    }
});