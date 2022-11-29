


<?php
  include '../banco/conexao.php';
  $conectar = getConnection();
?>

<?php

if ($_POST['enviar']) {

    //Receber os dados do formulário
    $login = $_POST['login'];
    $senha = $_POST['senha']; 
    $nome_imagem = $_FILES['enviar_arquivo']['name'];
   
    //Diretório onde o arquivo vai ser salvo
    $diretorio = '../uploads/';
    $endereco = $diretorio . $nome_imagem;

    //Inserir no BD
    $sql = "INSERT INTO usuarios (login, senha, imagem, endereco) VALUES (:login, :senha, :imagem, :endereco)";
    $consulta = $conectar->prepare($sql);
    $consulta->bindParam(':login', $login);
    $consulta->bindParam(':senha', $senha);
    $consulta->bindParam(':imagem', $nome_imagem);    
    $consulta->bindParam(':endereco', $endereco);

    //Verificar se os dados foram inseridos com sucesso
    if ($consulta->execute()) {

        if(move_uploaded_file($_FILES['enviar_arquivo']['tmp_name'], $diretorio.$nome_imagem)){
            header("Location: ../view/tela_listagem.php");
        }else{
            header("Location: ../view/tela_listagem.php");
        }        
    } else {
        header("Location: ../view/tela_listagem.php");
    }
/* Fecha 1º IF */ } else {
    header("Location: ../view/tela_listagem.php");
}

?>
