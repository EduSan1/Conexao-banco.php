<?php

/*******************************************************************************************
 Objetivo: Arquivo principal da API
 Autor: Eduardo Santos Nascimento
Data: 19/05/2022
Versão 1.0
 ********************************************************************************************/

//permite ativar quais paginas podem acessar a api
header('Access-Control-Allow-Origin: *');
//permite ativar quais metodos podem ser usados na nossa api
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//permite ativar o formato de dado que será utilizado
header('Access-Control-Allow-Header: Content-Type');
header('Content-Type: application/json ');

//recebe a url da requisição
$urlHTTP = (string) $_GET['url'];

$url = explode('/',$urlHTTP);

    switch(strtoupper($url[0])) {
        case'CONTATOS':
            require_once('contatosApi/index.php');
        case'ESTADOS':
            require_once('estadosApi/index.php');
        break;
    }

var_dump($url);
die;

?>