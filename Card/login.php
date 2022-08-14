<html>
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='login.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <div class="mainlogin">
      <div class="logo"><a href="index.php"><img class="logo" src="logoMT.png" alt="Card Logo"></a>
      </div>
      <div class="header">
        <h4>Login</h4>
      </div>
      <div class="blanc"></div>
      <div class="enter">
          <input class='input_field' id='idplayerlogin' type='text' placeholder='Entrer vôtre Identifiant :' minlength='3' required' />
      </div>
      <div class="buttonlogin">
          <button id='login' class="login">Login<br></button>
      </div>
    </div>
  </body>
</html>