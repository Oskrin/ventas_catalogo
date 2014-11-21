<?php
session_start();
session_destroy();
include '../procesos/base.php';
conectarse();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>.:INGRESO AL SISTEMA:.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes"> 
        <link rel="stylesheet" type="text/css" href="../css/buttons.css"/>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="../css/jquery-ui-1.10.4.custom.css"/> 
        <link href="../css/font-awesome.css" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
        <link href="../css/pages/signin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="../css/alertify.core.css" />
        <link rel="stylesheet" href="../css/alertify.default.css" id="toggleCSS" />
        <link rel="stylesheet" href="../css/logo.css" id="logodc" />

        <script type="text/javascript" src="../js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script type="text/javascript" src="../js/jquery-ui-1.10.4.custom.min.js"></script>
        <script type="text/javascript" src="../js/validCampoFranz.js" ></script>
        <script type="text/javascript" src="../js/index.js"></script>
        <script type="text/javascript" src="../js/signin.js"></script>
        <script type="text/javascript" src="../js/alertify.min.js"></script>
    </head>

    <body style="background: url(../images/fondo.fw.png)no-repeat fixed center;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;">
        <div class="account-container">
            <div class="content clearfix">
                <form action="" method="post" name="form_admin">
                    <h1>Usuario</h1>
                    <div class="login-fields">
                        <p>Por favor, proporcione sus datos</p>
                        <div class="field">
                            <label for="empresa">Empresa:</label>
                            <select id="empresa" name="empresa" style="width: 100%; height: 40px">
                                <?php
                                $consulta = pg_query("select id_empresa, nombre_empresa from empresa");
                                while ($row = pg_fetch_row($consulta)) {
                                    echo "<option value=$row[0]>$row[1]</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="field">
                            <label for="username">Usuario:</label>
                            <input type="text" id="txt_usuario" name="txt_usuario" placeholder="Usuario" class="login username-field" />
                        </div> <!-- /field -->

                        <div class="field">
                            <label for="password">Password:</label>
                            <input type="password" id="txt_contra" name="txt_contra" placeholder="Constraseña" class="login password-field"/>
                        </div>
                    </div>

                    <div class="login-actions">
                        <span class="login-checkbox">
                            <input id="Field" name="Field" type="checkbox" class="field login-checkbox" value="First Choice" tabindex="4" />
                            <label class="choice" for="Field">Recordar conexión</label>
                        </span>
                        <button class="button btn btn-success btn-large" id="btnIngreso">Ingresar</button>
                    </div>
                </form>  
                <div id="crear_empresa" title="CREAR EMPRESA" class="">
                    <div class="widget-content">
                        <div class="tabbable">
                            <form class="form-horizontal" id="empresa_form" name="clientes_form" method="post" accept-charset="UTF-8">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="nombre_empresa">Nombre empresa: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="nombre_empresa"  id="nombre_empresa" placeholder="Empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="propietario_empresa">Propietario empresa: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="propietario_empresa"  id="propietario_empresa" placeholder=" Propietario Empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="slogan_empresa">Slogan empresa: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="descripcion_empresa"  id="descripcion_empresa" placeholder=" Slogan Empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="ruc_empresa">Ruc empresa: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="ruc_empresa"  id="ruc_empresa" placeholder=" Ruc empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="direccion_empresa">Dirección: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="direccion_empresa"  id="direccion_empresa" placeholder="Dirección empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="telefono_empresa">Telefóno: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="telefono_empresa"  id="telefono_empresa" placeholder="Telefóno empresa" maxlength="10" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="celular_empresa">Celular: </label>
                                        <div class="controls">
                                            <input type="text" name="celular_empresa"  id="celular_empresa" placeholder="Celular propietario" required maxlength="10" class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="pais_empresa">País: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="pais_empresa"  id="pais_empresa" placeholder="País empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="ciudad_empresa">Ciudad: <font color="red">*</font></label>
                                        <div class="controls">
                                            <input type="text" name="ciudad_empresa"  id="ciudad_empresa" placeholder="Ciudad empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group" style="display: none">
                                        <label class="control-label" for="fax_empresa">Fax: </label>
                                        <div class="controls">
                                            <input type="text" name="fax_empresa"  id="fax_empresa" placeholder="Fax empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="correo_empresa">E-mail: </label>
                                        <div class="controls">
                                            <input type="text" name="correo_empresa"  id="correo_empresa" placeholder="Correo empresa" required class="campo">
                                        </div>	
                                    </div>
                                    <div class="control-group" style="display: none">
                                        <label class="control-label" for="pagina_empresa">Página Web: </label>
                                        <div class="controls">
                                            <input type="text" name="pagina_empresa"  id="pagina_empresa" placeholder="Página web empresa" required class="campo">
                                        </div>	
                                    </div>
                                </fieldset>
                            </form>
                            <div class="form-actions">
                                <button class="btn btn-primary" id='btnGuardar'><i class="icon-save"></i> Guardar</button>
                                <button class="btn btn-primary" id='btnCancelar'><i class="icon-remove-sign"></i> Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="member span4">
                <div class="member-thumbnail">
                    <a href="#">
                        <img src="../images/system.jpg" alt="avatar" />
                    </a>
                </div>
                <ul class="member-menu">
                    <li class="path-wrapper">
                        <span class="overlay"></span>
                        <div class="member-data">
                            <h3>P&S Systems</h3>
                            <div class="position">Desarrollo de Software</div>
                        </div>

                    </li>
                </ul>
            </div>
        </div> 
    </body>
</html>