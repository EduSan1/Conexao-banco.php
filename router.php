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
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET') {
    //recebendo dados da url e qual ação será executada
    $component = strtoupper($_GET['component']);
    $action = strtoupper($_GET['action']);

    switch ($component) {
        case 'CONTATOS':
            //importando a controllerContatos.hp
            require_once('controller/controllerContatos.php');
            //verifica o action passado para o action
            if ($action == 'INSERIR') {

                var_dump($_FILES);
                die;

                if (isset($_FILES) && !empty($_FILES)) {
                    //passa o objeto post para a verificação na controller
                    $resposta = inserirContato($_POST, $_FILES);
                } else {
                    //passa o objeto post para a verificação na controller
                    $resposta = inserirContato($_POST, null);
                }


                //verifica se o retorno de inserirContato($_POST) é boolean
                if (is_bool($resposta)) {
                    //verifica se o retorno de inserirContato($_POST) é true
                    if ($resposta) {
                        //envia um script com um alerta e após isso retornando para a index
                        echo ("<script>
                       alert('Registro inserido com sucesso');
                       window.location.href = 'index.php';
                       </script>");
                    }
                    //verifica se o retorno de inserirContato($_POST) é um array
                } elseif (is_array($resposta)) {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('" . $resposta["message"] . "');
                    window.location.href = 'index.php';
                    </script>");
                    //verifica se o retorno de inserirContato($_POST) não é um array nem um boolean
                } else {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('CARAI MENÓ, COMO TU FEZ ISSO??');
                    window.location.href = 'index.php';
                    </script>");
                }
            } else if ($action == 'DELETAR') {
                // echo($action);
                $id = strtoupper($_GET['id']);
                $foto = strtoupper($_GET['foto']);

                $arrayDados = array(
                    "id" => $id,
                    "foto" => $foto
                );
                
                $resposta = excluirContato($arrayDados);

                if (is_bool($resposta)) {
                    echo ("<script>
                    alert('Contato excluido do banco de dados');
                    window.location.href = 'index.php';
                    </script>");
                } elseif (is_array($resposta)) {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('" . $resposta["message"] . "');
                    window.location.href = 'index.php';
                    </script>");
                    //verifica se o retorno de inserirContato($_POST) não é um array nem um boolean
                } else {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('CARAI MENÓ, COMO TU FEZ ISSO??');
                    window.location.href = 'index.php';
                    </script>");
                }
            } else if ($action == "BUSCAR") {

                //recebe o id do registro que deverá ser editado, que foi enviado 
                //pela url do link da imagem do editar que foi acionado na index
                $id = strtoupper($_GET['id']);

                //chama a função de excluir  na controller
                $dado = buscarContato($id);

                session_start();

                $_SESSION['dadosContato'] = $dado;

                // header('location: index.php');

                require_once('index.php');
            } else if ($action == 'EDITAR') {

                $idContato = $_GET['id'];
                $foto = $_GET['foto'];

                $arrayDados = array (
                    'id' => $idContato,
                    'foto' => $foto,
                    'file' => $_FILES
                );

                $resposta = atualizarContato($_POST, $arrayDados);

                //verifica se o retorno de inserirContato($_POST) é boolean
                if (is_bool($resposta)) {
                    //verifica se o retorno de inserirContato($_POST) é true
                    if ($resposta) {
                        //envia um script com um alerta e após isso retornando para a index
                        echo ("<script>
                       alert('Registro atualizado com sucesso');
                       window.location.href = 'index.php';
                       </script>");
                    }
                    //verifica se o retorno de inserirContato($_POST) é um array
                } elseif (is_array($resposta)) {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('" . $resposta["message"] . "');
                    window.location.href = 'index.php';
                    </script>");
                    //verifica se o retorno de inserirContato($_POST) não é um array nem um boolean
                } else {
                    //envia um script com um alerta e após isso retornando para a index
                    echo ("<script>
                    alert('CARAI MENÓ, COMO TU FEZ ISSO??');
                    window.location.href = 'index.php';
                    </script>");
                }
            }
            break;
    }
}
