app.service('sandService', function ($http, $q, $routeParams, $filter) {
    return ({
        getData: getData
    });
    function getData(){
        console.log('ddd');
        //var data = {
        //    action: 'rjs_bulk_new_post',
        //    postdata: bulkTrucksObj,
        //    posttype: $routeParams.type
        //};
        //var request = $http({
        //    method: 'POST',
        //    url: wfcLocalized.ajax_url + "?_wp_json_nonce=" + wfcLocalized.nonce,
        //    data: data,
        //    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        //});
        //return ( request.then(handleSuccess, handleError) );
    }
});