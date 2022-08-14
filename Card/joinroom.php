<html>
  <head>
    <title>Login</title>
    <link rel='stylesheet' href='login.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div class="mainjoin">
      <div class="logo">
        <a href="index.php"><img class="logo" src="logoMT.png" alt="Card Logo" height="150" width="150"></a>
      </div>
      <div class="header">
        <h4>Rejoindre un salon</h4>
      </div>
      <div class="blanc"></div>
      <div class="joinroom">
          <input id='roomid' class='input_field' type='text' placeholder='Entrer la clef du salon:' minlength='3' required' />
      </div>
      <div class="my_button">
        <button id='join' class='login'>Aller c'est parti<br></button>
      </div>
    </div>
  </body>
</html>