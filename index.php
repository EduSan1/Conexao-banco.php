<?php
require_once("module/config.php");
$form = "router.php?component=contatos&action=inserir";

//váriavel que ira armazenar nossa foto
$foto = "images.png";
$estadoSession = null;

if (session_status()) {

    if (!empty($_SESSION['dadosContato'])) {

        $id = $_SESSION['dadosContato']['id'];
        $nome = $_SESSION['dadosContato']['nome'];
        $telefone = $_SESSION['dadosContato']['telefone'];
        $celular = $_SESSION['dadosContato']['celular'];
        $email = $_SESSION['dadosContato']['email'];
        $obs = $_SESSION['dadosContato']['observacao'];
        $foto = $_SESSION['dadosContato']['nomeFoto'];
        $estadoSession = $_SESSION['dadosContato']['estado'];
        $form = "router.php?component=contatos&action=editar&id=" . $id . "&foto=" . $foto;

        unset($_SESSION['dadosContato']);
    }
}

?>



<!DOCTYPE>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> Cadastro </title>
    <link rel="stylesheet" type="text/css" href="css/style.css">


</head>

<body>

    <div id="cadastro">
        <div id="cadastroTitulo">
            <h1> Cadastro de Contatos </h1>

        </div>
        <div id="cadastroInformacoes">
            <form action="<?= $form ?>" name="frmCadastro" enctype="multipart/form-data" method="post">
                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Nome: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <input type="text" name="txtNome" value="<?= isset($nome) ? $nome : null ?>" placeholder="Digite seu Nome" maxlength="100">
                    </div>
                </div>

                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Telefone: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <input type="tel" name="txtTelefone" value="<?= isset($telefone) ? $telefone : null ?>">
                    </div>
                </div>
                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Celular: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <input type="tel" name="txtCelular" value="<?= isset($celular) ? $celular : null ?>">
                    </div>
                </div>


                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Email: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <input type="email" name="txtEmail" value="<?= isset($email) ? $email : null ?>">
                    </div>
                </div>

                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Estado: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <select name="sltEstado">
                            <option <?= $estadoSession == null ? "selected" : null ?> value="">Selecione um item</option>
                            <?php
                            require_once('controller/controllerEstados.php');
                            $listaEstados = listarEstados();
                            foreach ($listaEstados as $item) {
                                if ($item['idEstado'] != $estadoSession) {
                            ?>
                                    <option value="<?= $item['idEstado'] ?>"><?= $item['nome'] ?></option>
                                <?php } else { ?>
                                    <option selected value="<?= $item['idEstado'] ?>"><?= $item['nome'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="campos-foto">
                    <div class="cadastroInformacoesPessoais">
                        <label> Escolha um arquivo: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <input type="file" name="flPhoto" accept=".jpg, .png, .jpeg">
                    </div>
                    <div class="fotoForm">
                        <img src="<?= DIRECTORY_FILE_UPLOAD . $foto ?>" alt="">
                    </div>
                </div>

                <div class="campos">
                    <div class="cadastroInformacoesPessoais">
                        <label> Observações: </label>
                    </div>
                    <div class="cadastroEntradaDeDados">
                        <textarea name="txtObs" cols="50" rows="7"><?= isset($obs) ? $obs : null ?></textarea>
                    </div>
                </div>



                <div class="enviar">
                    <div class="enviar">
                        <input type="submit" name="btnEnviar" value="Salvar">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="consultaDeDados">
        <table id="tblConsulta">
            <tr>
                <td id="tblTitulo" colspan="6">
                    <h1> Consulta de Dados.</h1>
                </td>
            </tr>
            <tr id="tblLinhas">
                <td class="tblColunas destaque"> Nome </td>
                <td class="tblColunas destaque"> Celular </td>
                <td class="tblColunas destaque"> Email </td>
                <td class="tblColunas destaque"> Estado </td>
                <td class="tblColunas destaque"> Foto </td>
                <td class="tblColunas destaque"> Opções </td>
            </tr>
            <?php

            // importa o arquivo da controller para solicitar a listagem dos dados 
            require_once('controller/controllerContatos.php');
            //chama a função que vai retornar os dados do contato
            if ($listContato = listarContato()) {

                //estrutura de repetição para retornar os dados do array
                //e printar na tela 
                // 
                foreach ($listContato as $item) {
                    $foto = $item['nomeFoto'];
                    $estado = buscarEstado($item['idEstado']);
            ?>

                    <tr id="tblLinhas">
                        <td class="tblColunas registros"><?= $item['nome'] ?></td>
                        <td class="tblColunas registros"><?= $item['celular'] ?></td>
                        <td class="tblColunas registros"><?= $item['email'] ?></td>
                        <td class="tblColunas registros"><?= $estado['sigla'] ?> - <?= $estado['nome'] ?></td>
                        <td class="tblColunas registros"><img class="foto" src="files/<?= $foto ?>"></td>

                        <td class="tblColunas registros">
                            <a href="router.php?component=contatos&action=buscar&id=<?= $item['id'] ?>">
                                <img src="img/edit.png" alt="Editar" title="Editar" class="editar">
                            </a>

                            <a onclick="return confirm('Deseja excluir?');" href="router.php?component=contatos&action=deletar&id=<?= $item['id'] ?>&foto=<?= $foto ?>">
                                <img src="img/trash.png" alt="Excluir" title="Excluir" class="excluir">
                            </a>
                            <img src="img/search.png" alt="Visualizar" title="Visualizar" class="pesquisar">
                        </td>
                    </tr>
            <?php }
            } ?>
        </table>
    </div>
</body>

</html>