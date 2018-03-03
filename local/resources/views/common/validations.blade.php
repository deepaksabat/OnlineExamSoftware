 @if(!isset($isLoaded))
   <script src="{{JS}}angular.js"></script>
    <script src="{{JS}}angular-messages.js"></script> 
@endif

    <script >

    @if(!isset($isLoaded))
    	 app = angular.module('academia', ['ngMessages']);
    @endif
        app.directive('stringToNumber', function() {
          return {
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
              ngModel.$parsers.push(function(value) {
                return '' + value;
              });
              ngModel.$formatters.push(function(value) {
                return parseFloat(value);
              });
            }
          };
        });
    	app.directive('input', function ($parse) {
		  return {
		    restrict: 'E',
		    multiElement: true,
		    require: '?ngModel',
		    link: function (scope, element, attrs) {
			 e = element[0];
 
            if (attrs.ngModel && attrs.value) {
		        $parse(attrs.ngModel).assign(scope, attrs.value);
		      }
		    }
		  };
		});

    	app.directive('textarea', function ($parse) {
		  return {
		    restrict: 'E',
		    multiElement: true,
		    require: '?ngModel',
		    link: function (scope, element, attrs) {
		    	e = element[0];
			 // console.log(element[0].value);
		      if (attrs.ngModel && e.value) {
		        $parse(attrs.ngModel).assign(scope, e.value);
		      }
		    }
		  };
		});
    	app.directive('select', function ($parse) {
		  return {
		    restrict: 'E',
		    multiElement: true,
		    require: '?ngModel',
		    link: function (scope, element, attrs) {
		    	e = element[0];
		    	selectedValue = e.options[e.selectedIndex].value;
		    	// console.log(selectedValue);
		      if (attrs.ngModel && selectedValue) {
		        $parse(attrs.ngModel).assign(scope, selectedValue);
		      }
		    }
		  };
		});

/**
 * PASSWORD AND CONFIRM PASSWORD FIELDS VALIDATION DIRECTIVE
 * @return {[type]} [description]
 */
		var compareTo = function() {
    return {
        require: "ngModel",
        scope: {
            otherModelValue: "=compareTo"
        },
        link: function(scope, element, attributes, ngModel) {

            ngModel.$validators.compareTo = function(modelValue) {
                return modelValue == scope.otherModelValue;
            };

            scope.$watch("otherModelValue", function() {
                ngModel.$validate();
            	});
        	}
    	};
	};

app.directive("compareTo", compareTo);

/**
 * FILE VALIDATION DIRECTIVES BEFORE UPLOAD
 */

var validImage = function($rootScope) {
	var validFormats = ['jpg', 'png', 'jpeg'];
 return {
        require: "ngModel",
        scope: {
            otherModelValue: "=validImage"
        },
        link: function(scope, element, attributes, ngModel) {
        	$rootScope.isImageValid = 'true';
        	// console.log(element);
            ngModel.$validators.validImage = function(modelValue) {

               element.on('change', function () {
               	
               	// e = element[0];
               	// fileObject = $.parseJSON(e.files);
                // console.log(e.files);
                 file_size = this.files[0].size;
                 console.log(file_size);
                 valid_size = true;
                
                   var value = element.val(),
                       ext = value.substring(value.lastIndexOf('.') + 1).toLowerCase();   
                     console.log(validFormats.indexOf(ext) !== -1);
                     $rootScope.isImageValid = validFormats.indexOf(ext) !== -1;
                     $rootScope.$apply();
                     console.log( " $rootScope.isImageValid   "+$rootScope.isImageValid);
                    if(file_size > 2000000){
                    	 
                 		return false;
                 	}
                 	else{
                 		 return validFormats.indexOf(ext) !== -1 ;
                 	}
                });
            };

          
        	}
    	};
	};
app.directive("validImage", validImage);
    </script>