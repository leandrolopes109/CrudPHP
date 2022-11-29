<?php
	
    include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>

<?php

	if(isset($_POST['editar'])){
     $id = $_POST['recebeID'];
    

 $pesquisa = "SELECT imagem FROM usuarios WHERE id_usuario=:id";
 $resultado =  $conectar->prepare($pesquisa);
 $resultado->bindParam(':id', $id, PDO:: PARAM_INT);
 $resultado->execute();

 //VERIFICAR SE ENCONTROU O REGISTRO NO BANCO DE DADOS
 if (($resultado) and ($resultado->rowCount() != 0)) {
    $exibir = $resultado->fetch(PDO::FETCH_ASSOC);
 }
/* ----------------------------------------------------------------------*/

    
    $login=$_POST['EditaLogin'];
    $senha=$_POST['EditaSenha'];
    $nome_arquivo=$_FILES['enviar_arquivo']['name'];
    $tmp_arquivo=$_FILES['enviar_arquivo']['tmp_name'];


    $diretorio = '../uploads/';
    $endereco = $diretorio . $nome_arquivo;



    // Verificando os campos se estao preenchidos
    if( empty($login) || empty($senha) || empty($id) ) {
        if(empty($login)) {
            echo "<font color='red'>Campo Login Obrigatorio.</font><br/>";
        }

        if(empty($senha)) {
            echo "<font color='red'>Campo Senha Obrigatorio.</font><br/>";

        }   if(empty($nome_arquivo)) {
            echo "<font color='red'>novo arquivo .  Obrigatorio.</font><br/>";
        }

    } else {
        //atualizado dados na tabela
        $sql = "UPDATE usuarios SET login = :login, senha = :senha, imagem = :imagem , endereco = :endereco WHERE id_usuario = :id";

        $query = $conectar->prepare($sql);

        $query->bindparam(':id', $id);
        $query->bindparam(':login', $login);
        $query->bindparam(':senha', $senha);
          $query->bindparam(':imagem', $nome_arquivo);
         $query->bindparam(':endereco', $endereco);


        if ($query->execute()){

            if(move_uploaded_file($_FILES['enviar_arquivo']['tmp_name'], $diretorio . $nome_arquivo)){
                $arquivo_anterior = "../uploads/" . $exibir['imagem'];
                if(file_exists($arquivo_anterior)){
                    unlink($arquivo_anterior);
                }
            }
        
            header('Location: ../view/tela_listagem.php');

        }else {
     
      
            echo "<p style='color: #f00;'>Erro: usuario não editado com sucesso!</p>";
            print_r($query->errorInfo());
        }

    }
}
?>
