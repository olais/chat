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

		

		var usuario="<?php echo $_REQUEST['Usuario']; ?>";
		
		var usuarioDestino="Tania";



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
        if(res[1]==usuario || res[0]==usuario){//aqui será la variable de sesión
			$log = $('#log');
		    $log.append(($log.val()?"\n":'')+res[0]+": "+res[2]);
			$log[0].scrollTop = $log[0].scrollHeight - $log[0].clientHeight;
		
		 }
		}

		function send( text ) {
			Server.send( 'message', text );
		}

		$(document).ready(function() {
			//log('Conectando...');
			$("#message").focus();
			Server = new FancyWebSocket('ws://192.168.201.106:9300');
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
                                    <a class="list-group-item list-group-item-action cursor_pointer">Ricardo</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Tania</a>
                                    <a class="list-group-item list-group-item-action cursor_pointer">Isaac</a>
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
                            <button type="button" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <textarea id='log' class="form-control log" name='log' readonly='readonly'></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <form id="enviarMensaje" class="form-inline"name="enviarMensaje" METHOD="POST">
                                <div class="form-group">
                                    <input id="message" class="form-control mb-2 mr-sm-2 mb-sm-0 message" type="text" placeholder="Escribe un mensaje">
                                    <button id="enviar" class="btn btn-primary" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        
        
<!--            <select id="usuarioRemitente" name='usuarioRemitente'>
                <option>Seleccionar...</option>
                <option>Ricardo</option>
                <option>Tania</option>
                <option>Isacc</option>
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