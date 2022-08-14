<html>
  <head>
    <title>Sign in</title>
    <link rel='stylesheet' href='login.css'>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  </head>
  <body>
    <div class="mainsignin">
      <div class="logo"><a href="index.php"><img class="logo" src="logoMT.png" alt="Card Logo"></a>
      </div>
      <div class="header">
        <h4>Sign In</h4>
      </div>
      <div class="blanc"></div>
      <input type="hidden" id="chooselogo" value="">
      <div class="signin_box">
          <input class='input_field' id='username' type='text' placeholder='Enter an username:' minlength='3' required' />
          <div id="select">
            <div>
             <img id="pug1" value="./logo/pug1.jpg" src="./logo/pug1.jpg"/>
            </div>
            <div>
             <img id="pug2" value="./logo/pug2.jpg" src="./logo/pug2.jpg">
            </div>
            <div >
             <img id="pug3" value="./logo/pug3.jpg" src="./logo/pug3.jpg">
            </div>
            <div>
              <img id="pug4" value="./logo/pug4.jpg" src="./logo/pug4.jpg">
             </div>
             <div>
              <img id="pug5" value="./logo/pug5.jpg" src="./logo/pug5.jpg">
             </div>
             <div >
              <img id="pug6" value="./logo/pug6.jpg" src="./logo/pug6.jpg">
             </div>
         </div>
      </div>
      <div class="my_button">
          <button id='send' class='login'>Sign In<br></button>
        </div>
    </div>
  </body>
</html>