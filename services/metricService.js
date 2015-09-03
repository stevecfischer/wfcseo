app.service('metricService', function ($http, $q, $routeParams, $filter) {
    return ({
        getProperties: getProperties,
    });

    function getProperties() {
        var request = $http({
            method: 'GET',
            url: '/property_master.json'
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