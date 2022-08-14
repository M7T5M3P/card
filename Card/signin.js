$(document).ready(function () {
  if ($("#logosite").lenght)
    $("#logosite").effect( "shake", {times:4}, 1000 );
  //setInterval(displayHello, 3000);
  $(".my_player").click(function(){
    var idroom = $("#idroom").val();
    var idplayer = $(this).find('img').attr('value');
    var myid = getCookie("id");
    var id_clicked = $('#id_card').val();
    $.get("./add_to_player.php", {"idroom" : idroom, "myid" : myid, "idplayer": idplayer, "idcard": id_clicked}, function(){
    }).done(function() {
      var content = $(".passcard").contents();
      $(".blanc").html(content);
      $(".passcard").addClass("hidden");
      $(".hidden").removeClass("passcard");
      
    });
  });
  $("#pug1").click(function(){
    fileName = $("#pug1").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
});
  $("#pug2").click(function(){
    fileName = $("#pug2").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
  });
  $("#pug3").click(function(){
    fileName = $("#pug3").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
  });
  $("#pug4").click(function(){
    fileName = $("#pug4").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
  });
  $("#pug5").click(function(){
    fileName = $("#pug5").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
  });
  $("#pug6").click(function(){
    fileName = $("#pug6").attr("src").split("/").pop();
    $('#chooselogo').val(fileName);
  });
  function displayHello() {
    var idplayer = getCookie("id");
    var idroom = $("#idroom").val();
    var iddeck = $("#deckid").val();
    var idgame = $("#idgame").val();
    $.get("./get_main.php", {"idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(data){
      $(".hand")[0].outerHTML = data;
    });
    $.get("./get_tapis.php", {"idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(data){
      $(".tapis")[0].outerHTML = data;
    });
  }
    $("#username").click(function(){
        $("#username").val("");
    });
    $("#logo").click(function(){
        $("#logo").val("");
    });
    $("#login").click(function(){
      var idplayer = getCookie("id");
      var check = $("#idplayerlogin").val();
      var date = new Date();
      date.setTime(date.getTime() + (2*24*60*60*1000));
      expires = "; expires=" + date.toUTCString();
      if (check != "") {
        $.get("./checkplayerid.php", {'idplayer': check},
        function(data){
          if (data == "1") {
            document.cookie = "id="+check+""+expires;
            $.get("./getlogo.php", {'idplayer': check},
              function(data){
              const arr = data.split(',');
              document.cookie = "logo="+arr[0]+""+expires;
              document.cookie = "username="+arr[1]+""+expires;
              location.replace("select.php?idplayer="+check);
            });
          } else {
            location.reload();
          }
        });
      } else if (idplayer != "") {
        location.replace("select.php?idplayer="+idplayer);
      } 
    });
    $("#infoautomatiquecard").click(function(){
      alert("La pioche rajoute automatiquement une carte jusqu'à sa limite précisée.");
    });
    $("#infocheckgetcardtapis").click(function(){
      alert("Les joueurs peuvent recuperer des cartes du tapis.");
    });
    $("#infonbcartesdefaussable").click(function(){
      alert("Vous pouvez limiter le nombre de cartes jouables.");
    });
    $("#infocardforgame").click(function(){
      alert("Si vous ne souhaitez pas certaine cartes.\nVous pouvez le presicez comme : '2,3,4,5'.");
    });
    $("#infocardhand").click(function(){
      alert("Vous pouvez precisez -1 cela distribura toute les cartes.");
    });
    $("#infotour").click(function(){
      alert("Cela signifie que tout les joueurs jouent chacun leur tour.\nMis par défaut.");
    });
    $("#infopasscard").click(function(){
      alert("Cela signifie que les joueurs peuvent s'échanger des cartes entre eux.");
    });
    $("#signin").click(function(){
      location.replace("select.php?idplayer="+getCookie("id"));
    });
    $("#button_tapis").click(function(){
      var idplayer = getCookie("id");
      var id_clicked = $('#id_card').val();
      var idroom = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = $("#idgame").val();
      $.get("./add_to_trash.php", {"idcard" : id_clicked, "idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(){
        $(".passcard").addClass("hidden");
        $(".hidden").removeClass("passcard");
        location.reload();
      });
    });
    $("#button_joueur").click(function(){
      var content = $(".blanc").contents();
      $(".passcard").html(content);
    });
    $(".hand > .card").click(function(){
      var passtoplayer = $("#passcard").val();
      var idplayer = getCookie("id");
      var id_clicked = $(this).find('input[type=hidden]').val();
      $(this).css('display','none');
      $('#id_card').val(id_clicked);
      var idroom = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = $("#idgame").val();
      //alert("add_to_trash.php?idcard=" + id_clicked + "&idplayer=" + idplayer + "&iddeck=" + iddeck + "&idroom=" + idroom+"&idgame="+idgame);
      if (passtoplayer == "1") {
        $(".hidden").addClass("passcard");
        $(".hidden").removeClass("hidden");
      } else {
        $.get("./add_to_trash.php", {"idcard" : id_clicked, "idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(){
          location.reload();
        });
      }
    });
    $(".pioche > .card").click(function(){
      var idplayer = getCookie("id");
      var id_clicked = $(this).find('input[type=hidden]').val();
      var idroom = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = $("#idgame").val();
      $.get("./add_to_hand.php", {"idcard" : id_clicked, "idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(){
        location.reload();
      });
    });
    $(".tapis > .card").click(function(){
      var idplayer = getCookie("id");
      var id_clicked = $(this).find('input[type=hidden]').val();
      var idroom = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var checktakecard = $("#checktakecardtapis").val();
      var idgame = $("#idgame").val();

      if (checktakecard == 1) {
        $.get("./remove_from_tapis.php", {"idcard" : id_clicked, "idplayer" : idplayer, "iddeck" : iddeck, "idroom": idroom, "idgame": idgame}, function(){
          location.reload();
        });
      }
    });
    $("#cleartapis").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = $("#idgame").val();

      $.get("./clear_tapis.php", {'idplayer': idplayer, 'idroom' : roomid, 'iddeck' : iddeck, 'idgame' : idgame}, function(){
        location.reload();
      });
    });
    $("#startgame").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#idroom").val();
      var iddeck = $("#deckid").val();
      var idgame = $("#idgame").val();

      $.get("./create_hand.php", {'idplayer': idplayer, 'idroom' : roomid, 'iddeck' : iddeck, 'idgame' : idgame}, function(){
        location.reload();
      });
    });
    $("#create").click(function(){
      var cardadd = $("#cardadd").val();
      var cardremove = $("#cardremove").val();
      var request = get_request_card_add(cardadd, cardremove);
      var idplayer = getCookie("id");
      var nbcardhand = $("#nbcardhand").val();
      var nbtrash = $("#nbtrash").val();
      var nbcardpioche = $("#nbcardpioche").val();
      var namegame = $("#namegame").val();
      var nbvisiblecardpioche = $("#nbvisiblecardpioche").val();
      var nbjoueurmax = $("#nbplayer").val();
      var checktourpartour = 0;
      var givecard = 0;
      var distribauto = 0;
      var checkgetcardtapis = 0;
      if ($("#checktourpartour").get(0).checked) {
        checktourpartour = 1;
      } 
      if ($("#givecard").get(0).checked) {
        givecard = 1;
      }
      if ($("#automatiquecard").get(0).checked) {
        distribauto = 1;
      }
      if ($("#checkgetcardtapis").get(0).checked) {
        checkgetcardtapis = 1;
      }
      var check = true;
      if( !nbjoueurmax) {
        $("#nbplayer").addClass('warning');
        check = false;
      } else
        $("#nbplayer").removeClass('warning');
      if( !nbcardhand) {
        $("#nbcardhand").addClass('warning');
        check = false;
      } else
        $("#nbcardhand").removeClass('warning');
      if( !nbtrash) {
        $("#nbtrash").addClass('warning');
        check = false;
      } else 
        $("#nbtrash").removeClass('warning');
      if( !nbcardpioche) {
        $("#nbcardpioche").addClass('warning');
        check = false;
      } else 
        $("#nbcardpioche").removeClass('warning');
      if( !namegame) {
        $("#namegame").addClass('warning');
        check = false;
      } else 
        $("#namegame").removeClass('warning');
      if( !nbvisiblecardpioche) {
        $("#nbvisiblecardpioche").addClass('warning');
        check = false;
      } else 
        $("#nbvisiblecardpioche").removeClass('warning');
      let result = nbcardpioche. concat(','+nbvisiblecardpioche+','+nbtrash+','+checktourpartour+','+givecard+','+distribauto+','+checkgetcardtapis);
      if (check) {
        $.get("./create_game.php", {'name': namegame, 'nbcards' : nbcardhand, 'pioche' : result, 'nbcardtoshow' : nbvisiblecardpioche}, function(data){
          var idgame = data;
          //alert(idgame);
          $.get("./adddeck.php", {'name': cardadd, 'realname': namegame, 'request':request}, function(data){ 
            var iddeck = data;
            //alert("idroom.php?iddeck="+iddeck+"&nbmaxplayer="+nbjoueurmax+"&idgame="+idgame+"&idplayer="+idplayer);
              $.get("./idroom.php", {"iddeck" : iddeck, "nbmaxplayer" : nbjoueurmax, "idgame" : idgame, "idplayer" : idplayer}, function(data){
                var roomid = data;
                
                //alert("addplayer.php?idplayer="+idplayer+"&idroom="+roomid);
                $.get("./addplayer.php", {"idplayer" : idplayer, "idroom" : roomid}, function(){
                  location.replace("show_game.php?idplayer="+idplayer+"&idroom="+roomid+"&iddeck="+iddeck+"&idgame="+idgame);
                });
              });
          });
        });
      }
    });
    $("#join").click(function(){
      var idplayer = getCookie("id");
      var roomid = $("#roomid").val();
      var idgame = 1;

      $.get("./addplayer.php", {"idplayer" : idplayer, "idroom" : roomid}, function(){});
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
        var logo = $('#chooselogo').val();
        logo = "logo/".concat(logo);
        var date = new Date();
        date.setTime(date.getTime() + (2*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
        $.get("./insert.php", {'name': name, 'logo': logo},
        function(data){
            document.cookie = "id="+data+""+expires;
            document.cookie = "username="+name+""+expires;
            document.cookie = "logo="+logo+""+expires; 
            location.replace("select.php?idplayer="+getCookie("id"));
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
