<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Card {
    public $valuevisible;
    public $value;
    public $color;
    public $url;
    public $css;
    public $idcard;

    function __construct($id) {
        $result = $this->init_card($id);
        $this->idcard = $result['Id'];
        $this->value = $result['Value'];
        $this->color = $result['Color'];
        $this->valuevisible = $result['namecard'];
    }
    function init_card($id) {
        $conn = $this->get_connection();
        $sql = "SELECT * FROM card WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param( "i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $conn->close();
        return $result->fetch_assoc();
    }
    function display()
    {
        switch ($this->color) {
            case "diamond":
                $card_color = "&diamondsuit;";
                break;
            case "heart":
                $card_color = "&heartsuit;";
                break;
            case "spade":
                $card_color = "&spadesuit;";
                break;
            case "club":
                $card_color = "&clubs;";
                break;
            case "jr":
                $card_color = "";
                break;
            case "jb":
                $card_color = "";
                break;
        }
        return "<div class='card'>
                    <input type='hidden' value=".$this->idcard.">
                    <div class='".$this->color." top'>
                        ".$card_color."
                    </div>
                    <div class='".$this->color." middle'>
                        ".$this->valuevisible."
                    </div>
                    <div class='".$this->color." bot'>
                        ".$card_color."
                    </div>
                </div>";
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class Pagehtml {
    public $name_event;
    public $body;
    public $player;

    function __construct($nameevent, $bod) {
        $this->name_event = $nameevent;
        $this->body = $bod;
    }
    function display() {
        $my_css = new Css($this->name_event);
        return "<html>
                <head>
                    <link rel='shortcut icon' href='logoMT.png'/>
                    <link rel='stylesheet' href='card.css'>
                    <title>Card</title>
                    <script src='./jquery.min.js'></script>
                    <script src='./signin.js'></script>
                    ".$my_css->display()."
                </head>
                <body>
                    <button id='startgame' class='startgame'>Start Game<br></button>
                    <button id='cleartapis' class='cleartapis'>Clear tapis<br></button>
                    ".$this->body."
                </body>
        </html>";
    }
}

class Css {
    public $event;

    function __construct($name_event) {
        $this->event = $name_event;
    }
    function display()
    {
        $output = "<style>";
        $conn = $this->get_connection();
        $result = $this->get_param();
        for ($i = 0; $i < sizeof($result); $i++) {
            $output .= ".".$result[$i][1]."{";
            $output .= $result[$i][2];
            $output .= "}";
       }     
       $output .= "</style>";   
       return $output;
    }
    function get_param()
    {
        $conn = $this->get_connection();
        $sql = "SELECT * FROM `css` WHERE eventcss='".$this->event."'";
        $result = $conn->query($sql);
        $output = $result->fetch_all();
        $conn->close();
        return $output;
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class Deck {
    public $deck_card = [];
    public $connection;
    public $iddeck;

    function __construct($iddecks) {
        $this->iddeck = $iddecks;
        $result = $this->init_deck($this->iddeck);
        for ($i = 0; $i < sizeof($result); $i++) {
            array_push($this->deck_card , new Card($result[$i][0]));
        }
    }
    function display()
    {
        $output = "<div class='deck'>";
        for ($i = 0; $i < sizeof($this->deck_card); $i++) {
            $output .= $this->deck_card[$i]->display();
        }
        $output .= "</div>";
        return $output;
    }
    function init_deck() {
        $conn = $this->get_connection();
        $request = $this->get_sql($this->get_param());
        $result = $conn->query($request);
        $output = $result->fetch_all();
        $conn->close();
        return $output;
    }
    function get_sql($tab)
    {
        $sql = $tab[0][3];
        return $sql;
    }
    function get_name($tab)
    {
        $sql = $tab[0][2];
        return $sql;
    }
    function get_css($tab)
    {
        $sql = $tab[0][4];
        return $sql;
    }
    function get_param()
    {
        $conn = $this->get_connection();
        $sql = "SELECT * FROM `deck` WHERE Id=".$this->iddeck;
        $result = $conn->query($sql);
        $output = $result->fetch_all();
        $conn->close();
        return $output;
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class Player {
    public $id;
    public $username;
    public $logo;
    public $idroom;
    public $hand;
    public $trash;
    public $handsid;
    public $trashsid;
    public $tapis;

    function __construct($keyroom, $id, string $username = null, string $logo = null) {
        $this->idroom = $keyroom;
        $this->trash = new ensemblecartes("trash");
        $this->hand = new ensemblecartes("hand");
        $this->tapis = new ensemblecartes("tapis");
        if ($id != null) {
            $result = $this->get_player($id);
            $this->id = $result[0][0];
            $this->username = $result[0][1];
            $this->logo = $result[0][2];
            $this->handsid = $result[0][3];
            $this->trashsid = $result[0][4];
        } else {
            $conn = $this->get_connection();
            $sql = "SELECT MAX(Id) as max FROM player";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id = $row['max'] + 1;
            $sql = "INSERT INTO `player`(`Id`, `Username`, `Logo`) VALUES (".$id.",'".$username."','".$logo."')";
            $conn->query($sql);
            $this->id = $id;
            $this->username = $username;
            $this->logo = $logo;
            $conn->close();
        }
    }
    function start()
    {
        $conn = $this->get_connection();
        $sql = "UPDATE `player` SET `hand`='' WHERE 1";
        $conn->query($sql);
        $sql = "UPDATE `player` SET `trash`='' WHERE 1";
        $conn->query($sql);
        $sql = "UPDATE `room` SET `tapis`='' WHERE 1";
        $conn->query($sql);
        $sql = "UPDATE `room` SET `pioche`='' WHERE 1";
        $conn->query($sql);
        $conn->close();
    }
    function add_to_hand($objcard)
    {
        $this->hand->add_to_set($objcard);
        $conn = $this->get_connection();
        $sql = "UPDATE `player` SET `hand`=concat(hand,'".$objcard->idcard.",') WHERE `Id`='".$this->id."'";
        $conn->query($sql);
        $conn->close();
    }
    function add_to_trash($objcard)
    {
        $this->trash->add_to_set($objcard);
        $conn = $this->get_connection();
        $sql = "UPDATE `player` SET `trash`=concat(trash,'".$objcard->idcard.",') WHERE `Id`='".$this->id."'";
        $conn->query($sql);
        $conn->close();
    }
    function add_to_tapis($objcard, $idroom)
    {
        $this->tapis->add_to_set($objcard);
        $conn = $this->get_connection();
        $sql = "UPDATE `room` SET `tapis`=concat(tapis,'".$objcard->idcard.",') WHERE `Id`='".$idroom."'";
        $conn->query($sql);
        $conn->close();
    }
    function display()
    {
        return $output = "<div class='player'>
                        <div class='id'>
                            Id : ".$this->id."
                        </div>
                        <div class='idroom'>
                           Idroom : ".$this->idroom."
                        </div>
                        <div class='username'>
                           Username : ".$this->username."
                        </div>
                        <img src=".$this->logo." alt='Logo' width='150' height=''/>
                   </div>";
    }
    function get_player($id)
    {
        $conn = $this->get_connection();
        $sql = "SELECT * FROM `player` WHERE Id = ".$id."";
        $result = $conn->query($sql);
        $output = $result->fetch_all();
        $conn->close();
        return $output;
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class Room {
    public $players=[];
    public $roomid;
    public $deck;
    public $nbcards;
    public $nbcardpioche;
    public $pioche;
    public $me;
    public $pagehtml;

    function __construct(?string $id = null, $carddeck, ?int $idplayer = 0, ?int $nbcard = 0, ?int $nbcardpioches = 0, ?int $nbvcard = 0) {
        $this->nbcards = $nbcard;
        $this->deck = $carddeck;
        $this->nbcardpioche = $nbcardpioches;
        if ($id == null) {
            $this->roomid = $this->generate_roomid();
            $conn = $this->get_connection();
            $sql = "INSERT INTO `room`(`Id`, `idplayers`, `namedeck`) VALUES ('".$this->roomid."','', ".$carddeck.")";
            $conn->query($sql);
            $this->players = $this->get_idplayers();
        } else {
            $this->roomid = $id;
            $this->players = $this->get_idplayers();
            $this->me = new Player($id, $idplayer);
            $cardpioche = $this->create_pioche();
            $this->pioche = new ensemblecartes("pioche", $cardpioche);
            $cardhand = $this->create_hand($idplayer);
            $this->me->hand = new ensemblecartes("hand", $cardhand);
            $cardtrash = $this->create_trash($idplayer);
            $this->me->trash = new ensemblecartes("trash", $cardtrash);
            $cardtapis = $this->create_tapis();
            $this->me->tapis = new ensemblecartes("tapis", $cardtapis);
            $pagehtmltmp = new Pagehtml("default", $this->display($nbvcard));
            $this->pagehtml = $pagehtmltmp->display();
        }
    }
    function clear_my_tapis()
    {
        $conn = $this->get_connection();
        $sql = "UPDATE `room` SET `tapis`='' WHERE 1";
        $conn->query($sql);
        $conn->close();
        $this->me->tapis = null;
    }
    function create_pioche()
    {
        $conn = $this->get_connection();
        $sql = "SELECT pioche FROM room WHERE Id='".$this->roomid."'";
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $conn->close();
        
        $str_arr = preg_split("/\,/", $output['pioche']);
        $tmp = [];
        for ($i = 0; $i < sizeof($str_arr) - 1; $i++) {
            array_push($tmp , new Card($str_arr[$i]));
        }
        return $tmp;
    }
    function create_trash($id)
    {
        $conn = $this->get_connection();
        $sql = "SELECT trash FROM player WHERE Id=".$id;
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $conn->close();
        
        $str_arr = preg_split("/\,/", $output['trash']);
        $tmp = [];
        for ($i = 0; $i < sizeof($str_arr) - 1; $i++) {
            array_push($tmp , new Card($str_arr[$i]));
        }
        return $tmp;
    }
    function create_hand($idplayer)
    {
        $conn = $this->get_connection();
        $sql = "SELECT hand FROM player WHERE Id=".$idplayer;
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $conn->close();
        $str_arr = preg_split("/\,/", $output['hand']);
        $tmp = [];
        for ($i = 0; $i < sizeof($str_arr) - 1; $i++) {
            array_push($tmp , new Card($str_arr[$i]));
        }
        return $tmp;
    }
    function create_tapis()
    {
        $conn = $this->get_connection();
        $sql = "SELECT tapis FROM room WHERE Id='".$this->roomid."'";
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $conn->close();
        $str_arr = preg_split("/\,/", $output['tapis']);
        $tmp = [];
        for ($i = 0; $i < sizeof($str_arr) - 1; $i++) {
            array_push($tmp , new Card($str_arr[$i]));
        }
        return $tmp;
    }
    function start_game()
    {
        $this->me->start();
        $this->me->hand->start();
        $this->me->tapis->start();
        $this->me->trash->start();
        $this->pioche->start();
        $this->distributecards();
    }
    function generate_roomid()
    {
        $t = chr(rand(65,90));
        $t .= chr(rand(65,90));
        $t .= chr(rand(97,122));
        $t .= chr(rand(65,90));
        $t .= chr(rand(65,90));
        $t .= chr(rand(97,122));
        return $t;
    }
    function distributecards()
    {
        $deckcards = [];
        $objdeckcard = [];

        for ($i = 0; $i < sizeof($this->deck->deck_card); $i++) {
            array_push($deckcards, $this->deck->deck_card[$i]->idcard);
        }
        shuffle($deckcards);
        for ($x = 0; $x < sizeof($deckcards); $x++) {
            for ($i = 0; $i < sizeof($this->deck->deck_card); $i++) {
                if ($deckcards[$x] == $this->deck->deck_card[$i]->idcard) {
                    array_push($objdeckcard, $this->deck->deck_card[$i]);
                    continue;
                }
            }
        }
        $tmpplayer = [];
        $nbplayer = sizeof($this->players) - 1;
        for ($i = 0; $i < $nbplayer;  $i++) {
            if ($this->players[$i] != $this->me->id) { 
                $my_player = new Player($this->roomid, $this->players[$i]);
                array_push($tmpplayer, $my_player);
            } else {
                array_push($tmpplayer, $this->me);
            }
        }
        if ($this->nbcards == -1) {
            for ($i = 0; $i < sizeof($deckcards) - 1; $i++) {
                $tmpplayer[($i % $nbplayer)]->add_to_hand($objdeckcard[$i]);
            }
            $objdeckcard = null;
            $deckcards = [];
        } else {
            for ($i = 0; $i < ($this->nbcards * $nbplayer); $i++) {
                $tmpplayer[($i % $nbplayer)]->add_to_hand($objdeckcard[$i]);
                $deckcards[$i] = -2;
                $objdeckcard[$i] = null;
            }
            for ($i = sizeof($deckcards) - 1; $i >= 0; $i--) {
                if ($deckcards[$i] == -2)
                    array_splice($deckcards, $i, 1);
            }
            for ($i = sizeof($objdeckcard) - 1; $i >= 0; $i--) {
                if ($objdeckcard[$i] == null)
                    array_splice($objdeckcard, $i, 1);
            }
        }
        if ($this->nbcardpioche != -1) {
            for ($i = 0; $i < $this->nbcardpioche; $i++) {
                $this->pioche->add_to_pioche($objdeckcard[$i], $this->roomid);
                $deckcards[$i] = -2;
                $objdeckcard[$i] = null;
            }
            for ($i = sizeof($deckcards) - 1; $i >= 0; $i--) {
                if ($deckcards[$i] == -2)
                    array_splice($deckcards, $i, 1);
            }
            for ($i = sizeof($deckcards) - 1; $i >= 0; $i--) {
                if ($objdeckcard[$i] == null)
                    array_splice($objdeckcard, $i, 1);
            }
        }
    }
    function display($nbcardshow)
    {
        $output = $this->pioche->display_pioche($nbcardshow);
        $output .= $this->me->tapis->display();
        $output .= $this->me->hand->display();
        $output .= $this->me->display();
        $output .= "<input type='hidden' id='idroom' value=".$this->roomid.">";
        $output .= "<input type='hidden' id='deckid' value=".$this->deck->iddeck.">";
        return $output;
    }
    function get_idplayers()
    {
        $conn = $this->get_connection();
        $sql = "SELECT idplayers FROM room WHERE Id='".$this->roomid."'";
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $str_arr = preg_split("/\,/", $output['idplayers']); 
        $conn->close();
        return $str_arr;
    }
    function add_player($id)
    {
        array_push($this->players , $id);
        $tmp = implode(",", $this->players);
        $conn = $this->get_connection();
        $sql = "UPDATE `room` SET `idplayers`='".$tmp."' WHERE `Id`='".$this->roomid."'";
        $result = $conn->query($sql);
        $conn->close();
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class ensemblecartes {
    public $set = [];
    public $myclass;

    function __construct($class, ?array $tmpset = []) {
        $this->myclass = $class;
        $this->set = $tmpset;
    }
    function display()
    {
        $output = "<div class='".$this->myclass."'>";
        for ($i = 0; $i < sizeof($this->set); $i++) {
            $output .= $this->set[$i]->display();
        }
        $output .= "</div>";
        return $output;
    }
    function display_pioche(?int $nbcardshow = 0)
    {
        $output = "<div class='".$this->myclass."'>";
        for ($i = 0; $i < $nbcardshow; $i++) {
            $output .= $this->set[$i]->display();
        }
        $output .= "</div>";
        return $output;
    }
    function add_to_set($card) {
        var_dump($card);
        array_push($this->set, $card);
    }
    function start()
    {
        $this->set = [];
    }
    function add_to_pioche($card, $idroom) {
        array_push($this->set, $card);
        $conn = $this->get_connection();
        $sql = "UPDATE `room` SET `pioche`=concat(pioche,'".$card->idcard.",') WHERE `Id`='".$idroom."'";
        $conn->query($sql);
        $conn->close();
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}

class Game {
    public $myroom;
    public $deck;
    public $pagehtml;
    public $idplayer;
    public $nbcardplayer;
    public $idgame;
    public $pioche;

    function __construct($idgames, $idplayer, $decktype, $idroom, ?string $nameevent = "default") {
        $this->idgame = $idgames;
        $data = $this->get_data_game();
        $this->nbcardplayer = $data['nbcardsperplayer'];
        $this->pioche = $data['pioche'];
        $this->deck = new Deck($decktype);
        $this->myroom = new Room($idroom ,$this->deck, $this->nbcardplayer, $this->pioche);
        $this->player = new Player($idroom, $idplayer);
        $this->pagehtml = new Pagehtml($nameevent, $this->display());
    }
    function start_game()
    {
        $this->player->start();
        $this->myroom->start_game();
        $this->myroom->distributecards();
    }
    function display()
    {
        $output = $this->myroom->pioche->display();
        $output .= $this->player->trash->display();
        $output .= $this->player->hand->display();
        $output .= $this->player->display();
        return $output;
    }
    function get_data_game()
    {
        $conn = $this->get_connection();
        $sql = "SELECT * FROM game WHERE Id=".$this->idgame;
        $result = $conn->query($sql);
        $output = $result->fetch_assoc();
        $conn->close();
        return $output;
    }
    function get_connection()
    {
        $path = parse_ini_file("card.ini");
        $servername = $path['servername'];
        $username = $path['username'];
        $password = $path['password'];
        $dbname = $path['dbname'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }
}
?>