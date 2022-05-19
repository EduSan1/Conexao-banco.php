<?php

/**********************************************************************************************************
    
        Objetivo: arquivo responsável por manipular os dados dentro do Banco de Dados
                    (insert, update, select e delete)
        Autor: Eduardo Santos Nascimento
        Data: 10/05/2022
        Versão: 1.0
    
 **********************************************************************************************************/
require_once("conexaoMysqlPhp.php");

function selectAllEstados(){
    $conexao = conexaoMysql();
    $sql = "select * from tblestado order by nome asc";
    $result = mysqli_query($conexao, $sql);

    if ($result) {

        $cont = 0;
        while ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados[$cont] = array(
                "idEstado"       => $rsDados['idEstado'],
                "nome"       => $rsDados['nome'],
                "sigla"   => $rsDados['sigla']
            );
            $cont++;
        };
        fecharConexaoMysql($conexao);
        return $arrayDados;
    } else {
        fecharConexaoMysql($conexao);                        
        return array(
            'idErro'  => 3,
            'message' => 'Não foi encontrado no banco'
        );
    }
}

function selectByIdEstado($id){

    $conexao = conexaoMysql();

    $sql = "select * from tblestado where idestado = ".$id;


    $result = mysqli_query($conexao, $sql);

    if ($result) {

        if ($rsDados = mysqli_fetch_assoc($result)) {
            $arrayDados = array(
                "idEstado"       => $rsDados['idEstado'],
                "nome"       => $rsDados['nome'],
                "sigla"   => $rsDados['sigla']
            );
        };
        fecharConexaoMysql($conexao);

        return $arrayDados;

    } else {
        fecharConexaoMysql($conexao);                        
        return array(
            'idErro'  => 3,
            'message' => 'Não foi encontrado no banco'
        );
    }
}