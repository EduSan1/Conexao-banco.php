<?php

/*******************************************************************************************
 Objetivo: arquivo responsável pela manipulação de dados de contatos
 Obs: esse arquivo fará a ponte entre a View e a Model
 Autor: Eduardo Santos Nascimento
Data: 04/03/2022
Versão 1.0
********************************************************************************************/

//função para receber dados da View e encaminhar para a Model (inserir)
//ira receber todos os dados do nosso formulário
function inserirContato ($dadosContato) {
    //verificar se dados contato possui algo 
    //empty verifica se um array está vazio
    if(!empty($dadosContato)) {
        //validação dos campos  nome, celular e email, pois são campos obrigatórios
        if(!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])) {
            //criação do array de dados que será encaminhado a model para iniciar no db
            //é importante criar o array por conta das necessidades  do bd
            //OBS: criar as chaves do array conforme os nomes dos atributos do bd
            $arrayDados = array (
                'nome' => $dadosContato['txtNome'],
                'telefone' => $dadosContato['txtTelefone'],
                'celular' => $dadosContato['txtCelular'],
                'email' => $dadosContato['txtEmail'],
                'observacao' => $dadosContato['txtObs']
            );

            require_once("./model/bd/contato.php");

            InsertContato($arrayDados);

        }else {
            echo('dados não validos');
        }
    }

}
//função para rrceber dados da View e encaminhar para a Model (atualizar)
function atualizarContato () {
    
}
//função para rrceber dados da View e encaminhar para a Model (excluir)
function excluirContato () {
    
}
//função para rrceber dados da View e encaminhar para a Model
function listarContato () {
    
}
