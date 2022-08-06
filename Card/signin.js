$(document).ready(function () {
    $("#username").click(function(){
        $("#username").val("");
    });
    $("#logo").click(function(){
        $("#logo").val("");
    });
    $("#login").click(function(){
      var idplayer = getCookie("id");
      var check = $("#idplayerlogin").val();
      
      if (check != "") {
        $.get("./checkplayerid.php", {'idplayer': check},
        function(data){
          if (data == "1") {
            document.cookie = "id="+check;
            alert(check);
            $.get("./getlogo.php", {'idplayer': check},
              function(data){
              const arr = data.split(',');
              document.cookie = "logo="+arr[0];
              document.cookie = "username="+arr[1];
              location.replace("select.html?idplayer="+check);
            });
          } else {
            location.reload();
          }
        });
      } else if (idplayer != "") {
        location.replace("select.html?idplayer="+idplayer);
      } 
    });
    $("#signin").click(function(){
      location.replace("select.html?idplayer="+getCookie("id"));
    });
    $(".hand > .card").click(function(){
      var idplayer = getCookie("id");
      id_clicked = $(this).find('input[type=hidden]').val();
      $(this).css('display','none');
      var idroom = $("#idroom").val();
      $.get("./iddeck.php", {'idroom': idroom},
        function(data){
          $.get("./add_to_trash.php", {"idcard" : id_clicked, "idplayer" : idplayer, "iddeck" : data, "idroom": 'IVzDPy'}, function(){
            location.reload();
        });
      });
    });
    $("#cleartapis").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = 1;

      $.get("./clear_tapis.php", {'idplayer': idplayer, 'idroom' : roomid, 'iddeck' : iddeck}, function(){
        location.replace("show_game.php?idplayer="+idplayer+"&idroom="+roomid+"&iddeck="+iddeck+"&idgame="+idgame);
      });
    });
    $("#startgame").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = 1;
      $.get("./create_hand.php", {'idplayer': idplayer, 'idroom' : roomid, 'iddeck' : iddeck, 'idgame' : idgame}, function(){
        location.reload();
      });
    });
    $("#create").click(function(){
      var cardadd = $("#cardadd").val();
      var cardremove = $("#cardremove").val();
      var request = get_request_card_add(cardadd, cardremove);
      var idplayer = getCookie("id");
      var roomid = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = 1;

      $.get("./adddeck.php", {'name': cardadd, 'realname': "", 'request':request}, function(data){ 
        $.get("./addplayer.php", {"idplayer" : idplayer, "idroom" : roomid}, function(){
          location.replace("show_game.php?idplayer="+idplayer+"&idroom="+roomid+"&iddeck="+iddeck+"&idgame="+idgame);
        });
      });
    });
    $("#join").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#roomid").val();
      var iddeck = $("#deckid").val();
      var idgame = 1;

      $.get("./addplayer.php", {"idplayer" : idplayer, "idroom" : roomid}, function(data){});
      $.get("./display_game.php", {'idroom': roomid, 'idplayer': idplayer},
        function(data){
          if (data == "1") {
            $.get("./iddeck.php", {"idroom" : roomid}, function(data){
              location.replace("show_game.php?idplayer="+idplayer+"&idroom="+roomid+"&iddeck="+data+"&idgame="+idgame);
            });
          } else {
            location.reload();
          }
        });
    });
    $("#send").click(function(){
        var name = $("#username").val();
        var logo = $("#logo").val();
        alert(logo);
        $.get("./insert.php", {'name': name, 'logo': logo},
        function(data){
            alert(data);
            document.cookie = "id="+data;
            document.cookie = "username="+name;
            document.cookie = "logo="+logo; 
            location.replace("select.html?idplayer="+getCookie("id"));
        });
        
    });
    function getCookie(cname) {
        let name = cname + "=";
        let ca = document.cookie.split(';');
        for(let i = 0; i < ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
      }
      function get_deck_val(text){
        var expr = /^(10|\d|[VDRJ])(.*)$/;
        let result = expr.exec(text);
        output = [];
        while (Array.isArray(result) && result.length > 0){
            output.push(result[1]);
            result = expr.exec(result[2].slice(1));
        }
        return output;
      }
      
      function removeVal_to_sql(tab){
          tab.splice(tab.indexOf('V'),1,'11');
          tab.splice(tab.indexOf('D'),1,'12');
          tab.splice(tab.indexOf('R'),1,'13');
             if (tab.indexOf('J') != -1){
              tab.splice(tab.indexOf('J'),1);    
              tab.push('0', '-1');
          }
          sql = "AND Value NOT IN (SELECT Value FROM card WHERE Value IN (" + tab.join(',') + "))";
          return sql;
      }
      
      function addVal_to_sql(tab){
          tab.splice(tab.indexOf('V'),1,'11');
          tab.splice(tab.indexOf('D'),1,'12');
          tab.splice(tab.indexOf('R'),1,'13');
             if (tab.indexOf('J') != -1){
              tab.splice(tab.indexOf('J'),1);
              tab.push('0', '-1');
          }
          sql = "SELECT * FROM card WHERE Value IN (" + tab.join(',') + ") ";
          return sql;
      }
      
      function get_request_card_add(add, remove){
          return addVal_to_sql(get_deck_val(add)) + removeVal_to_sql(get_deck_val(remove));
      }
});