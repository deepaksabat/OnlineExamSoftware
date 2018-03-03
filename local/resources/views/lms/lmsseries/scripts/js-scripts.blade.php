<script src="{{JS}}angular.js"></script>
 <script src="{{JS}}ngStorage.js"></script>
<script src="{{JS}}angular-messages.js"></script>

<script >
  var app = angular.module('academia', ['ngMessages']);
</script>
@include('common.angular-factory',array('load_module'=> FALSE))

<script>
app.controller('prepareQuestions', function( $scope, $http, httpPreConfig) {
   $scope.savedItems = [];
   $scope.savedSeries =  [];
   $scope.total_items = 0;
   
    $scope.initAngData = function(data) {
        
        if(data === undefined)
            return;
        $scope.removeAll();
    
        if(data=='')
        {
            $scope.series   = [];
            return;
        }

        dta = data;
        $scope.savedSeries = dta.contents;
        $scope.setItem('saved_series', $scope.savedSeries);
        $scope.setItem('total_items', $scope.total_items);
    }
    
     $scope.categoryChanged = function(selected_number) {
        
        if(selected_number=='')
            selected_number = $scope.category_id;
        category_id = selected_number;
        if(category_id === undefined)
            return;
        route = '{{URL_LMS_SERIES_GET_SERIES}}';  
        data= {_method: 'post', '_token':httpPreConfig.getToken(), 'category_id': category_id};
       
            httpPreConfig.webServiceCallPost(route, data).then(function(result){
            result = result.data;
            $scope.categoryItems = [];
            $scope.categoryItems = result.items;
            $scope.removeDuplicates();
        });
        }

        $scope.removeDuplicates = function(){
           
            if($scope.savedSeries.length<=0 )
                return;

             angular.forEach($scope.savedSeries,function(value,key){
                    
                    res = httpPreConfig.findIndexInData($scope.categoryItems, 'id', value.id);
                    if(res >= 0)
                    {
                         $scope.categoryItems.splice(res, 1);
                    }
                    
            });
        }
          
        $scope.addToBag = function(item) {
            
           var record = item; 
            
              res = httpPreConfig.findIndexInData($scope.savedSeries, 'id', item.id);
                    if(res == -1) {
                      $scope.savedSeries.push(record); 
                      
                      $scope.removeFromCategoryItems(item);
                    }
                  else 
                    return;

           //Push record to storage
            $scope.setItem('saved_series', $scope.savedSeries);
        }

        $scope.removeFromCategoryItems = function(item) { 
             var index = $scope.categoryItems.indexOf(item);
             $scope.categoryItems.splice(index, 1);     
        }

        $scope.addToCategoryItems = function(item) { 
          
             if($scope.categoryItems.length) {
                
                if($scope.categoryItems[0].subject_id != item.subject_id)
                    return;

                 res = httpPreConfig.findIndexInData($scope.savedSeries, 'id', item.id)
                
                    if(res == -1)
                      $scope.categoryItems.push(item);     
                return;
             }
             $scope.categoryChanged($scope.category_id);
        }


        /**
         * Set item to local storage with the sent key and value
         * @param {[type]} $key   [localstorage key]
         * @param {[type]} $value [value]
         */
        $scope.setItem = function($key, $value){
            localStorage.setItem($key, JSON.stringify($value));
        }

        /**
         * Get item from local storage with the specified key
         * @param  {[type]} $key [localstorage key]
         * @return {[type]}      [description]
         */
        $scope.getItem = function($key){
            return JSON.parse(localStorage.getItem($key));
        }

        /**
         * Remove question with the sent id
         * @param  {[type]} id [description]
         * @return {[type]}    [description]
         */
         

    $scope.removeItem = function(record){
        
          $scope.savedSeries = $scope.savedSeries.filter(function(element){
            if(element.id != record.id)
              return element;
          });
           
          $scope.setItem('saved_series', $scope.savedSeries);
          $scope.addToCategoryItems(record);
        }

        $scope.removeAll = function(){
            $scope.savedSeries = [];
            $scope.totalQuestions       = 0;
            $scope.setItem('saved_questions', $scope.savedSeries);
            $scope.setItem('total_questions', $scope.totalQuestions);
            $scope.categoryChanged($scope.category_id);
        }
 
    

}  );

app.filter('cut', function () {
        return function (value, wordwise, max, tail) {
            if (!value) return '';

            max = parseInt(max, 10);
            if (!max) return value;
            if (value.length <= max) return value;

            value = value.substr(0, max);
            if (wordwise) {
                var lastspace = value.lastIndexOf(' ');
                if (lastspace != -1) {
                  //Also remove . and , so its gives a cleaner result.
                  if (value.charAt(lastspace-1) == '.' || value.charAt(lastspace-1) == ',') {
                    lastspace = lastspace - 1;
                  }
                  value = value.substr(0, lastspace);
                }
            }

            return value + (tail || ' …');
        };
    });

 
</script>