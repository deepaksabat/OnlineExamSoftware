<script src="{{JS}}angular.js"></script>

 <script src="{{JS}}angular-messages.js"></script>



<script>

var app = angular.module('academia', ['ngMessages']);

app.controller('couponsController', function( $scope, $http) {

    

    $scope.intilizeData = function(data){

       

        $scope.ngdiscount = 0;

        $scope.ngtotal = {{$item->cost}};

         $scope.isApplied = false;

        return;

    }

     /**
      * This method will validate the coupon code
      * @param  {[type]} item_name  Name of the item purchasing
      * @param  {[type]} item_type  Item type like lms,combo,quiz
      * @param  {[type]} cost       Cost of the item
      * @param  {[type]} student_id if parent is purchasing, the student_id is non-zero
      * @return {[type]}            [description]
      */
     $scope.validateCoupon = function(item_name, item_type, cost, student_id) {



        coupon_code = $scope.coupon_code;

        

        if(coupon_code === undefined || coupon_code=='')

            return;
          updated_student_id = student_id;
          //Update the student id i.e., the parent may change his selection
        if(student_id!=0)
            updated_student_id =  $('#selected_child_id').val();



        route = '{{URL_COUPONS_VALIDATE}}';  

        data= {

                '_method': 'post', 

                '_token':$scope.getToken(), 

                'coupon_code': coupon_code, 

                'item_name': item_name,

                'item_type': item_type,

                'cost'     : cost,
                'student_id'     : updated_student_id

               };

         

        $http.post(route, data).success(function(result, status) {

           if(result.status==0) {



               alertify.error(result.message);

               return;

            }

            else{
             
              if(updated_student_id!=0) {
                $('#childrens_list_div').fadeOut(100);
              }

                $scope.isApplied        = true;

                $scope.ngdiscount       = result.discount;

                $scope.discount_availed = result.discount;

                $scope.ngtotal          = result.amount_to_pay;

                $('#is_coupon_applied').val('1');

                $('#discount_availed').val(result.discount);

                $('#after_discount').val(result.amount_to_pay);

                $('#coupon_id').val(result.coupon_id);

                alertify.success(result.message);

                return;

            }



        });

        }





     /**

     * Returns the token by fetching if from from form

     */

    $scope.getToken = function(){

      return  $('[name="_token"]').val();

    }



 });

</script>



{{-- <script>

$(document).ready(function(){

    $('[data-toggle="tooltip"]').tooltip(); 

});

</script> --}}