<!doctype html>
<html lang="es">
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Expires" content="<?php date("D").", ".date("d")." ".date("M")." ".date("Y")." 23:00:00 GMT" ?>">
        <meta http-equiv="Pragma" content="no-cache">
        <!--jQuery-->
        <script src="dist/jquery/jquery-3.3.1.min.js"></script>
        <script src="//twemoji.maxcdn.com/twemoji.min.js"></script>
        <!--jQuery-->
        <!--Normalize-->
        <link rel="stylesheet" href="dist/normalize/normalize.css">
        <!--Normalize-->
        <!--Tether-->
        <link rel="stylesheet" href="dist/tether-1.3.3/css/tether.min.css">
        <script src="dist/tether-1.3.3/js/tether.min.js"></script>
        <!--Tether-->
        <!--Bootstrap-->
        <link rel="stylesheet" href="dist/fonts/glyphicons/css/glyphicons.css">
        <link rel="stylesheet" href="dist/bootstrap/bootstrap-4.0.0-alpha/css/bootstrap.min.css">
        <script src="dist/bootstrap/bootstrap-4.0.0-alpha/js/bootstrap.min.js"></script>
        <!--Bootstrap-->
        <!--font-awesome-v-4.7.0-->
        <link rel="stylesheet" href="dist/fonts/font-awesome-v-4.7.0/css/font-awesome.min.css">
        <!--font-awesome-v-4.7.0-->
        <!--Scroll Top-->
        <link rel="stylesheet" href="dist/scrolltop/css/scroll.top.css">
        <script src="dist/scrolltop/js/scroll.top.js"></script>
        <!--Scroll Top-->
        <link rel="stylesheet" href="css/estilos_base.css">
	<script src="js/script.base.js"></script>
	<script src="js/fancywebsocket.js"></script>


	<script>
		var Server;

		
		$('<audio id="audio_fb"> <source src="audio/beep.wav" type="audio/mpeg"></audio>').appendTo("body");
		var IdUsuario="<?php echo $_REQUEST['idUsuario']; ?>";
		
		var Usuario="<?php echo $_REQUEST['Usuario']; ?>";

        function scroll_to(div){
            $('html, body').animate({
                scrollTop: $("mydiv").offset().top
            },1000);
        }

      function Notifica(asuntoMensaje){

    
	      if (Notification) {
	        if (Notification.permission !== "granted") {
	        Notification.requestPermission()
	        }
	       
	        var title = "Empresa"
	        var extra = {
	        icon: "logo.png",
	        body: asuntoMensaje
	        }
	        var noti = new Notification( title, extra)
	        noti.onclick = {
	          
	        }
	        noti.onclose = {
	        // Al cerrar
	        }
	        setTimeout( function() { noti.close() }, 180000)
	        }
	        	
	      }

		function log( text ) {
			//Notifica(text);


		var res = text.split(",");
		//alert(res);

		//alert(res[0]);
			
			

        if(res[1]==IdUsuario || res[0]==IdUsuario){//aqui será la variable de sesión

        	if(res[1] == IdUsuario){

                if(res[6]!=1 & res[6]!=0){
        		$("#"+res[0]).trigger("click");
                $('#audio_fb')[0].play();
                }
                //mostrar el mesaje de escribiendo
                    if(res[6]==1){
                         $("#escribiendo").html(res[4]+" Escribiendo...");
                    }
                    if(res[6]==0){
                         $("#escribiendo").html("");
                    }


        	}
             if(res[0] != IdUsuario){
                  alineacion='text-align:left !mportant;';
                  color="#D4EFDF";
                  largo="225px";

             }else{
                 alineacion='text-align:right !mportant;';
                 color="#D6DBDF";
                 largo="247px"; 
             }
                 
        
       
        if(res[6]=="null" & res[6]!=1 & res[6]!=0 ){
			$log = $('#log');
       
$log.append(($log.val()?"\n":'')+"<div class='msj form-control' style='color:red !important;height:auto !important;overflow-y:hidden;width:"+largo+";background-color:"+color+";"+alineacion+"border-radius:19px;float:right;padding-top:18px;color:#000 !important;margin-top:3px; font-size:14px;'>"+res[5]+' '+res[4]+": "+res[2]+"</div>");
          $(".msj").animate({ scrollTop: $('#log')[0].scrollHeight}, 0);
          $("#log").animate({ scrollTop: $('#log')[0].scrollHeight}, 0);

           }

		
		 }
		
        }

		function send( text ) {
			Server.send( 'message', text );
		}

		$(document).ready(function() {
			//log('Conectando...');
            alineacion='text-align:right !mportant;';
			$("#message").focus();
			Server = new FancyWebSocket('ws://192.168.0.8:9300');
        	$('#enviarMensaje').submit(function() {
				//if ( e.keyCode == 13 && this.value ) {
		escribiendo="null";
		valorUsuario=$(".active").attr('id');
		mensaje=IdUsuario+','+valorUsuario+','+$('#message').val()+','+$("#"+valorUsuario).text()+','+Usuario+','+'<?php echo date('Y-m-d H:i:s')?>'+','+escribiendo ;//usuario a comunicar
				    log(mensaje);

					send(mensaje);

					$('#message').val('');
					return false;
				//}
			});

            $("#message").keyup(function(){
                if($("#message").val()!=""){
                    
                     escribiendo=1;
                }else{
                    
                    escribiendo=0;
                }

        valorUsuario=$(".active").attr('id');
        mensaje=IdUsuario+','+valorUsuario+','+$('#message').val()+','+$("#"+valorUsuario).text()+','+Usuario+','+'<?php echo date('Y-m-d H:i:s')?>'+','+escribiendo ;//usuario a comunicar
                    log(mensaje);
                   send(mensaje);

       
            });

           /* $('#enviarMensaje input[type=text]').on('change invalid', function() {
                var campotexto = $(this).get(0);

                campotexto.setCustomValidity('');

                if (!campotexto.validity.valid) {
                  campotexto.setCustomValidity('Escribe un mensaje');  
                }
            });*/

			Server.bind('open', function() {
				log( "Conectado." );
			});

			Server.bind('close', function( data ) {
				log( "Desconectado" );
			});
			Server.bind('message', function( payload ) {
				log( payload );
			});

			Server.connect();
		});
	</script>
    </head>
    <body>
       
      <ul class="emoji-list">
      <li>&#x1F004;</li>
      <li>&#x1F0CF;</li>
      <li>&#x1F170;</li>
      <li>&#x1F171;</li>
      <li>&#x1F17E;</li>
      <li>&#x1F17F;</li>
      <li>&#x1F18E;</li>
      <li>&#x1F191;</li>
      <li>&#x1F192;</li>
      <li>&#x1F193;</li>
      <li>&#x1F194;</li>
      <li>&#x1F195;</li>
      <li>&#x1F196;</li>
      <li>&#x1F197;</li>
      <li>&#x1F198;</li>
      <li>&#x1F199;</li>
      <li>&#x1F19A;</li>
      <li>&#x1F1E6;</li>
      <li>&#x1F1E7;</li>
      <li>&#x1F1E8;&#x1F1F3;</li>
      <li>&#x1F1E8;</li>
      <li>&#x1F1E9;&#x1F1EA;</li>
      <li>&#x1F1E9;</li>
      <li>&#x1F1EA;&#x1F1F8;</li>
      <li>&#x1F1EA;</li>
      <li>&#x1F1EB;&#x1F1F7;</li>
      <li>&#x1F1EB;</li>
      <li>&#x1F1EC;&#x1F1E7;</li>
      <li>&#x1F1EC;</li>
      <li>&#x1F1ED;</li>
      <li>&#x1F1EE;&#x1F1F9;</li>
      <li>&#x1F1EE;</li>
      <li>&#x1F1EF;&#x1F1F5;</li>
      <li>&#x1F1EF;</li>
      <li>&#x1F1F0;&#x1F1F7;</li>
      <li>&#x1F1F0;</li>
      <li>&#x1F1F1;</li>
      <li>&#x1F1F2;</li>
      <li>&#x1F1F3;</li>
      <li>&#x1F1F4;</li>
      <li>&#x1F1F5;</li>
      <li>&#x1F1F6;</li>
      <li>&#x1F1F7;&#x1F1FA;</li>
      <li>&#x1F1F7;</li>
      <li>&#x1F1F8;</li>
      <li>&#x1F1F9;</li>
      <li>&#x1F1FA;&#x1F1F8;</li>
      <li>&#x1F1FA;</li>
      <li>&#x1F1FB;</li>
      <li>&#x1F1FC;</li>
      <li>&#x1F1FD;</li>
      <li>&#x1F1FE;</li>
      <li>&#x1F1FF;</li>
      <li>&#x1F201;</li>
      <li>&#x1F202;</li>
      <li>&#x1F21A;</li>
      <li>&#x1F22F;</li>
      <li>&#x1F232;</li>
      <li>&#x1F233;</li>
      <li>&#x1F234;</li>
      <li>&#x1F235;</li>
      <li>&#x1F236;</li>
      <li>&#x1F237;</li>
      <li>&#x1F238;</li>
      <li>&#x1F239;</li>
      <li>&#x1F23A;</li>
      <li>&#x1F250;</li>
      <li>&#x1F251;</li>
      <li>&#x1F300;</li>
      <li>&#x1F301;</li>
      <li>&#x1F302;</li>
      <li>&#x1F303;</li>
      <li>&#x1F304;</li>
      <li>&#x1F305;</li>
      <li>&#x1F306;</li>
      <li>&#x1F307;</li>
      <li>&#x1F308;</li>
      <li>&#x1F309;</li>
      <li>&#x1F30A;</li>
      <li>&#x1F30B;</li>
      <li>&#x1F30C;</li>
      <li>&#x1F30D;</li>
      <li>&#x1F30E;</li>
      <li>&#x1F30F;</li>
      <li>&#x1F310;</li>
      <li>&#x1F311;</li>
      <li>&#x1F312;</li>
      <li>&#x1F313;</li>
      <li>&#x1F314;</li>
      <li>&#x1F315;</li>
      <li>&#x1F316;</li>
      <li>&#x1F317;</li>
      <li>&#x1F318;</li>
      <li>&#x1F319;</li>
      <li>&#x1F31A;</li>
      <li>&#x1F31B;</li>
      <li>&#x1F31C;</li>
      <li>&#x1F31D;</li>
      <li>&#x1F31E;</li>
      <li>&#x1F31F;</li>
      <li>&#x1F320;</li>
      <li>&#x1F330;</li>
      <li>&#x1F331;</li>
      <li>&#x1F332;</li>
      <li>&#x1F333;</li>
      <li>&#x1F334;</li>
      <li>&#x1F335;</li>
      <li>&#x1F337;</li>
      <li>&#x1F338;</li>
      <li>&#x1F339;</li>
      <li>&#x1F33A;</li>
      <li>&#x1F33B;</li>
      <li>&#x1F33C;</li>
      <li>&#x1F33D;</li>
      <li>&#x1F33E;</li>
      <li>&#x1F33F;</li>
      <li>&#x1F340;</li>
      <li>&#x1F341;</li>
      <li>&#x1F342;</li>
      <li>&#x1F343;</li>
      <li>&#x1F344;</li>
      <li>&#x1F345;</li>
      <li>&#x1F346;</li>
      <li>&#x1F347;</li>
      <li>&#x1F348;</li>
      <li>&#x1F349;</li>
      <li>&#x1F34A;</li>
      <li>&#x1F34B;</li>
      <li>&#x1F34C;</li>
      <li>&#x1F34D;</li>
      <li>&#x1F34E;</li>
      <li>&#x1F34F;</li>
      <li>&#x1F350;</li>
      <li>&#x1F351;</li>
      <li>&#x1F352;</li>
      <li>&#x1F353;</li>
      <li>&#x1F354;</li>
      <li>&#x1F355;</li>
      <li>&#x1F356;</li>
      <li>&#x1F357;</li>
      <li>&#x1F358;</li>
      <li>&#x1F359;</li>
      <li>&#x1F35A;</li>
      <li>&#x1F35B;</li>
      <li>&#x1F35C;</li>
      <li>&#x1F35D;</li>
      <li>&#x1F35E;</li>
      <li>&#x1F35F;</li>
      <li>&#x1F360;</li>
      <li>&#x1F361;</li>
      <li>&#x1F362;</li>
      <li>&#x1F363;</li>
      <li>&#x1F364;</li>
      <li>&#x1F365;</li>
      <li>&#x1F366;</li>
      <li>&#x1F367;</li>
      <li>&#x1F368;</li>
      <li>&#x1F369;</li>
      <li>&#x1F36A;</li>
      <li>&#x1F36B;</li>
      <li>&#x1F36C;</li>
      <li>&#x1F36D;</li>
      <li>&#x1F36E;</li>
      <li>&#x1F36F;</li>
      <li>&#x1F370;</li>
      <li>&#x1F371;</li>
      <li>&#x1F372;</li>
      <li>&#x1F373;</li>
      <li>&#x1F374;</li>
      <li>&#x1F375;</li>
      <li>&#x1F376;</li>
      <li>&#x1F377;</li>
      <li>&#x1F378;</li>
      <li>&#x1F379;</li>
      <li>&#x1F37A;</li>
      <li>&#x1F37B;</li>
      <li>&#x1F37C;</li>
      <li>&#x1F380;</li>
      <li>&#x1F381;</li>
      <li>&#x1F382;</li>
      <li>&#x1F383;</li>
      <li>&#x1F384;</li>
      <li>&#x1F385;</li>
      <li>&#x1F386;</li>
      <li>&#x1F387;</li>
      <li>&#x1F388;</li>
      <li>&#x1F389;</li>
      <li>&#x1F38A;</li>
      <li>&#x1F38B;</li>
      <li>&#x1F38C;</li>
      <li>&#x1F38D;</li>
      <li>&#x1F38E;</li>
      <li>&#x1F38F;</li>
      <li>&#x1F390;</li>
      <li>&#x1F391;</li>
      <li>&#x1F392;</li>
      <li>&#x1F393;</li>
      <li>&#x1F3A0;</li>
      <li>&#x1F3A1;</li>
      <li>&#x1F3A2;</li>
      <li>&#x1F3A3;</li>
      <li>&#x1F3A4;</li>
      <li>&#x1F3A5;</li>
      <li>&#x1F3A6;</li>
      <li>&#x1F3A7;</li>
      <li>&#x1F3A8;</li>
      <li>&#x1F3A9;</li>
      <li>&#x1F3AA;</li>
      <li>&#x1F3AB;</li>
      <li>&#x1F3AC;</li>
      <li>&#x1F3AD;</li>
      <li>&#x1F3AE;</li>
      <li>&#x1F3AF;</li>
      <li>&#x1F3B0;</li>
      <li>&#x1F3B1;</li>
      <li>&#x1F3B2;</li>
      <li>&#x1F3B3;</li>
      <li>&#x1F3B4;</li>
      <li>&#x1F3B5;</li>
      <li>&#x1F3B6;</li>
      <li>&#x1F3B7;</li>
      <li>&#x1F3B8;</li>
      <li>&#x1F3B9;</li>
      <li>&#x1F3BA;</li>
      <li>&#x1F3BB;</li>
      <li>&#x1F3BC;</li>
      <li>&#x1F3BD;</li>
      <li>&#x1F3BE;</li>
      <li>&#x1F3BF;</li>
      <li>&#x1F3C0;</li>
      <li>&#x1F3C1;</li>
      <li>&#x1F3C2;</li>
      <li>&#x1F3C3;</li>
      <li>&#x1F3C4;</li>
      <li>&#x1F3C6;</li>
      <li>&#x1F3C7;</li>
      <li>&#x1F3C8;</li>
      <li>&#x1F3C9;</li>
      <li>&#x1F3CA;</li>
      <li>&#x1F3E0;</li>
      <li>&#x1F3E1;</li>
      <li>&#x1F3E2;</li>
      <li>&#x1F3E3;</li>
      <li>&#x1F3E4;</li>
      <li>&#x1F3E5;</li>
      <li>&#x1F3E6;</li>
      <li>&#x1F3E7;</li>
      <li>&#x1F3E8;</li>
      <li>&#x1F3E9;</li>
      <li>&#x1F3EA;</li>
      <li>&#x1F3EB;</li>
      <li>&#x1F3EC;</li>
      <li>&#x1F3ED;</li>
      <li>&#x1F3EE;</li>
      <li>&#x1F3EF;</li>
      <li>&#x1F3F0;</li>
      <li>&#x1F400;</li>
      <li>&#x1F401;</li>
      <li>&#x1F402;</li>
      <li>&#x1F403;</li>
      <li>&#x1F404;</li>
      <li>&#x1F405;</li>
      <li>&#x1F406;</li>
      <li>&#x1F407;</li>
      <li>&#x1F408;</li>
      <li>&#x1F409;</li>
      <li>&#x1F40A;</li>
      <li>&#x1F40B;</li>
      <li>&#x1F40C;</li>
      <li>&#x1F40D;</li>
      <li>&#x1F40E;</li>
      <li>&#x1F40F;</li>
      <li>&#x1F410;</li>
      <li>&#x1F411;</li>
      <li>&#x1F412;</li>
      <li>&#x1F413;</li>
      <li>&#x1F414;</li>
      <li>&#x1F415;</li>
      <li>&#x1F416;</li>
      <li>&#x1F417;</li>
      <li>&#x1F418;</li>
      <li>&#x1F419;</li>
      <li>&#x1F41A;</li>
      <li>&#x1F41B;</li>
      <li>&#x1F41C;</li>
      <li>&#x1F41D;</li>
      <li>&#x1F41E;</li>
      <li>&#x1F41F;</li>
      <li>&#x1F420;</li>
      <li>&#x1F421;</li>
      <li>&#x1F422;</li>
      <li>&#x1F423;</li>
      <li>&#x1F424;</li>
      <li>&#x1F425;</li>
      <li>&#x1F426;</li>
      <li>&#x1F427;</li>
      <li>&#x1F428;</li>
      <li>&#x1F429;</li>
      <li>&#x1F42A;</li>
      <li>&#x1F42B;</li>
      <li>&#x1F42C;</li>
      <li>&#x1F42D;</li>
      <li>&#x1F42E;</li>
      <li>&#x1F42F;</li>
      <li>&#x1F430;</li>
      <li>&#x1F431;</li>
      <li>&#x1F432;</li>
      <li>&#x1F433;</li>
      <li>&#x1F434;</li>
      <li>&#x1F435;</li>
      <li>&#x1F436;</li>
      <li>&#x1F437;</li>
      <li>&#x1F438;</li>
      <li>&#x1F439;</li>
      <li>&#x1F43A;</li>
      <li>&#x1F43B;</li>
      <li>&#x1F43C;</li>
      <li>&#x1F43D;</li>
      <li>&#x1F43E;</li>
      <li>&#x1F440;</li>
      <li>&#x1F442;</li>
      <li>&#x1F443;</li>
      <li>&#x1F444;</li>
      <li>&#x1F445;</li>
      <li>&#x1F446;</li>
      <li>&#x1F447;</li>
      <li>&#x1F448;</li>
      <li>&#x1F449;</li>
      <li>&#x1F44A;</li>
      <li>&#x1F44B;</li>
      <li>&#x1F44C;</li>
      <li>&#x1F44D;</li>
      <li>&#x1F44E;</li>
      <li>&#x1F44F;</li>
      <li>&#x1F450;</li>
      <li>&#x1F451;</li>
      <li>&#x1F452;</li>
      <li>&#x1F453;</li>
      <li>&#x1F454;</li>
      <li>&#x1F455;</li>
      <li>&#x1F456;</li>
      <li>&#x1F457;</li>
      <li>&#x1F458;</li>
      <li>&#x1F459;</li>
      <li>&#x1F45A;</li>
      <li>&#x1F45B;</li>
      <li>&#x1F45C;</li>
      <li>&#x1F45D;</li>
      <li>&#x1F45E;</li>
      <li>&#x1F45F;</li>
      <li>&#x1F460;</li>
      <li>&#x1F461;</li>
      <li>&#x1F462;</li>
      <li>&#x1F463;</li>
      <li>&#x1F464;</li>
      <li>&#x1F465;</li>
      <li>&#x1F466;</li>
      <li>&#x1F467;</li>
      <li>&#x1F468;</li>
      <li>&#x1F469;</li>
      <li>&#x1F46A;</li>
      <li>&#x1F46B;</li>
      <li>&#x1F46C;</li>
      <li>&#x1F46D;</li>
      <li>&#x1F46E;</li>
      <li>&#x1F46F;</li>
      <li>&#x1F470;</li>
      <li>&#x1F471;</li>
      <li>&#x1F472;</li>
      <li>&#x1F473;</li>
      <li>&#x1F474;</li>
      <li>&#x1F475;</li>
      <li>&#x1F476;</li>
      <li>&#x1F477;</li>
      <li>&#x1F478;</li>
      <li>&#x1F479;</li>
      <li>&#x1F47A;</li>
      <li>&#x1F47B;</li>
      <li>&#x1F47C;</li>
      <li>&#x1F47D;</li>
      <li>&#x1F47E;</li>
      <li>&#x1F47F;</li>
      <li>&#x1F480;</li>
      <li>&#x1F481;</li>
      <li>&#x1F482;</li>
      <li>&#x1F483;</li>
      <li>&#x1F484;</li>
      <li>&#x1F485;</li>
      <li>&#x1F486;</li>
      <li>&#x1F487;</li>
      <li>&#x1F488;</li>
      <li>&#x1F489;</li>
      <li>&#x1F48A;</li>
      <li>&#x1F48B;</li>
      <li>&#x1F48C;</li>
      <li>&#x1F48D;</li>
      <li>&#x1F48E;</li>
      <li>&#x1F48F;</li>
      <li>&#x1F490;</li>
      <li>&#x1F491;</li>
      <li>&#x1F492;</li>
      <li>&#x1F493;</li>
      <li>&#x1F494;</li>
      <li>&#x1F495;</li>
      <li>&#x1F496;</li>
      <li>&#x1F497;</li>
      <li>&#x1F498;</li>
      <li>&#x1F499;</li>
      <li>&#x1F49A;</li>
      <li>&#x1F49B;</li>
      <li>&#x1F49C;</li>
      <li>&#x1F49D;</li>
      <li>&#x1F49E;</li>
      <li>&#x1F49F;</li>
      <li>&#x1F4A0;</li>
      <li>&#x1F4A1;</li>
      <li>&#x1F4A2;</li>
      <li>&#x1F4A3;</li>
      <li>&#x1F4A4;</li>
      <li>&#x1F4A5;</li>
      <li>&#x1F4A6;</li>
      <li>&#x1F4A7;</li>
      <li>&#x1F4A8;</li>
      <li>&#x1F4A9;</li>
      <li>&#x1F4AA;</li>
      <li>&#x1F4AB;</li>
      <li>&#x1F4AC;</li>
      <li>&#x1F4AD;</li>
      <li>&#x1F4AE;</li>
      <li>&#x1F4AF;</li>
      <li>&#x1F4B0;</li>
      <li>&#x1F4B1;</li>
      <li>&#x1F4B2;</li>
      <li>&#x1F4B3;</li>
      <li>&#x1F4B4;</li>
      <li>&#x1F4B5;</li>
      <li>&#x1F4B6;</li>
      <li>&#x1F4B7;</li>
      <li>&#x1F4B8;</li>
      <li>&#x1F4B9;</li>
      <li>&#x1F4BA;</li>
      <li>&#x1F4BB;</li>
      <li>&#x1F4BC;</li>
      <li>&#x1F4BD;</li>
      <li>&#x1F4BE;</li>
      <li>&#x1F4BF;</li>
      <li>&#x1F4C0;</li>
      <li>&#x1F4C1;</li>
      <li>&#x1F4C2;</li>
      <li>&#x1F4C3;</li>
      <li>&#x1F4C4;</li>
      <li>&#x1F4C5;</li>
      <li>&#x1F4C6;</li>
      <li>&#x1F4C7;</li>
      <li>&#x1F4C8;</li>
      <li>&#x1F4C9;</li>
      <li>&#x1F4CA;</li>
      <li>&#x1F4CB;</li>
      <li>&#x1F4CC;</li>
      <li>&#x1F4CD;</li>
      <li>&#x1F4CE;</li>
      <li>&#x1F4CF;</li>
      <li>&#x1F4D0;</li>
      <li>&#x1F4D1;</li>
      <li>&#x1F4D2;</li>
      <li>&#x1F4D3;</li>
      <li>&#x1F4D4;</li>
      <li>&#x1F4D5;</li>
      <li>&#x1F4D6;</li>
      <li>&#x1F4D7;</li>
      <li>&#x1F4D8;</li>
      <li>&#x1F4D9;</li>
      <li>&#x1F4DA;</li>
      <li>&#x1F4DB;</li>
      <li>&#x1F4DC;</li>
      <li>&#x1F4DD;</li>
      <li>&#x1F4DE;</li>
      <li>&#x1F4DF;</li>
      <li>&#x1F4E0;</li>
      <li>&#x1F4E1;</li>
      <li>&#x1F4E2;</li>
      <li>&#x1F4E3;</li>
      <li>&#x1F4E4;</li>
      <li>&#x1F4E5;</li>
      <li>&#x1F4E6;</li>
      <li>&#x1F4E7;</li>
      <li>&#x1F4E8;</li>
      <li>&#x1F4E9;</li>
      <li>&#x1F4EA;</li>
      <li>&#x1F4EB;</li>
      <li>&#x1F4EC;</li>
      <li>&#x1F4ED;</li>
      <li>&#x1F4EE;</li>
      <li>&#x1F4EF;</li>
      <li>&#x1F4F0;</li>
      <li>&#x1F4F1;</li>
      <li>&#x1F4F2;</li>
      <li>&#x1F4F3;</li>
      <li>&#x1F4F4;</li>
      <li>&#x1F4F5;</li>
      <li>&#x1F4F6;</li>
      <li>&#x1F4F7;</li>
      <li>&#x1F4F9;</li>
      <li>&#x1F4FA;</li>
      <li>&#x1F4FB;</li>
      <li>&#x1F4FC;</li>
      <li>&#x1F500;</li>
      <li>&#x1F501;</li>
      <li>&#x1F502;</li>
      <li>&#x1F503;</li>
      <li>&#x1F504;</li>
      <li>&#x1F505;</li>
      <li>&#x1F506;</li>
      <li>&#x1F507;</li>
      <li>&#x1F508;</li>
      <li>&#x1F509;</li>
      <li>&#x1F50A;</li>
      <li>&#x1F50B;</li>
      <li>&#x1F50C;</li>
      <li>&#x1F50D;</li>
      <li>&#x1F50E;</li>
      <li>&#x1F50F;</li>
      <li>&#x1F510;</li>
      <li>&#x1F511;</li>
      <li>&#x1F512;</li>
      <li>&#x1F513;</li>
      <li>&#x1F514;</li>
      <li>&#x1F515;</li>
      <li>&#x1F516;</li>
      <li>&#x1F517;</li>
      <li>&#x1F518;</li>
      <li>&#x1F519;</li>
      <li>&#x1F51A;</li>
      <li>&#x1F51B;</li>
      <li>&#x1F51C;</li>
      <li>&#x1F51D;</li>
      <li>&#x1F51E;</li>
      <li>&#x1F51F;</li>
      <li>&#x1F520;</li>
      <li>&#x1F521;</li>
      <li>&#x1F522;</li>
      <li>&#x1F523;</li>
      <li>&#x1F524;</li>
      <li>&#x1F525;</li>
      <li>&#x1F526;</li>
      <li>&#x1F527;</li>
      <li>&#x1F528;</li>
      <li>&#x1F529;</li>
      <li>&#x1F52A;</li>
      <li>&#x1F52B;</li>
      <li>&#x1F52C;</li>
      <li>&#x1F52D;</li>
      <li>&#x1F52E;</li>
      <li>&#x1F52F;</li>
      <li>&#x1F530;</li>
      <li>&#x1F531;</li>
      <li>&#x1F532;</li>
      <li>&#x1F533;</li>
      <li>&#x1F534;</li>
      <li>&#x1F535;</li>
      <li>&#x1F536;</li>
      <li>&#x1F537;</li>
      <li>&#x1F538;</li>
      <li>&#x1F539;</li>
      <li>&#x1F53A;</li>
      <li>&#x1F53B;</li>
      <li>&#x1F53C;</li>
      <li>&#x1F53D;</li>
      <li>&#x1F550;</li>
      <li>&#x1F551;</li>
      <li>&#x1F552;</li>
      <li>&#x1F553;</li>
      <li>&#x1F554;</li>
      <li>&#x1F555;</li>
      <li>&#x1F556;</li>
      <li>&#x1F557;</li>
      <li>&#x1F558;</li>
      <li>&#x1F559;</li>
      <li>&#x1F55A;</li>
      <li>&#x1F55B;</li>
      <li>&#x1F55C;</li>
      <li>&#x1F55D;</li>
      <li>&#x1F55E;</li>
      <li>&#x1F55F;</li>
      <li>&#x1F560;</li>
      <li>&#x1F561;</li>
      <li>&#x1F562;</li>
      <li>&#x1F563;</li>
      <li>&#x1F564;</li>
      <li>&#x1F565;</li>
      <li>&#x1F566;</li>
      <li>&#x1F567;</li>
      <li>&#x1F5FB;</li>
      <li>&#x1F5FC;</li>
      <li>&#x1F5FD;</li>
      <li>&#x1F5FE;</li>
      <li>&#x1F5FF;</li>
      <li>&#x1F600;</li>
      <li>&#x1F601;</li>
      <li>&#x1F602;</li>
      <li>&#x1F603;</li>
      <li>&#x1F604;</li>
      <li>&#x1F605;</li>
      <li>&#x1F606;</li>
      <li>&#x1F607;</li>
      <li>&#x1F608;</li>
      <li>&#x1F609;</li>
      <li>&#x1F60A;</li>
      <li>&#x1F60B;</li>
      <li>&#x1F60C;</li>
      <li>&#x1F60D;</li>
      <li>&#x1F60E;</li>
      <li>&#x1F60F;</li>
      <li>&#x1F610;</li>
      <li>&#x1F611;</li>
      <li>&#x1F612;</li>
      <li>&#x1F613;</li>
      <li>&#x1F614;</li>
      <li>&#x1F615;</li>
      <li>&#x1F616;</li>
      <li>&#x1F617;</li>
      <li>&#x1F618;</li>
      <li>&#x1F619;</li>
      <li>&#x1F61A;</li>
      <li>&#x1F61B;</li>
      <li>&#x1F61C;</li>
      <li>&#x1F61D;</li>
      <li>&#x1F61E;</li>
      <li>&#x1F61F;</li>
      <li>&#x1F620;</li>
      <li>&#x1F621;</li>
      <li>&#x1F622;</li>
      <li>&#x1F623;</li>
      <li>&#x1F624;</li>
      <li>&#x1F625;</li>
      <li>&#x1F626;</li>
      <li>&#x1F627;</li>
      <li>&#x1F628;</li>
      <li>&#x1F629;</li>
      <li>&#x1F62A;</li>
      <li>&#x1F62B;</li>
      <li>&#x1F62C;</li>
      <li>&#x1F62D;</li>
      <li>&#x1F62E;</li>
      <li>&#x1F62F;</li>
      <li>&#x1F630;</li>
      <li>&#x1F631;</li>
      <li>&#x1F632;</li>
      <li>&#x1F633;</li>
      <li>&#x1F634;</li>
      <li>&#x1F635;</li>
      <li>&#x1F636;</li>
      <li>&#x1F637;</li>
      <li>&#x1F638;</li>
      <li>&#x1F639;</li>
      <li>&#x1F63A;</li>
      <li>&#x1F63B;</li>
      <li>&#x1F63C;</li>
      <li>&#x1F63D;</li>
      <li>&#x1F63E;</li>
      <li>&#x1F63F;</li>
      <li>&#x1F640;</li>
      <li>&#x1F641;</li>
      <li>&#x1F642;</li>
      <li>&#x1F645;</li>
      <li>&#x1F646;</li>
      <li>&#x1F647;</li>
      <li>&#x1F648;</li>
      <li>&#x1F649;</li>
      <li>&#x1F64A;</li>
      <li>&#x1F64B;</li>
      <li>&#x1F64C;</li>
      <li>&#x1F64D;</li>
      <li>&#x1F64E;</li>
      <li>&#x1F64F;</li>
      <li>&#x1F680;</li>
      <li>&#x1F681;</li>
      <li>&#x1F682;</li>
      <li>&#x1F683;</li>
      <li>&#x1F684;</li>
      <li>&#x1F685;</li>
      <li>&#x1F686;</li>
      <li>&#x1F687;</li>
      <li>&#x1F688;</li>
      <li>&#x1F689;</li>
      <li>&#x1F68A;</li>
      <li>&#x1F68B;</li>
      <li>&#x1F68C;</li>
      <li>&#x1F68D;</li>
      <li>&#x1F68E;</li>
      <li>&#x1F68F;</li>
      <li>&#x1F690;</li>
      <li>&#x1F691;</li>
      <li>&#x1F692;</li>
      <li>&#x1F693;</li>
      <li>&#x1F694;</li>
      <li>&#x1F695;</li>
      <li>&#x1F696;</li>
      <li>&#x1F697;</li>
      <li>&#x1F698;</li>
      <li>&#x1F699;</li>
      <li>&#x1F69A;</li>
      <li>&#x1F69B;</li>
      <li>&#x1F69C;</li>
      <li>&#x1F69D;</li>
      <li>&#x1F69E;</li>
      <li>&#x1F69F;</li>
      <li>&#x1F6A0;</li>
      <li>&#x1F6A1;</li>
      <li>&#x1F6A2;</li>
      <li>&#x1F6A3;</li>
      <li>&#x1F6A4;</li>
      <li>&#x1F6A5;</li>
      <li>&#x1F6A6;</li>
      <li>&#x1F6A7;</li>
      <li>&#x1F6A8;</li>
      <li>&#x1F6A9;</li>
      <li>&#x1F6AA;</li>
      <li>&#x1F6AB;</li>
      <li>&#x1F6AC;</li>
      <li>&#x1F6AD;</li>
      <li>&#x1F6AE;</li>
      <li>&#x1F6AF;</li>
      <li>&#x1F6B0;</li>
      <li>&#x1F6B1;</li>
      <li>&#x1F6B2;</li>
      <li>&#x1F6B3;</li>
      <li>&#x1F6B4;</li>
      <li>&#x1F6B5;</li>
      <li>&#x1F6B6;</li>
      <li>&#x1F6B7;</li>
      <li>&#x1F6B8;</li>
      <li>&#x1F6B9;</li>
      <li>&#x1F6BA;</li>
      <li>&#x1F6BB;</li>
      <li>&#x1F6BC;</li>
      <li>&#x1F6BD;</li>
      <li>&#x1F6BE;</li>
      <li>&#x1F6BF;</li>
      <li>&#x1F6C0;</li>
      <li>&#x1F6C1;</li>
      <li>&#x1F6C2;</li>
      <li>&#x1F6C3;</li>
      <li>&#x1F6C4;</li>
      <li>&#x1F6C5;</li>
      <li>&#x203C;</li>
      <li>&#x2049;</li>
      <li>&#x2122;</li>
      <li>&#x2139;</li>
      <li>&#x2194;</li>
      <li>&#x2195;</li>
      <li>&#x2196;</li>
      <li>&#x2197;</li>
      <li>&#x2198;</li>
      <li>&#x2199;</li>
      <li>&#x21A9;</li>
      <li>&#x21AA;</li>
      <li>&#x23;&#x20E3;</li>
      <li>&#x231A;</li>
      <li>&#x231B;</li>
      <li>&#x23E9;</li>
      <li>&#x23EA;</li>
      <li>&#x23EB;</li>
      <li>&#x23EC;</li>
      <li>&#x23F0;</li>
      <li>&#x23F3;</li>
      <li>&#x24C2;</li>
      <li>&#x25AA;</li>
      <li>&#x25AB;</li>
      <li>&#x25B6;</li>
      <li>&#x25C0;</li>
      <li>&#x25FB;</li>
      <li>&#x25FC;</li>
      <li>&#x25FD;</li>
      <li>&#x25FE;</li>
      <li>&#x2600;</li>
      <li>&#x2601;</li>
      <li>&#x260E;</li>
      <li>&#x2611;</li>
      <li>&#x2614;</li>
      <li>&#x2615;</li>
      <li>&#x261D;</li>
      <li>&#x263A;</li>
      <li>&#x2648;</li>
      <li>&#x2649;</li>
      <li>&#x264A;</li>
      <li>&#x264B;</li>
      <li>&#x264C;</li>
      <li>&#x264D;</li>
      <li>&#x264E;</li>
      <li>&#x264F;</li>
      <li>&#x2650;</li>
      <li>&#x2651;</li>
      <li>&#x2652;</li>
      <li>&#x2653;</li>
      <li>&#x2660;</li>
      <li>&#x2663;</li>
      <li>&#x2665;</li>
      <li>&#x2666;</li>
      <li>&#x2668;</li>
      <li>&#x267B;</li>
      <li>&#x267F;</li>
      <li>&#x2693;</li>
      <li>&#x26A0;</li>
      <li>&#x26A1;</li>
      <li>&#x26AA;</li>
      <li>&#x26AB;</li>
      <li>&#x26BD;</li>
      <li>&#x26BE;</li>
      <li>&#x26C4;</li>
      <li>&#x26C5;</li>
      <li>&#x26CE;</li>
      <li>&#x26D4;</li>
      <li>&#x26EA;</li>
      <li>&#x26F2;</li>
      <li>&#x26F3;</li>
      <li>&#x26F5;</li>
      <li>&#x26FA;</li>
      <li>&#x26FD;</li>
      <li>&#x2702;</li>
      <li>&#x2705;</li>
      <li>&#x2708;</li>
      <li>&#x2709;</li>
      <li>&#x270A;</li>
      <li>&#x270B;</li>
      <li>&#x270C;</li>
      <li>&#x270F;</li>
      <li>&#x2712;</li>
      <li>&#x2714;</li>
      <li>&#x2716;</li>
      <li>&#x2728;</li>
      <li>&#x2733;</li>
      <li>&#x2734;</li>
      <li>&#x2744;</li>
      <li>&#x2747;</li>
      <li>&#x274C;</li>
      <li>&#x274E;</li>
      <li>&#x2753;</li>
      <li>&#x2754;</li>
      <li>&#x2755;</li>
      <li>&#x2757;</li>
      <li>&#x2764;</li>
      <li>&#x2795;</li>
      <li>&#x2796;</li>
      <li>&#x2797;</li>
      <li>&#x27A1;</li>
      <li>&#x27B0;</li>
      <li>&#x27BF;</li>
      <li>&#x2934;</li>
      <li>&#x2935;</li>
      <li>&#x2B05;</li>
      <li>&#x2B06;</li>
      <li>&#x2B07;</li>
      <li>&#x2B1B;</li>
      <li>&#x2B1C;</li>
      <li>&#x2B50;</li>
      <li>&#x2B55;</li>
      <li>&#x30;&#x20E3;</li>
      <li>&#x3030;</li>
      <li>&#x303D;</li>
      <li>&#x31;&#x20E3;</li>
      <li>&#x32;&#x20E3;</li>
      <li>&#x3297;</li>
      <li>&#x3299;</li>
      <li>&#x33;&#x20E3;</li>
      <li>&#x34;&#x20E3;</li>
      <li>&#x35;&#x20E3;</li>
      <li>&#x36;&#x20E3;</li>
      <li>&#x37;&#x20E3;</li>
      <li>&#x38;&#x20E3;</li>
      <li>&#x39;&#x20E3;</li>
      <li>&#xA9;</li>
      <li>&#xAE;</li>
      <li>&#xE50A;</li>
    </ul>
    <script>
    var ul = document.getElementsByTagName('ul')[0];
    var total = ul.getElementsByTagName('li').length;
    var elapsed = +new Date;
    twemoji.parse(ul, {"size":72});
    elapsed = (+new Date) - elapsed;
    document.body.insertBefore(
      //document.createTextNode(total + ' emoji parsed in ' + elapsed + 'ms'),
      document.body.firstChild
    );
    (function (img, metaKey, i) {
      function copyToClipboard(e) {
        prompt('Copy to clipboard via ' + metaKey + '+C and Enter', this.alt);
      }
      for (i = 0; i < img.length; img[i++].onclick = copyToClipboard) {}
    }(
      document.getElementsByTagName('img'),
      /\b(?:Mac |i)OS\b/i.test(navigator.userAgent) ? 'Command' : 'Ctrl'
    ));
    </script>
    <audio src="audio/beep.wav" preload="auto" id="audio_fb"></audio>
        <div id="esto_es_solo_prueba_de_contenido" class="container">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <form>
                            <div class="form-group">
                                <label for="usuarioRemitente">Usuario</label>
                                <select id="usuarioRemitente" name='usuarioRemitente' class="form-control">
                                    <option>Selecciona un usuario...</option>
                                    <option>Ricardo</option>
                                    <option>Tania</option>
                                    <option>Isaac</option>
                                    <option>Otro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect1">Example select</label>
                                <select class="form-control" id="exampleSelect1">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleSelect2">Example multiple select</label>
                                <select multiple class="form-control" id="exampleSelect2">
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleTextarea">Example textarea</label>
                                <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
                                <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                            </div>
                            <fieldset class="form-group">
                                <legend>Radio buttons</legend>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                                        Option one is this and that&mdash;be sure to include why it's great
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Option two can be something else and selecting it will deselect option one
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
                                        Option three is disabled
                                    </label>
                                </div>
                            </fieldset>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input">
                                    Check me out
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="chat">
            <div id="usuarios" class="seccion_chat">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h4>Selecciona un Usuario</h4>
                            <div id="lista_usuarios">
                                <ul class="list-group">
                                    <a class="list-group-item list-group-item-action cursor_pointer" id="123Ricardo">Ricardo
                                    <input type="radio" name="optradio" checked class="conectado">
                                   </a>
                                    <a class="list-group-item list-group-item-action cursor_pointer" id="123Tania">Tania</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer" id="123Isaac">Isaac</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Paty</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Carlos</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Roberto</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Paco</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Laura</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Otro</a>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>

           <div id="seccion_chat_1" class="seccion_chat">
                <div class="col">
                    <div class="row">
                        <div class="col mb-1">
                            <img class="minilogo" src="img/logoAbrigando.png">
                            <span class="ml-1">Conversacion 1</span>
                            <button type="button" class="close ml-1" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                             <button type="button" class="close" aria-label="Close">
                                <i class="fa fa-window-maximize" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="close" aria-label="Close">
                                <i class="fa fa-window-minimize" aria-hidden="true"></i>
                            </button>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <!--textarea id='log' class="form-control log" name='log' readonly='readonly'></textarea-->
                                <div id='log' class='log'></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <form id="enviarMensaje" class="form-inline"name="enviarMensaje" METHOD="POST">
                                <div class="form-group">
                                     <!--textarea class="form-control" id="message" rows="3" class="form-control mb-2 mr-sm-2 mb-sm-0 message"></textarea-->

                                    <input id="message" class="form-control mb-2 mr-sm-2 mb-sm-0 message" type="text" placeholder="Escribe un mensaje"  autocomplete="off"  required >
                                    <button id="enviar" class="btn btn-primary" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                </div>
                            </form>
                             <div id="escribiendo"></div>
                        </div>
                    </div>
                </div> 
            </div>

        </div>
        
        
<!--            <select id="usuarioRemitente" name='usuarioRemitente'>
                <option>Seleccionar...</option>
                <option>Ricardo</option>
                <option>Tania</option>
                <option>Isaac</option>
                <option>Otro</option>
            </select>
            <div id="inferior">
		<div id="logo"><img src="img/logoAbrigando.png"  width="30"></div>	
		<textarea id='log' name='log' readonly='readonly' rows="12"></textarea><br/>
		<form name="enviarMensaje" id="enviarMensaje" METHOD="POST">
                    <h4><span class="label label-primary">Mensaje</span></h4>
                    <input type='text' id='message' name='message' required placeholder="Escribe un mensaje"/>
                    input type='text' id='usuario' name='usuario' value="<?php echo $Usuario; ?>"
                    <button type="submit" class="btn btn-info btn-lg" id="enviar">
                    <span class="glyphicon glyphicon-send"></span>
                    </button>
                </form>
                img src="img/btn-enviar.png" width="35"
            </div>-->
        
    </body>
</html>