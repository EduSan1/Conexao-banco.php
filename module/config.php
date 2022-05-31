<?php
/*******************************************************************************************
 Objetivo: 
 Autor: Eduardo Santos Nascimento
Data: //
Versão 1.0
 ********************************************************************************************/

 const MAX_FILE_UPLOAD = 10240;
 const EXTENSION_FILE_UPLOAD= array("image/jpg", "image/png", "image/jpeg");
 const DIRECTORY_FILE_UPLOAD = "files/";

 define('SRC', $_SERVER['DOCUMENT_ROOT'].'/jorge/Professor/exercicio2005/');

/*******************            funcoes        ************/

function createJSON ($arrayDados) {
    if (!empty($arrayDados)){
    header('Content-Type: application/json');
    $arrayJSON = json_encode($arrayDados);
    return $arrayJSON;
    //json_decode

    }else {
        return false;
    }

}


?>