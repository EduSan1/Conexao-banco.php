<?php

/*******************************************************************************************
 Objetivo: arquivo responsável pela manipulação de dados de estados
 Obs: esse arquivo fará a ponte entre a View e a Model
 Autor: Eduardo Santos Nascimento
Data: 04/03/2022
Versão 1.0
 ********************************************************************************************/

function listarEstados(){
    //import do arquivo que vai buscar os dados do bd
    require_once('model/bd/estado.php');
    //chama a função que vai buscar os dados do bd
    $dados = selectAllEstados();

    if (!empty($dados)) {
        return $dados;
    } else {
        return false;
    }
}

function buscarEstado($id) {
    
    require_once('model/bd/estado.php');

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        $dado = selectByIdEstado($id);
        if (!empty($dado)) {
            return $dado;
        } else {
            return false;
        }

    }else
    return array(
        'idErro'  => 5,
        'message' => 'informe um id validado'
    );

}