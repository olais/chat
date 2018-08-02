<!doctype html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Expires" content="<?php date("D").", ".date("d")." ".date("M")." ".date("Y")." 23:00:00 GMT" ?>">
        <meta http-equiv="Pragma" content="no-cache">
        <!--jQuery-->
        <script src="dist/jquery/jquery-3.3.1.min.js"></script>
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
        <!--Scroll Top-->
        <link rel="stylesheet" href="dist/scrolltop/css/scroll.top.css">
        <script src="dist/scrolltop/js/scroll.top.js"></script>
        <!--Scroll Top-->
	<style>
		input, textarea {border:1px solid #CCC;margin:0px;padding:0px}

		
		#log {width:330px;}
		#message {width:275px;line-height:40px;font-size: 20px;color:#000;border-radius: 7px;}

		
		#inferior {
	    color: #4CAF50;
	    background: #fff;
	    position: fixed;
	    right: 0px;
	    bottom: 10px;
	    z-index: 100;
	    height: 380px;
	    width: 350px;
	    border-style: groove;
	    border-color: #46b8da;
	    border-radius: 7px;
	    padding: 5px;
	}




	</style>
	<script src="js/fancywebsocket.js"></script>
        

	<script>
		var Server;

		

		var usuario="<?php echo $_REQUEST['Usuario']; ?>";
		
		//var usuarioDestino="Ricardo";



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
		alert(res);

		//alert(res[0]);
         if(res[1]==usuario || res[0]==res[1]){//aqui será la variable de sesión
			$log = $('#log');
		    $log.append(($log.val()?"\n":'')+res[0]+":"+res[2]);
			$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
		
		 }
		}

		function send( text ) {
			Server.send( 'message', text );
		}

		$(document).ready(function() {
			//log('Conectando...');
			$("#message").focus();
			Server = new FancyWebSocket('ws://192.168.0.8:9300');
        	$('#enviarMensaje').submit(function() {
				//if ( e.keyCode == 13 && this.value ) {
					
					mensaje=usuario+','+$("#usuarioRemitente").val()+','+$('#message').val();//usuario a comunicar
				    log(mensaje);

					send(mensaje);
					$('#message').val('');
					return false;
				//}
			});

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


<!--div class="row">
    <div class="col-sm-4" style="background-color:lavender;">

   <table class="table table-striped">
    <thead>
      <tr>
        <th>Perfil</th>
        <th>Nombre</th>
        <th>Usuario</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td> <a href="#">
          <span class="glyphicon glyphicon-user"></span>
        </a></td>
        <td>Ricardo</td>
        <td>rhernandez@imprimart.com.mx </td>
        <td><img src="img/btn-enviar.png" width="35"></td>
      </tr>
      <tr>
        <td> <a href="#">
          <span class="glyphicon glyphicon-user"></span>
        </a></td>
        <td>Moe</td>
        <td>mary@example.com</td>
        <td><img src="img/btn-enviar.png" width="35"></td>
      </tr>
      <tr>
        <td> <a href="#">
          <span class="glyphicon glyphicon-user"></span>
        </a></td>
        <td>Dooley</td>
        <td>july@example.com</td>
        <td><img src="img/btn-enviar.png" width="35"></td>
      </tr>
    </tbody>
  </table>



    </div>
    <div class="col-sm-4" style="background-color:lavenderblush;">

    </div>
    <div class="col-sm-4" style="background-color:lavender;">

    </div>
  </div-->
	<select name='usuarioRemitente' id="usuarioRemitente">
		<option>Seleccionar...</option>
		<option>Ricardo</option>
		<option>Tania</option>
		<option>Prueba</option>
		<option>Otro</option>

	</select>
	<div id="inferior">
		<div id="logo"><img src="img/logoAbrigando.png"  width="123"></div>	
		<textarea id='log' name='log' readonly='readonly' rows="7"></textarea><br/>
		<form name="enviarMensaje" id="enviarMensaje" METHOD="POST">
		 <h4><span class="label label-primary">Mensaje</span></h4>
		<input type='text' id='message' name='message' required placeholder="Escribe un mensaje"/>
		<!--input type='text' id='usuario' name='usuario' value="<?php echo $Usuario; ?>"-->
		<button type="submit" class="btn btn-info btn-lg" id="enviar">
        <span class="glyphicon glyphicon-send"></span>
        </button>
   	   </form>
		<!--img src="img/btn-enviar.png" width="35"-->

	</div>

</body>

</html>