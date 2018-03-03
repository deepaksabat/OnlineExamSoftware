
@include('common.angular-factory')
<script >
 
     app.controller('users_controller', function ($scope, $http, httpPreConfig) {
      
      $scope.parent_login = '';
      $scope.showSearch = false;
      $scope.userDetails = false;
      $scope.parents = [];
      $scope.parent_user_name = '';
      $scope.parent_email = '';
      $scope.parent_user_id = '';
      $scope.parent_name = '';


      $scope.accountAvailable = function (availability)
      {
        
        if(!availability)
        {
          $scope.userDetails = true;
          $scope.showSearch = false;
          $scope.resetDetails();
        }
        else {
          $scope.resetDetails();
          $scope.showSearch = true;
          $scope.userDetails = false;
        }
        // URL_SEARCH_PARENT_RECORDS
      }

      $scope.getParentRecords = function (text) {

        route   = '{{URL_SEARCH_PARENT_RECORDS}}';
        data    = {   _method: 'post', 
                  '_token':httpPreConfig.getToken(), 
                  'search_text': text,
                  'user_id': $scope.current_user_id,
                  };
               
       httpPreConfig.webServiceCallPost(route, data).then(function(result){
            result = result.data;
        users = [];
 
        angular.forEach(result, function(value, key) {

            users.push(value);
          })
        
        $scope.parents = users;
     
        });
      }

      $scope.resetDetails = function(){
        $scope.parent_user_name = '';
        $scope.parent_name = '';
        $scope.parent_email = '';
        $scope.parent_user_id = '';
        $scope.parents = [];
      }


      $scope.setAsCurrentItem = function (record) {
        $scope.parent_name = record.name;
        $scope.parent_user_name = record.username;
        $scope.parent_email = record.email;
        $scope.parent_user_id = record.id;
         $scope.userDetails = true;
      }

    });

</script>