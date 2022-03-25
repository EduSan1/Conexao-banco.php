<?php

    /**********************************************************************************************************
    
        Objetivo: arquivo que cria uma conexão com o MySQL
        Autor: Eduardo Santos Nascimento
        Data: 25/02/2022
        Versão: 1.0
    
    **********************************************************************************************************/

    //constantes para estabelecer a conexão com bd (local do bd usuário senha e  database)
    const SERVER = 'localhost';
    const USER = 'root';
    const PASSWORD = 'bcd127';
    const DATABASE = 'dbContatos';

    //abre a conexão com o MySQL
    $resultado = conexaoMysql();


    function conexaoMysql (){
        //se a conexão for estabelecida com o bd receberemos um array com os dados sobre a conexão
        $conexao = mysqli_connect(SERVER,USER,PASSWORD,DATABASE);

        //verifica se a conexão foi realizada com sucesso 
        if ($conexao){
            return $conexao;
        }else {
            return false;
        }

    }

    function fecharConexaoMysql ($conexao){

        mysqli_close($conexao);

    }

    /*existem 3 formas de criar a conexão com o bd:

    mysql_connet(); - antiga, não é muito segura e não oferece performance
    mysqli_connet(); - versão mais atualizada do PHP de fazer conexão com BD, pode ser usada em POO e programação estruturada
    PDO() - voltada para POO, sendo mais completa e eficiente para conexão com BD, possui uma boa segurança 
    
    */

?>