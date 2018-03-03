  

  <link rel="stylesheet" href="{{CSS}}alertify/themes/alertify.core.css" >

  <link rel="stylesheet" href="{{CSS}}alertify/themes/alertify.default.css" id="toggleCSS" >



 <script src="{{JS}}alertify.js"></script>

 {{-- @include('common.alertify') --}}

 <script src="https://js.pusher.com/3.2/pusher.min.js"></script>

  <script>



    // Enable pusher logging - don't include this in production

     Pusher.logToConsole = true;

    <?php $pusher_key = getSetting('pusher_key','push_notifications'); ?>

    {{-- var pusher = new Pusher('{{env('PUSHER_KEY')}}',  --}}

    var pusher = new Pusher('{{$pusher_key}}', 

    {

      encrypted: true

    });



    // var channel = pusher.subscribe('{{getRoleData(Auth::user()->role_id)}}');
    var channel = pusher.subscribe('admin');



    channel.bind('newUser', function(data) {

      // console.log(data);

      // htmldata =  '<div class="dropdown-menu-notif-item">'

      //                 +'<div class="photo">'

      //                   +'<img src="'+data.image+'" alt="">'

      //                 +'</div>'

      //                  +'<a href="/users/details/'+data.slug+'">'+data.name+'</a>'  

      //                  +'was joined as '+data.role

      //                 +'<div class="color-blue-grey-lighter">just now</div>'

      //               +'</div>';

     // $('#latestUsers').prepend(htmldata);

      alertify.success("Hi Admin,</br>New Student Joined" );
       

    });



    

  </script>