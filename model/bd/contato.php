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
function insertContato($dadoscontato){
    //variavel que salva o status de resposta do bd
    $statusResposta = (boolean) false;
    // abre a conexão com o banco de dados
    $conexao = conexaoMysql();

    $sql = "insert into tblcontatos (
            nome,
            telefone,
            celular,
            email,
            observacao,
            idEstado,
            foto
            )
            value
            ('" . $dadoscontato['nome'] . "',
            '" . $dadoscontato['telefone'] . "',
            '" . $dadoscontato['celular'] . "',
            '" . $dadoscontato['email'] . "',
            '" . $dadoscontato['observacao'] . "',
            '" . $dadoscontato['estado'] . "',
            '" . $dadoscontato['nomeFoto'] . "');";

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao)) {
            $statusResposta = true;
        }
    } 
    //fecha a conexão com o banco de dados
    fecharConexaoMysql($conexao);
    //retorna o status da conexão com o banco 
    return $statusResposta;
        
}
//função para realizar update no bd
function updateContato($dadoscontato){

     //variavel que salva o status de resposta do bd
     $statusResposta = (boolean) false;
     // abre a conexão com o banco de dados
     $conexao = conexaoMysql();

     $sql = "        update tblcontatos set 
     nome = '" . $dadoscontato['nome'] . "',
     telefone = '" . $dadoscontato['telefone'] . "',
     celular = '" . $dadoscontato['celular'] . "',
     email = '" . $dadoscontato['email'] . "',
     idEstado = '" . $dadoscontato['estado'] . "',
     foto = '" . $dadoscontato['foto'] . "',
     observacao =  '" . $dadoscontato['observacao'] ."' 
     where idcontato =".$dadoscontato['id'];
 
     if (mysqli_query($conexao, $sql)) {
         if (mysqli_affected_rows($conexao)) {
             $statusResposta = true;
         }
     } 
     //fecha a conexão com o banco de dados
     fecharConexaoMysql($conexao);
     //retorna o status da conexão com o banco 
     return $statusResposta;

}
//função para excluir no bd
function deleteContato($id){
    $conexao = conexaoMysql();

    $statusResposta = false;

    $sql = "delete from tblcontatos where idcontato = ".$id;

    if(mysqli_query($conexao,$sql)){
        if(mysqli_affected_rows($conexao)) {
            $statusResposta = true;

        }

    }

    fecharConexaoMysql($conexao);
    return $statusResposta;

}
//função para listar todos os contatos do bd
function selectAllContato(){
    $conexao = conexaoMysql();

    //script para listar todos os dados da tabela do DB
    /*asc *//*desc */
    // $sql = "select tblcontatos.*,tblestado.nome,tblestado.sigla from tblcontatos inner join tblestado on tblcontatos.idestado = tblestado.idestado";
    $sql = "select * from tblcontatos order by idcontato desc";

    //quando mandamos um script pro banco que seja insert delete ou update eles n retornam nada
    //o select por outro lado retorna os dados 
    $result = mysqli_query($conexao, $sql);
    //valida se retornou registros 
    if ($result) {
        //permite converter os dados do BD em um array para manipular com php
        //nesta repetição estamos convertendo os dados do bd em array, além do próprio while
        //conseguir gerenciar a quantidade de vezes que deveré ser feira a repetição
        $cont = 0;

        while ($rsDados = mysqli_fetch_assoc($result)) {
            //cria um array com os dados do BD
          
            $arrayDados[$cont] = array(
                "id"       => $rsDados['idcontato'],
                "nome"       => $rsDados['nome'],
                "telefone"   => $rsDados['telefone'],
                "celular"    => $rsDados['celular'],
                "email"      => $rsDados['email'],
                "idEstado"      => $rsDados['idEstado'],
                "observacao" => $rsDados['observacao'],
                'nomeFoto' => $rsDados['foto']
            );
            $cont++;
        };
        //solicita o fechamento da conexao com o banco de dados
        fecharConexaoMysql($conexao);

        if(isset($arrayDados))
            return $arrayDados;
        else
            return false;

        
    } else {
        fecharConexaoMysql($conexao);                        
        return array(
            'idErro'  => 3,
            'message' => 'Não foi encontrado no banco'
        );
    }
}
function selectByIdContato($id){

    $conexao = conexaoMysql();

    
    $sql = "select * from tblcontatos where idcontato = ".$id;


    $result = mysqli_query($conexao, $sql);
 

    if ($result) {
        if ($rsDados = mysqli_fetch_assoc($result)) {
            
            $arrayDados = array(
                "id"       => $rsDados['idcontato'],
                "nome"       => $rsDados['nome'],
                "telefone"   => $rsDados['telefone'],
                "celular"    => $rsDados['celular'],
                "email"      => $rsDados['email'],
                "estado"     => $rsDados['idEstado'],
                "observacao" => $rsDados['observacao'],
                'nomeFoto' => $rsDados['foto']
            );
             return $arrayDados;
        }else {
            return false;
        }
        fecharConexaoMysql($conexao);
        
    } else {
        fecharConexaoMysql($conexao);                        
        return array(
            'idErro'  => 3,
            'message' => 'Não foi encontrado no banco'
        );
    }

}