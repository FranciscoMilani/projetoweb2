<?php 

    include_once 'dao/DaoFactory.php';
    include_once 'dao/PostgresDaoFactory.php';
    
    include_once 'dao/UsuarioDao.php';
    include_once 'dao/ElaboradorDao.php';
    
    include_once 'model/Usuario.php';
    include_once 'model/Elaborador.php';

    // não printa Notices
    error_reporting(E_ERROR | E_USER_ERROR);

    $factory = new PostgresDaoFactory();
?>