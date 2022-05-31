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

require_once(SRC . 'module/config.php');

function inserirContato($dadosContato)
{

    $file  = $dadosContato['file'];

    $photoName = (string) null;

    //verificar se dados contato possui algo 
    //empty verifica se um array está vazio
    if (!empty($dadosContato)) {
        //validação dos campos  nome, celular e email, pois são campos obrigatórios
        if (!empty($dadosContato[0]['nome']) && !empty($dadosContato[0]['celular']) && !empty($dadosContato[0]['email']) && !empty($dadosContato[0]['estado'])) {

            //verifica se chegou um arquivp para upload
            if ($file['foto']['name'] != null) {
                require_once(SRC . 'module/upload.php');
                $photoName = uploadFile($file["foto"]);
                // se for um array retorna o erro qu ta no array da variavel
                if (is_array($photoName)) {
                    return $photoName;
                }
            }

            //criação do array de dados que será encaminhado a model para iniciar no db
            //é importante criar o array por conta das necessidades  do bd
            //OBS: criar as chaves do array conforme os nomes dos atributos do bd
            $arrayDados = array(
                'nome' => $dadosContato[0]['nome'],
                'telefone' => $dadosContato[0]['telefone'],
                'celular' => $dadosContato[0]['celular'],
                'email' => $dadosContato[0]['email'],
                'observacao' => $dadosContato[0]['observacao'],
                'estado' => $dadosContato[0]['estado'],
                'nomeFoto'  => $photoName
            );

            //import do arquivo de modlagem para mannipular o BD
            require_once(SRC . "./model/bd/contato.php");
            //Chama a função para mandar os dados pro banco (localizado na model)
            if (InsertContato($arrayDados)) {
                return true;
            } else
                return array(
                    'idErro'  => 2,
                    'message' => 'deu ruim na hora de inserir os dados no banco de dados'
                );
        } else {
            return array(
                'idErro'  => 1,
                'message' => 'Exitem campos obrigatórios que não foram preenchidos      '
            );
        }
    }
}
//função para receber dados da View e encaminhar para a Model (atualizar)
function atualizarContato($dadosContato)
{

    $id = $dadosContato['id'];
    $foto = $dadosContato['foto'];
    $file = $dadosContato['file'];


    if (!empty($dadosContato)) {
        //validação dos campos  nome, celular e email, pois são campos obrigatórios
        if (!empty($dadosContato[0]['nome']) && !empty($dadosContato[0]['celular']) && !empty($dadosContato[0]['email'])  && !empty($dadosContato[0]['estado'])) {

            if (!empty($id) && $id != 0 && is_numeric($id)) {

                if ($file["foto"]["name"] != null) {
                    require_once(SRC.'module/upload.php');
                    $novaFoto = uploadFile($file["foto"]);
                    require_once(SRC.'module/config.php');

                    unlink(SRC . DIRECTORY_FILE_UPLOAD . $foto);
                } else {
                    $novaFoto = $foto;
                }
                $arrayDados = array(
                    'id'         => $id,
                    'nome'       => $dadosContato[0]['nome'],
                    'telefone'   => $dadosContato[0]['telefone'],
                    'celular'    => $dadosContato[0]['celular'],
                    'email'      => $dadosContato[0]['email'],
                    'estado'     => $dadosContato[0]['estado'],
                    'observacao' => $dadosContato[0]['observacao'],
                    'foto'       => $novaFoto
                );

                //import do arquivo de modlagem para mannipular o BD
                require_once(SRC . "./model/bd/contato.php");
                //Chama a função para mandar os dados pro banco (localizado na model)
                if (updateContato($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 2,
                        'message' => 'deu ruim na hora de editar os dados no banco de dados'
                    );
            } else
                return array(
                    'idErro'  => 5,
                    'message' => 'informe um id validado'
                );
        } else {
            return array(
                'idErro'  => 1,
                'message' => 'Exitem campos obrigatórios que não foram preenchidos      '
            );
        }
    }
}
//função para receber dados da View e encaminhar para a Model (excluir)
function excluirContato($arrayDados)
{

    $id = $arrayDados['id'];
    $foto = $arrayDados['foto'];

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        require_once(SRC . 'model/bd/contato.php');

        if (deleteContato($id)) {

            if ($foto != null) {
                // require_once('module/config.php');
                //permite apagar a foto fisicamente do diretório no servidor
                unlink(SRC . DIRECTORY_FILE_UPLOAD . $foto);
            }
            return true;
        } else
            return  array(
                'idErro'  => 4,
                'message' => 'o banco de dados não pode excluir o registro'
            );
    } else
        return array(
            'idErro'  => 5,
            'message' => 'informe um id validado'
        );
}
//função para receber dados da View e encaminhar para a Model
function listarContato()
{
    //import do arquivo que vai buscar os dados do bd
    require_once(SRC . 'model/bd/contato.php');
    //chama a função que vai buscar os dados do bd
    $dados = selectAllContato();

    if (!empty($dados)) {
        return $dados;
    } else {
        return false;
    }
}

function buscarContato($id)
{

    require_once(SRC . 'model/bd/contato.php');

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        $dado = selectByIdContato($id);
        if (!empty($dado)) {
            return $dado;
        } else {
            return false;
        }
    } else
        return array(
            'idErro'  => 5,
            'message' => 'informe um id validado'
        );
}
