<?php

/************************************************************************************************
    Objetivo: Arquivo de rota, para segmentar as ações encaminhadas pela View
    (dados de um form, listagem de dados, ação de excluir ou atualizar).
    Esse arquivo será responsável por encaminhar as solicitações para a Controller
    Autor:  
    Data:11/03/22
    Versão: 1.1
************************************************************************************************/


    $action = (string) null;
    $component = (string) null;

    //validação para verificar se a requisição é um POST de um formulário
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //recebendo dados da url e qual ação será executada
        $component = strtoupper($_GET['component']);
        $action = strtoupper($_GET['action']);

        $nome = $_POST['txtNome'];
        switch ($component){
            case 'CONTATOS':
                //importando a controllerContatos.hp
                require_once('controller/controllerContatos.php');
                //verifica o action passado para o action
                if ($action == 'INSERIR') {
                    //passa o objeto post para a verificação na controller
                    inserirContato($_POST);
                }
            break;
        }
    }

    
?>