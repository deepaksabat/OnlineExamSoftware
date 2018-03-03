
<script src="{{JS}}angular.js"></script>
<script src="{{JS}}angular-messages.js"></script>

<script>
var app = angular.module('academia', ['ngMessages']);
app.controller('angLmsController', function($scope, $http) {
    
        
    $scope.initAngData = function(data) {
        if(data=='')
        {
            $scope.series = '';
            $scope.content_type = '';
            return;
        }
         data = JSON.parse(data);
         $scope.content_type    = data.content_type;
    }
});
 
</script>