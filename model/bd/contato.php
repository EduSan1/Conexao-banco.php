<?php

    /**********************************************************************************************************
    
        Objetivo: arquivo responsável por manipular os dados dentro do Banco de Dados
                    (insert, update, select e delete)
        Autor: Eduardo Santos Nascimento
        Data: 25/02/2022
        Versão: 1.0
    
    **********************************************************************************************************/

    require_once("conexaoMysqlPhp.php");

    //função para realizar insert no bd
    function insertContato($dadoscontato) {
        // abre a conexão com o banco de dados
        $conexao = conexaoMysql();  

        $sql = "insert into tblcontatos (
            nome,
            telefone,
            celular,
            email,
            observacao
            )
            value
            ('".$dadoscontato['nome']."',
            '".$dadoscontato['telefone']."',
            '".$dadoscontato['celular']."',
            '".$dadoscontato['email']."',
            '".$dadoscontato['observacao']."');";

        mysqli_query($conexao,$sql);

    }
    //função para realizar update no bd
    function updateContato() {
        
    }
    //função para excluir no bd
    function deleteContato() {
        
    }
    //função para listar todos os contatos do bd
    function selectAllContato() {
        
    }

?>