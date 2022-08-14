<html> 
  <head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel='stylesheet' href='login.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='http://<?php $path = parse_ini_file("login.ini"); echo $path["servername"]; ?>/Card/signin.js'></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  </head>
  <body>
    <div class="maincard">
      <div class="logo">
        <a href="index.php"><img class="logo" src="logoMT.png" alt="Card Logo" height="150" width="150"></a>
      </div>
      <div class="header">
        Mise en place du jeu
      </div>
      <div class="blanc"></div>
      <div class="card">
        <h4>Jeu de carte :</h4>
        <label>Carte du jeu : </label>
        <input type="text" id="cardadd" value="1,2,3,4,5,6,7,8,9,10,V,D,R,J">
        <label>Carte a retirer : </label>
        <input type="text" id="cardremove">
        <button class="info" id="infocardforgame" type="button"><i class="fa fa-info"></i></button>
        <label>Nom du jeu : </label>
        <input type="text" id="namegame">
      </div>
      <div class="cnbcardhand">
        <h4>Deroulement manche:</h4>
        <label for="quantity">Nombre de joueur max:</label>
        <input type="number" id="nbplayer" min="1" max="14">
        <label for="quantity">Nombre de carte par joueur:</label>
        <input type="number" id="nbcardhand" min="-1" max="13">
        <button class="info" id="infocardhand" type="button"><i class="fa fa-info"></i></button>
        <label for="quantity">Tour par tour :</label>
        <input type="checkbox" id="checktourpartour">
        <button class="info" id="infotour" type="button"><i class="fa fa-info"></i></button>
        <label for="quantity">Carte passable :</label>
        <input type="checkbox" id="givecard">
        <button class="info" id="infopasscard" type="button"><i class="fa fa-info"></i></button>
      </div>
      <div class="tableau">
        <h4>Tableau (pioche):</h4>
        <label for="quantity">Nombre de carte dans la pioche :</label>
        <input type="number" id="nbcardpioche" min="0" max="5">
        <label for="quantity">Nombre de carte visible (0 à 5) :</label>
        <input type="number" id="nbvisiblecardpioche" min="0" max="5">
        <label for="quantity">Re distribution automatique :</label>
        <input type="checkbox" id="automatiquecard">
        <button class="info" id="infoautomatiquecard" type="button"><i class="fa fa-info"></i></button>
      </div>
      <div class="tapis">
        <h4>Tapis (defausse):</h4>
        <label for="quantity">Nombre de carte jouable par tour (max):</label>
        <input type="number" id="nbtrash" min="1">
        <button class="info" id="infonbcartesdefaussable" type="button"><i class="fa fa-info"></i></button>
        <label for="quantity">Carte récuperable :</label>
        <input type="checkbox" id="checkgetcardtapis">
        <button class="info" id="infocheckgetcardtapis" type="button"><i class="fa fa-info"></i></button>
      </div>
      <div class="login">
        <button id='create' >Create room</button>
      </div>
    </div>
  </body>
</html>