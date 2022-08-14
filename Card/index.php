<html>
    <head>
    <title>Login</title>
    <link rel="icon" href="logoMT.png">
    <link rel='stylesheet' href='login.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <body>
        <div class="main">
            <div class="logo" id="logosite">
                <a href="index.php"><img src="logoMT.png" alt="Card Logo" height="150" width="150"></a>
            </div>
            <div class="header">
                <h4>Cartes Portable !</h4>
            </div>
            <div class="blanc"></div>
            <!-- <div class="green"></div>
            <div class="green2"></div> -->
            <div class="my_buttonindex">
                <form action="login.php" method="get">
                    <button id="login" class="loginbutton">Login</button>
                </form>
                <form action="signin.php" method="get">
                    <button id="signin" class="loginbutton">Sign In</button>
                </form>
            </div>
        </div>
    </body>
</html>