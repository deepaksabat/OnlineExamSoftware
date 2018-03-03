
@if(!isset($load_module) )
 <script src="{{JS}}angular.js"></script>
@endif

<script>

@if(!isset($load_module) )
var app = angular.module('academia', []);
@endif

app.factory('httpPreConfig', function($http, $rootScope, $timeout, $q) {
   return {
    webServiceCallPost: function(url, data) {
    	  	$('#ajax_loader').fadeIn({{AJAXLOADER_FADEIN_TIME}});
        return $http.post(url,data).then(function(response) {
        	$('#ajax_loader').fadeOut({{AJAXLOADER_FADEOUT_TIME}});
               return response;
    });
    },
    getToken : function(){
      return  $('[name="_token"]').val();
    },
    findIndexInData    : function (Array, property, action) {
          var result           = -1;
          angular.forEach(Array, function(value, index) {
             if(value[property]==action){
                result         =index;
             }
          });
          return result;
        },
         showConfirmation: function() {
                var defer = $q.defer();
                

  swal({

      title: "{{getPhrase('are_you_sure')}}?",

      type: "warning",

      showCancelButton: true,

      confirmButtonClass: "btn-danger",

      confirmButtonText: "{{getPhrase('yes').', '.getPhrase('delete_it')}}!",

      cancelButtonText: "{{getPhrase('no').', '.getPhrase('cancel_please')}}!",

      closeOnConfirm: true,

      closeOnCancel: false

    },

    function(isConfirm) {
      
      if (isConfirm) { 
       
       
      defer.resolve(1);

      } else {
       
        swal("{{getPhrase('cancelled')}}", "{{getPhrase('your_record_is_safe')}} :)", "error");
         
          defer.resolve(0);
      }

  });
  return defer.promise;
  },
    webServiceCallPost1: function(url, data) {
          var deferred = $q.defer();
               return $.ajax({
                   type: "POST",
                   url: url,
                   crossDomain: true,
                   dataType: "json",
                   data: data,
                   timeout: 2000000,
                   async: true,
                   success: function(response) {
                       console.log("response    "+JSON.stringify(response));
                       deferred.resolve();
                   },
                   error: function(xhr, ajaxOptions, thrownError) {
                       
                       if (xhr.status == 0) {
                           
                       } else if (xhr.status == 404) {
                           
                       } else {
                           
                       }
                   },
                   beforeSend: function() {},
                   complete: function() {}
               });
           
       }
     }

});
</script>