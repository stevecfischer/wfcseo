var app = angular.module('awr', ['ngRoute', 'chart.js', 'ngTable', 'ngResource', 'ui.bootstrap'], function ($httpProvider) {
Chart.defaults.global.responsive = true;
Chart.defaults.global.maintainAspectRatio = false;
});
//constants
app.constant('scf', {
    version: 2.0,
    url: 'http://wfcseo.wfcdemo.com/',
    prop_uri: 'http://wfcseo.wfcdemo.com/properties'
});

// configure our routes
app.config(function ($routeProvider, $locationProvider) {
    $routeProvider
        // route for the home page
        .when('/templateedit/:templateId', {
            templateUrl: '/analytics/includes/view/template-edit.php',
            controller: 'templateController'
        })
        .when('/sendreport/:propId', {
            templateUrl: '/analytics/includes/view/send-report.php',
            controller: 'propController',
            saction: 'send'
        })
        .when('/sandbox/', {
            templateUrl: '/views/sandbox.php',
            controller: 'MetricController'
        });
    $locationProvider.html5Mode(true);
});


app.value('transpose', function(items) {
  var results = [];
  angular.forEach(items, function(value, key) {
    angular.forEach(value, function(inner, index) {
      results[index] = results[index] || [];
      results[index].push(inner);
    });
  });
  return results;
});

app.value('transposeB', function(items) {
  var results = [];
    var monthChk = [];
  angular.forEach(items, function(value, key) {
      //["07", "(Other)", "21"]

    angular.forEach(value, function(inner, index) {
      results[index] = results[index] || [];
      results[index].push(inner);
    });
  });
  return results;
});






//////
//////
//////
//////  OLD STUFF
//////
//////
//////
app.controller('dashboard', function ($scope, sharedProperties) {
    $scope.username = "Steve Fischer";
    $scope.stringValue = sharedProperties.getString;
    $scope.getProfile = function (ID) { // this is click listener
        sessionStorage.currentProp = angular.toJson(ID);
        sharedProperties.setString(ID); // this is updating ID in header
    };

    $scope.months = wfcLocalized.months;
}).service('sharedProperties', function () {
    var stringValue = angular.fromJson(sessionStorage.currentProp);
    return {
        getString: function () {
            return stringValue;
        },
        setString: function (value) {
            stringValue = value;
        }
    }
});

app.service('myService', function () {
    this.test = function () {
        return "Hello World";
    };
});

app.controller('scfDebug', function ($scope, scfDebugService) {
    $scope.testService = scfDebugService.status();
    //$scope.debugStatus = scfDebugService.status();
    //$scope.debugStatus = scfDebugService.getString;

    $scope.showDebug = function (v) { // this is click listener
        console.log('ere');
        if (scfDebugService.status() === true) {
            //$scope.debugStatus = scfDebugService.disable();
            $scope.testService = scfDebugService.disable();
        } else {
            //$scope.debugStatus = scfDebugService.enable();
            $scope.testService = scfDebugService.enable();
        }

        //scfDebugService.setString(v); // this is updating ID in header
    };
});
app.service('scfDebugService', function () {
    var debugStatus = true;
    this.status = function () {
        return debugStatus;
    };
    this.enable = function () {
        debugStatus = true;
        return debugStatus;
    };
    this.disable = function () {
        debugStatus = false;
        return debugStatus;
    };
});

app.controller('propController', function ($scope, $route, $routeParams) {
    var foo = $route.current.saction;
    $scope.propId = $routeParams.propId;
    $scope.message = foo;
});
app.controller('templateController', function ($scope, $routeParams) {
    $scope.templateId = $routeParams.templateId;
    $scope.message = 'Everyone come and see how good I look!';
});
app.controller('sidebarMenu', function ($scope) {
    $scope.templates = [
        {
            "id": "FirstTemplate.tpl",
            "name": "First Template",
            "description": "Basic Template"
        },
        {
            "id": "default.tpl",
            "name": "Default",
            "description": "In progress"
        }
    ];
});
app.controller('dashboardController', function ($scope) {
    // create a message to display in our view
    $scope.message = 'Sweet New Dashboard';

});