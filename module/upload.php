<?php

/*******************************************************************************************
 Objetivo: 
 Autor: Eduardo Santos Nascimento
Data: //
Versão 1.0
 ********************************************************************************************/


//Realiza o upload de imagem :)
function uploadFile($arrayFile)
{
    require_once('module/config.php');

    $file = $arrayFile;
    $sizeFile = (int) 0;
    $typeFile = (string) null;
    $nameFile = (string) null;
    $tempFile = (string) null;

    //validação para identificar se o arquivo existe e se ele é valido
    if ($file['size'] > 0 && $file['type'] != "") {

        $sizeFile = $file['size'] / 1024;
        $typeFile = $file['type'];
        $nameFile = $file['name'];
        $tempFile = $file['tmp_name'];

        if ($sizeFile <= MAX_FILE_UPLOAD) {

            if (in_array($typeFile, EXTENSION_FILE_UPLOAD)) {

                //nome do arquivo sem extensão
                $name = pathinfo($nameFile, PATHINFO_FILENAME);
                //extensão do arquivo sem o nome
                $extension = pathinfo($nameFile, PATHINFO_EXTENSION);
                //criptografia de dados em php geralmente usa, md5(), sha1(), hash()
                $nameEncrypted = md5($name . uniqid(time()));

                $photo = $nameEncrypted . "." . $extension;

                if (move_uploaded_file($tempFile, DIRECTORY_FILE_UPLOAD . $photo)) {

                    return $photo;
                } else {
                    return array(
                        'idError'     => 4,
                        'message'     => "Não foi possivel mover o arquivo para o servidor"
                    );
                }
            } else {
                return array(
                    'idError'     => 3,
                    'message'     => "Envie uma imagem do tipo: .jpeg, .png ou .jpg "
                );
            }
        } else {
            return array(
                'idError'     => 2,
                'message'     => "Tamanho do arquivo inválido, selecione um aquivo com no máximo 10Mb"
            );
        }
    } else {
        return array(
            'idError'     => 1,
            'message'     => "O arquivo enviado não é válido"
        );
    }
}
