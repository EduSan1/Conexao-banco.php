<?php

/*
    * Request - recebe dados do corpo da requisição(JSON, FORM/DATA, XML e etc)
    * Respose - retorna dados para quem solicitou
    * Args - Permite receber dados de atributos na API
    */

use Slim\Http\Response;

require_once('vendor/autoload.php');


$app = new \Slim\App();



$app->get('/contatos', function ($request, $response, $args) {
    // $response->write('Testando a API pelo get');
    require_once('../module/config.php');
    require_once('../controller/controllerContatos.php');

    if ($dados = listarContato()) {

        if ($dadosJSON = createJSON($dados)) {
            return $response
                ->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write($dadosJSON);
        } else {
            return $response->withStatus(204);
        }
    } else {
        return $response
            ->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write("deu ruim na hora de listar os contatos");
    }
});

$app->get('/contatos/{id}', function ($request, $response, $args) {
    require_once('../module/config.php');
    require_once('../controller/controllerContatos.php');

    $id = $args['id'];


    if ($dados = buscarContato($id)) {


        if (!isset($dados['idErro'])) {
            if ($dadosJSON = createJSON($dados))
                $response->write($dadosJSON);
            else
                $response->write("deu ruim na hora de converter para JSON");
        } else {
            $dadosJSON = createJSON($dados);

            return $response->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write('{"message": "Dados Invalidos",
                          "Erro":' . $dadosJSON . '}');
        }
    } else {
        $response->write("deu ruim na hora de listar os contatos");
    }
});

$app->delete('/contatos/{id}', function ($request, $response, $args) {
    require_once('../module/config.php');
    require_once('../controller/controllerContatos.php');

    if (is_numeric($args['id'])) {
        $id = $args['id'];

        if ($dados = buscarContato($id)) {

            $foto = $dados['nomeFoto'];

            $arrayDados = array(
                "id" => $id,
                "foto" => $foto
            );

            $resposta = excluirContato($arrayDados);

            if ($resposta == true && is_bool($resposta)) {
                return $response
                    ->withStatus(200)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"message":"Registro excluido com sucesso"}');
            } else if (is_array($resposta) && isset($resposta['idErro'])) {

                $dadosJSON = createJSON($resposta);

                return $response
                    ->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"message": "Dados Invalidos",
                "Erro":' . $dadosJSON . '}');
            } else {
                return $response
                    ->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write("o id informado n existe no banco de dados");
            }
        } else {
            return $response->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write('{"message": "Tem o id não "}');
        }
    } else {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"message": "Dados Invalidos"}');
    }
});

$app->post('/contatos', function ($request, $response, $args) {

    require_once('../module/config.php');
    require_once('../controller/controllerContatos.php');

    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    $contentType  = explode(";", $contentTypeHeader);

    switch ($contentType[0]) {
        case "multipart/form-data";
            $dadosBody = $request->getParsedBody();
            $uploadFiles = $request->getUploadedFiles();

            $arrayFoto = array(
                "name" => $uploadFiles['foto']->getClientFileName(),
                "type" => $uploadFiles['foto']->getClientMediaType(),
                "size" => $uploadFiles['foto']->getSize(),
                "tmp_name" => $uploadFiles['foto']->file
            );
            $file = array("foto" => $arrayFoto);

            $arrayDados = array(
                $dadosBody,
                "file" => $file
            );

            $resposta = inserirContato($arrayDados);


            if ($resposta == true && is_bool($resposta)) {
                echo ("deu bom");
            } else {
                echo ("deu ruim");
            }

            break;
        case "application/json";
            $dadosBody = $request->getParsedBody();

            break;
        default:
            return $response
                ->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write('{"message": "Formato inválido, envie um form-date ou um json"}');
    }
});

$app->post('/contatos/{id}', function ($request, $response, $args) {

    if (is_numeric($args['id'])) {
        $id = $args['id'];

        require_once('../module/config.php');
        require_once('../controller/controllerContatos.php');

        $contato = buscarContato($id);
        $foto = $contato["nomeFoto"];

        $contentTypeHeader = $request->getHeaderLine('Content-Type');
        $contentType  = explode(";", $contentTypeHeader);

        switch ($contentType[0]) {
            case "multipart/form-data";
                $dadosBody = $request->getParsedBody();
                $uploadFiles = $request->getUploadedFiles();

                $arrayFoto = array(
                    "name" => $uploadFiles['foto']->getClientFileName(),
                    "type" => $uploadFiles['foto']->getClientMediaType(),
                    "size" => $uploadFiles['foto']->getSize(),
                    "tmp_name" => $uploadFiles['foto']->file
                );
                $file = array("foto" => $arrayFoto);

                $arrayDados = array(
                    $dadosBody,
                    "id" => $id,
                    "foto" => $foto,
                    "file" => $file
                );

         

                $resposta = atualizarContato($arrayDados);

                if ($resposta == true && is_bool($resposta)) {
                    echo ("deu bom");
                } else {
                    var_dump($resposta);
                }

                break;
            case "application/json";
                $dadosBody = $request->getParsedBody();

                break;
            default:
                return $response
                    ->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"message": "Formato inválido, envie um form-date ou um json"}');
        }
    }
});

$app->run();
