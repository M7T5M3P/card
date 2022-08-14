<html>
    <meta charset="UTF-8">
    <head>
    <title>Login</title>
    <link rel='stylesheet' href='login.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>
        <div class="mainchoose">
            <div class="logo">
                <a href="index.php"><img class="logo" src="logoMT.png" alt="Card Logo" height="150" width="150"></a>
            </div>
            <div class="header">
                <h4>Là tu dois faire un choix</h4>
            </div>
            <div class="blanc"></div>
            <div class="my_button">
                <form action="createroom.php" method="get">
                    <button id="login" class="login">Créer un salon</button>
                </form>
                <form action="joinroom.php" method="get">
                    <button id="signin" class="login">Rejoindre un salon</button>
                </form>
            </div>
        </div>
    </body>
</html>