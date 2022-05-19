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
function inserirContato($dadosContato, $file){

    $photoName = (string) null;

    //verificar se dados contato possui algo 
    //empty verifica se um array está vazio
    if (!empty($dadosContato)) {
        //validação dos campos  nome, celular e email, pois são campos obrigatórios
        if (!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail']) && !empty($dadosContato['sltEstado'])) {

            //verifica se chegou um arquivp para upload
            if ($file['flPhoto']['name'] != null) {
                require_once('module/upload.php');
                $photoName = uploadFile($file["flPhoto"]);
                // se for um array retorna o erro qu ta no array da variavel
                if (is_array($photoName)){
                    return $photoName;
                }
            }

            //criação do array de dados que será encaminhado a model para iniciar no db
            //é importante criar o array por conta das necessidades  do bd
            //OBS: criar as chaves do array conforme os nomes dos atributos do bd
            $arrayDados = array(
                'nome' => $dadosContato['txtNome'],
                'telefone' => $dadosContato['txtTelefone'],
                'celular' => $dadosContato['txtCelular'],
                'email' => $dadosContato['txtEmail'],
                'observacao' => $dadosContato['txtObs'],
                'estado' => $dadosContato['sltEstado'],
                'nomeFoto'  => $photoName
            );

            //import do arquivo de modlagem para mannipular o BD
            require_once("./model/bd/contato.php");
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
function atualizarContato($dadosContato,$array){

    $id = $array['id'];
    $foto = $array['foto'];
    $file = $array['file'];

    if (!empty($dadosContato)) {
        //validação dos campos  nome, celular e email, pois são campos obrigatórios
        if (!empty($dadosContato['txtNome']) && !empty($dadosContato['txtCelular']) && !empty($dadosContato['txtEmail'])) {

            if (!empty($id) && $id != 0 && is_numeric($id)) {

                if ($file["flPhoto"]["name"] != null) {
                    require_once('module/upload.php');
                    $novaFoto = uploadFile($file["flPhoto"]);
                    require_once('module/config.php');
                //permite apagar a foto fisicamente do diretório no servidor
                unlink(DIRECTORY_FILE_UPLOAD.$foto);
                }else {
                    $novaFoto = $foto;
                }
                $arrayDados = array(
                    'id'         => $id,
                    'nome'       => $dadosContato['txtNome'],
                    'telefone'   => $dadosContato['txtTelefone'],
                    'celular'    => $dadosContato['txtCelular'],
                    'email'      => $dadosContato['txtEmail'],
                    'estado'     => $dadosContato['sltEstado'],
                    'observacao' => $dadosContato['txtObs'],
                    'foto'       => $novaFoto
                );
    
                //import do arquivo de modlagem para mannipular o BD
                require_once("./model/bd/contato.php");
                //Chama a função para mandar os dados pro banco (localizado na model)
                if (updateContato($arrayDados)) {
                    return true;
                } else
                    return array(
                        'idErro'  => 2,
                        'message' => 'deu ruim na hora de editar os dados no banco de dados'
                    );
            }else 
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
function excluirContato($arrayDados){

    $id = $arrayDados['id'];
    $foto = $arrayDados['foto'];

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        require_once('model/bd/contato.php');

        if (deleteContato($id)){
       
            if ($foto != null) {
                require_once('module/config.php');
                //permite apagar a foto fisicamente do diretório no servidor
                unlink(DIRECTORY_FILE_UPLOAD.$foto);
            }
            return true;
        }
            
        else
            return  array(
                'idErro'  => 4,
                'message' => 'o banco de dados não pode excluir o registro'
            );
    }else
    return array(
        'idErro'  => 5,
        'message' => 'informe um id validado'
    );
}
//função para receber dados da View e encaminhar para a Model
function listarContato(){
    //import do arquivo que vai buscar os dados do bd
    require_once('model/bd/contato.php');
    //chama a função que vai buscar os dados do bd
    $dados = selectAllContato();

    if (!empty($dados)) {
        return $dados;
    } else {
        return false;
    }
}

function buscarContato($id) {

    require_once('model/bd/contato.php');

    if ($id != 0 && !empty($id) && is_numeric($id)) {

        $dado = selectByIdContato($id);
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
