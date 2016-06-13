<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: portada.phtml');
}
if (isset($_POST['cerrar'])) {
    session_destroy();
    header('Location: portada.phtml');
}
?>
  <html>

  <head>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/portada/default.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <title>Universal Cloud</title>
  </head>

  <body onresize="resize()">
    <div id="wrapper">
      <div id="top_nav">
        <div id="logo"></div>
        <div id="herramientas">
          <div id="add_disks">
            <i class="fa fa-plus-square-o" aria-hidden="true"></i>
            <span id="bot-add-disks" onclick=" mostrarFormularioFTP()">Añadir FTP</span>
            <div id='add-ftp' class="ftp-cerrado">
              <form id='formulario-add-ftp' enctype='multipart/form-data' method='post' name='formulario-add-ftp'>
                <label id='lserver' for='server'>Servidor:</label>
                <input id='server' type='text' name='server'>
                <label id='lport' for='port'>Puerto:</label>
                <input id='port' type='text' name='port'>
                <label id='luser' for='user'>Usuario:</label>
                <input id='user' type='text' name='user'>
                <label id='lpassword' for='password'>Contraseña:</label>
                <input id='password' type='password' name='password'>
                <input type='submit' class="btn" id='button' value='Añadir'>
              </form>
              <div id='resultado-registro-ftp'>
                <div></div>

              </div>
            </div>
          </div>
          <div id="sub-archivo">
            <i class="fa fa-cloud-upload" aria-hidden="true"></i>
            <span id="bot-sub-archivo">Subir Archivo</span>
            <div class="upload-cerrado" id="upload">
              <div class="field">
                <ul class="options">
                  <li>
                    <input type="file" id="myfile" name="myfile" class="rm-input btn" onchange="selectedFile();" />
                  </li>
                  <li>
                    <div id="fileSize">Tamaño:</div>
                  </li>
                  <li>
                    <div id="fileType">Tipo:</div>
                  </li>
                  <li>
                    <input type="button" value="Subir Archivo" onClick="uploadFile()" class="rm-button btn" />
                  </li>
                </ul>
              </div>
              <div id="progreso-upload">
                <progress id="progressBar" value="0" max="100" class="rm-progress"></progress>
                <div id="percentageCalc">0%</div>
              </div>
            </div>
          </div>
          <div id="crear-carpeta">
            <i class="fa fa-folder-open" aria-hidden="true"></i>
            <span id="bot-crear-carpeta">Crear carpeta</span>
            <div class="carpeta-cerrado" id="carpeta">
              <div class="field">
                <ul class="options">
                  <li>
                    <input type="text" id="nombre-carpeta" name="nombre" placeholder="Introduce el nombre" class="rm-input" onchange="selectedFile();" />
                  </li>
                  <li>
                    <input type="button" value="Crear Carpeta" onClick="crearCarpeta()" class="rm-button btn" />
                  </li>
                  <li>
                    <div id="crear-carpeta-resultado"></div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div id="actualizar">
            <i class="fa fa-refresh" aria-hidden="true"></i>
            <span>Actualizar</span>
          </div>
          <div id="raiz">
            <i class="fa fa-reply-all" aria-hidden="true"></i>
            <span>Volver a Raíz</span>
          </div>
          <div id="lista-mosaico">
            <button class="view-buttons" id="boton-lista"><i class="fa fa-th-list" aria-hidden="true"></i></button>
            <button class="view-buttons" id="boton-mosaico"><i class="fa fa-th" aria-hidden="true"></i></button>
            <button class="view-buttons" id="boton-columnas"><i class="fa fa-columns" aria-hidden="true"></i></i>
            </button>
          </div>
          <div id="cerrar-sesion">
            <form method="post" action="index.php">
              <input type="submit" id="boton-cerrar-sesion" name="cerrar" value="Cerrar Sesion">
            </form>
          </div>
        </div>
      </div>
      <div id="explorer">
        <div id="sidebar-left">

        </div>
        <div id="menuSecundario">
          <div id="sm-eliminar" class="sm-style"><i class="fa fa-trash" aria-hidden="true"></i>&nbsp;&nbsp;Eliminar</div>
          <div id="sm-mover" class="sm-style"><i class="fa fa-clipboard" aria-hidden="true"></i>&nbsp;&nbsp;Mover</div>
          <div id="sm-copiar" class="sm-style"><i class="fa fa-files-o" aria-hidden="true"></i>&nbsp;&nbsp;Copiar</div>
          <div id="sm-renombrar" class="sm-style"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;&nbsp;Renombrar</div>
          <div id="sm-descargar" class="sm-style"><i class="fa fa-download" aria-hidden="true"></i>&nbsp;&nbsp;Descargar</div>
        </div>
        <div id="explorer-content"></div>
        <div id="sidebar-right">
          <h3 id="nav-title">Navegador &nbsp; &nbsp;<i class="fa fa-refresh" aria-hidden="true" onclick="listarNavegador();"></i></h3>
          <div id="sidebar-right-content"></div>
        </div>
      </div>
      <div id="bottom_nav">
        <div id="espacio-usado"></div>
        <div id="arbol"><i class="fa fa-arrows-h" aria-hidden="true"></i>&nbsp;&nbsp; NAVEGADOR</div>
      </div>
    </div>

    <script src="js/explorer/actualizar-ftp.js"></script>
    <script src="js/explorer/add-ftp.js"></script>
    <script src="js/explorer/ajax-listar.js"></script>
    <script src="js/explorer/herramientas.js"></script>
    <script src="js/explorer/lista-mosaico.js"></script>
    <script src="js/explorer/seleccion.js"></script>
    <script src="js/explorer/arbol.js"></script>
    <script src="js/explorer/escalado.js"></script>
    <script src="js/explorer/buscador.js"></script>
  </body>

  </html>