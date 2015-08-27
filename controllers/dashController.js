app.controller('DashController', function ($scope, sharedProperties) {
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