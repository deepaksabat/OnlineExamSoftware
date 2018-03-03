<script src="{{JS}}angular.js"></script>
 <script src="{{JS}}ngStorage.js"></script>
<script src="{{JS}}angular-messages.js"></script>


<script >
  var app = angular.module('academia', ['ngMessages']);
</script>

@include('common.angular-factory',array('load_module'=> FALSE))


<script>
 
app.controller('prepareQuestions', function( $scope, $http, httpPreConfig) {
   $scope.savedQuestions = [];
    
   
    $scope.savedQuestions =  [];
    $scope.totalMarks = 0;
   
    $scope.initAngData = function(data) {
        
        if(data === undefined)
            return;
        $scope.removeAll();
        $scope.totalMarks       = 0;
        if(data=='')
        {
            $scope.subjectQuestions = [];
            $scope.subject          = null;
            return;
        }

        dta = data;
        $scope.savedQuestions = dta.questions;
        $scope.totalMarks = parseInt(dta.total_marks);
        $scope.setItem('saved_questions', $scope.savedQuestions);
        $scope.setItem('total_marks', $scope.total_marks);
 
    }
    
     $scope.subjectChanged = function(selected_number) {
         
        if(selected_number=='')
            selected_number = $scope.subject_id;
        subject_id = selected_number;
        if(subject_id === undefined)
            return;
        route = '{{URL_QUIZ_GET_QUESTIONS}}';  
        data= {_method: 'post', '_token':httpPreConfig.getToken(), 'subject_id': subject_id};
         $scope.topics =[];
          httpPreConfig.webServiceCallPost(route, data).then(function(result){
            result = result.data;
          
         
           $scope.subjectQuestions = [];
           $scope.subject   = result.subject;
           $scope.topics    = result.topics; 
           $scope.topic     = $scope.topics[0];
           $scope.subjectQuestions = result.questions;
 
            $scope.contentAvailable = true;

           $scope.removeDuplicates();
        
        });
        }

        $scope.removeDuplicates = function(){
           
            if($scope.savedQuestions.length<=0 || $scope.subjectQuestions.length<=0)
                return;

             angular.forEach($scope.savedQuestions,function(value,key){
                    if(value.subject_id != $scope.subjectQuestions[0].subject_id)
                        return;

                    res = httpPreConfig.findIndexInData($scope.subjectQuestions, 'id', value.question_id);
                    if(res >= 0)
                    {
                         $scope.subjectQuestions.splice(res, 1);
                    }
                    
            });
        }
          
        $scope.addQuestion = function(question, subject) {
           
           var record = {}; 
            record.id            = Date.now();
            record.subject_id    = subject.id;
            record.question_id   = question.id;
            record.marks         = question.marks;
            record.topic_id      = question.topic_id;
            record.question      = question.question;
            record.subject_title = subject.subject_title;
            record.question_type = question.question_type;
            record.difficulty_level = question.difficulty_level;
           

              res = httpPreConfig.findIndexInData($scope.savedQuestions, 'question_id', question.id);
                    if(res == -1) {
                      $scope.savedQuestions.push(record);  
                      $scope.removeFromSubjectQuestions(question);
                    }
                  else 
                    return;
           
           $scope.totalMarks = parseInt($scope.totalMarks) + parseInt(question.marks);
           //Push record to storage
            $scope.setItem('saved_questions', $scope.savedQuestions);
            $scope.setItem('total_marks', $scope.totalMarks);

            
           
        }

        $scope.removeFromSubjectQuestions = function(item) { 
             var index = $scope.subjectQuestions.indexOf(item);
             $scope.subjectQuestions.splice(index, 1);     
        }
 
        $scope.addToSubjectQuestions = function(item) { 
           
             if($scope.subjectQuestions.length) {
                if($scope.subjectQuestions[0].subject_id==item.subject_id) {
                    res = httpPreConfig.findIndexInData($scope.subjectQuestions, 'id', item.question_id)
                    if(res == -1)
                      $scope.subjectQuestions.push(item);     
                }
             }
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
         

    $scope.removeQuestion = function(record){
        
          $scope.savedQuestions = $scope.savedQuestions.filter(function(element){
            if(element.id != record.id)
              return element;
          });
           $scope.totalMarks = $scope.totalMarks - record.marks;
          $scope.setItem('saved_questions', $scope.savedQuestions);
          $scope.addToSubjectQuestions(record);
        }

        $scope.removeAll = function(){
            $scope.savedQuestions = [];
            $scope.totalMarks       = 0;
            $scope.setItem('saved_questions', $scope.savedQuestions);
            $scope.setItem('total_marks', $scope.total_marks);
            $scope.subjectChanged($scope.subject_id);
  
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

app.filter('searchTopic',function(){
    return function(items,topic){
        var result=[];
        if(topic && items.length>0){
            angular.forEach(items,function(value,key){
            if(topic.id==value.topic_id){
                result.push(value);
            }   
        });
        }
        return result;
    }

});

app.filter('searchQuestion',function(){
    
    return function(item){
    questions =  JSON.parse(localStorage.getItem('saved_questions'));;
    
        var result=[];
        if(questions == 'undefined' || questions == null)
            return item;

            angular.forEach(questions, function(value,key){
            if(item.id != value.question_id){
                result.push(item);
            }   
        });
        
        return result;
    }

 });

 
</script>