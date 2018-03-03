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
    $scope.getSubjectParents = function()
    {
      subject_id = $('#subject').val();
      route = '{{URL_TOPICS_GET_PARENT_TOPICS}}';  
  


      data= {_method: 'post', '_token':$scope.getToken(), 'subject_id': subject_id};
    
      $http.post(route, data).success(function(result, status) {
            /*
            | Pouplate the subject parents based on selected subject
             */
            $('#parent').empty();
            for(i=0; i<result.length; i++)
             $('#parent').append('<option value="'+result[i].id+'">'+result[i].text+'</option>');
        });
    }

    /**
     * Returns the token by fetching if from from form
     * 
     */
    $scope.getToken = function(){
      return  $('[name="_token"]').val();
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
      
          subject_id = $('#subject').val();
      route = '{{URL_TOPICS_GET_PARENT_TOPICS}}'+subject_id;  
  
    var token = $('[name="_token"]').val();

      // data= {_method: 'post', '_token':$scope.getToken(), 'subject_id': subject_id};
      
      data= {_method: 'get', '_token':token, 'subject_id': subject_id};

       // var token = $('[name="_token"]').val();
       // data= {_method: 'get', '_token':token};

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

