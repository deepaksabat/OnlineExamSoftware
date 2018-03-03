<script src="{{JS}}angular.js"></script>
<script src="{{JS}}angular-messages.js"></script>
	<script src="{{JS}}select2.js"></script>
<script >

	var app = angular.module('academia',  ['ngMessages']);
	 

app.controller('angTopicsController', function($scope, $http) {

    /**
     * Gets the no. of years based on the dueration for that course
     * @return {[type]} [description]
     */
    // $scope.getSubjectParents = function()
    // {
      
    //   route = '/mastersettings/topics/get-parents-topics/'+$('#subject').val();  
    //   data= {_method: 'get', '_token':$scope.getToken()};
    
    //   $http.get(route, data).success(function(result, status) {
            
    //         | Pouplate the subject parents based on selected subject
             
    //         $('#parent').empty();
    //         for(i=0; i<result.length; i++)
    //          $('#parent').append('<option value="'+result[i].id+'">'+result[i].text+'</option>');
    //     });
    // }

    /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
    }

    $scope.fieldChanged = function(type) {
      console.log(type);
      $scope.field_type = type;
    }
    $scope.obj = {};
    
    $scope.intilizeOptions = function (param) {
      console.log(param);
      $scope.obj.total_options1 = parseInt(param);
      console.log("$scope.obj.total_options1   "+$scope.obj.total_options1);
       $scope.options = [];
       for(i=1;i<=parseInt(param);i++){
             $scope.options.push(i);
        }
     
    }

});
 
 
      /**
      * Intilize select by default
      */
    $('.select2').select2({
       placeholder: "Select",
    });

   function getSubjectParents() {
      route = '/mastersettings/topics/get-parents-topics/'+$('#subject').val();  
      var token = $('[name="_token"]').val();
      data= {_method: 'get', '_token':token};
    
      $.ajax.get(route, data).success(function(result, status) {
            /*
            | Pouplate the subject parents based on selected subject
             */
            $('#parent').empty();
            for(i=0; i<result.length; i++)
             $('#parent').append('<option value="'+result[i].id+'">'+result[i].text+'</option>');
        });
   }


    function getSubjectParents()
    {
       route = '/mastersettings/topics/get-parents-topics/'+$('#subject').val();  
       var token = $('[name="_token"]').val();
       data= {_method: 'get', '_token':token};

        $.ajax({
            url:route,
            dataType: 'json',
            data: data,
            success:function(result){
               $('#parent').empty();
            for(i=0; i<result.length; i++)
             $('#parent').append('<option value="'+result[i].id+'">'+result[i].text+'</option>');
            }
        });
    }
 

</script>

