<?php
if (empty($_SESSION['id'])) {
    header('Location: index.php');
}

function menu_1() {
    print(' <ul id="main-menu" class="sm sm-blue">
            <li><a href="../html/principal.php" target="_parent" class="inicio"><i class="icon-home"></i> Inicio</a></li>
            <li><a href="" target="_parent"> <i class="icon-th-large"></i> Ingresos</a>
                <ul>
                    <li><a href="../html/registro_clientes.php" target="_blank">Clientes</a></li>
                    <li><a href="../html/proformas.php"target="_blank">Subir Proforma</a></li>
                </ul>
            </li>
                      
            <li><a href="" target="_parent"><i class="icon-bookmark"></i> Bienvenido</a>
                <ul>
                    <li><a href="" class="disabled">' . $_SESSION['nombres'] . '</a></li>
                    <li><a href="../html/index.php">Salir</a></li>
                </ul>
            </li>
        </ul>');
}
?>


