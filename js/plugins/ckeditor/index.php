<!DOCTYPE html>
<html>
    <head>
        <title>404 Page Not Found</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
                font-family: arial;
                color: #aaa;
            }
            .title {
                font-size: 50px;
                font-weight: 400;
                font-family: arial;
                margin:0;
                color: #333;
            }
            .content p{
font-size: 20px;
            }
            .content hr{
                max-width: 300px;
                margin: 30px auto;
            }
            .content .btn{border-radius: 3px; transition: all .3s ease;
                background: #44a1ef;text-decoration: none; color: #fff; font-size: 13px; font-weight: 400; display: inline-block; padding:15px 20px;}
                .content .btn:focus, .content .btn:hover{background: #3290de;}
                .content .btn:focus:active, .content .btn:focus:hover{background: #1074c7;}
            @media(min-width: 600px) {
                 .title {
                font-size: 250px;
                line-height: 200px;
            }
            }
            
        </style>
    </head>
    <body>
    <?php 
        $base = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
		$path = explode('/',str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME'])); 
        $base .= '://'.$_SERVER['HTTP_HOST'].'/'.$path[1].'/';
		
    ?>
        <div class="container">
            <div class="page-note-found text-center content">
            <h1 class="title">404</h1>
            <p>We can't find the page you're looking for.</p>
            <hr>
            <a href="<?php echo $base;?>" class="btn btn-primary">HOME PAGE</a>
            </div>
        </div>
    </body>
</html>
