<?php
namespace Dwes\ProyectoVideoclub;
session_start();
session_destroy();
header("Location: index.php");
?>