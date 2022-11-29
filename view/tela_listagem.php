
<?php
	  include_once '../banco/conexao.php';
  	$conectar = getConnection();
?>



<!DOCTYPE html>
<html> 
 	<head>
 		<title> DASHBOARD </title>  
 	    <meta charset="utf-8">

 	<style>
	body {
	  background-image: url('fundo_login.jpg');
	  background-repeat: no-repeat;
	  background-attachment: fixed;  
	  background-size: cover;	  
	}

	.caixalogin{
		background-color: white;
		opacity: 80%;
		width: 300px;
		height: 250px;
	}
	#caixalogin{
		
		border-radius: 25px;
	}

  

  img{
    width: 40px;
    height: 40px;
  }

	</style>
    
	</head>

<body>

<h3> 
  <a href="tela_cadastro.html"> CADASTRO </a> | <a href="tela_listagem.php"> LISTAGEM e DELETAR </a> | <a href="tela_atualizacao.html"> ATUALIZAÇÃO </a>  
</h3>

<?php 

  $dados = filter_input_array(INPUT_GET, FILTER_DEFAULT);

?>

<br>
<!-- CAMPO DE PESQUISA -->
<form action="tela_listagem.php" method="GET"><!-- GET, pega o valor através da url. -->

  <center><p>
    <input type="text" name="login_usuario" placeholder="Pesquisar Login" id="input_pesquisa">
      <input type="submit" value="Pesquisar">
  </p></center>
</form>

<br>

<center>

<h1> DASHBOARD </h1>


<?php

      $pesquisa = $dados['login_usuario'] . "%";

        //SQL para selecionar os registros
       $sql = "SELECT id_usuario,login, senha, imagem,endereco FROM usuarios WHERE login LIKE :login ORDER BY id_usuario";
       $consulta = $conectar->prepare($sql);
       $consulta -> bindParam(':login', $pesquisa, PDO::PARAM_STR);
       $consulta->execute();
       if (!$consulta) {
         die("Erro no Banco!");
       }
       
      
       echo '<table class="table table-hover">';
       echo "<thead>";
       echo "<tr>";
       echo "<th><center> ID </center></th>";
       echo "<th><center> Login </center></th>";
       echo "<th><center> Senha </center></th>"; 
       echo "<th><center> Arquivo </center></th>";             
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<th><center>" . $exibir['id_usuario'] . "</center></th>";
          echo "<td><center>" . $exibir['login'] . "</center></td>";
          echo "<td><center>" . $exibir['senha'] . "</center></td>";
          
          $ext = pathinfo($exibir['imagem'],PATHINFO_EXTENSION); // Pega a extensão do meu arquivo

          if ($ext == 'pdf') {
            echo "<td><center> <a href='../uploads/" . $exibir["imagem"] . "'> <img src='pdf.png'> </a> </center></td>";
          } else if (($ext == 'png') || ($ext == 'jpg') || ($ext == 'jpeg') || ($ext == 'jfif')) {
            echo "<td><center> <img src='../uploads/" . $exibir['imagem'] . "'> </center></td>";
          } else if (($ext == 'mp3') || ($ext == 'mp4')) {
            echo "<td><center><audio controls preload='auto'> <soucer type='audio/mpeg' src='../uploads/" . $exibir['imagem'] . "'> </audio></center></td>";
          } 

          echo "<td><center> <a href='../uploads/" . $exibir["endereco"] . "' download> <img src='download.png'> </a> </center></td>";
          
        ?>

      <td>
        <center>
          <a class="Deletar" href="<?php echo "../model/deletar.php?id={$exibir['id_usuario']}"; ?>">
            <img src="deletar.png" name="id_deletar">
          </a>


        </center>
      </td>

    <?php
          echo "</tr>";
        }
        
        echo "</tbody>";        
        echo "</table>";

        ?>


<br><br><br>

<!--                      LISTAGEM COM INNER JOIN               -->        
<h1> Listagem com Inner Join </h1>


<?php

        //SQL para selecionar os registros
       $sql = "SELECT u.login, u.senha,p.nome FROM usuarios u inner join acesso a on u.id_usuario=a.id_usuario inner join pessoa p on p.id_pessoa=a.id_pessoa";// WHERE id_usuario = $_SESSION['idUser']";

       //Seleciona os registros
       $consulta = $conectar->prepare($sql);
       $consulta->execute();
       if (!$consulta) {
         die("Erro no Banco!");
       }
       
      
       echo '<table class="table table-hover">';
       echo "<thead>";
       echo "<tr>";
       echo "<th><center> Usuário </center></th>";
       echo "<th><center> Login </center></th>"; 
       echo "<th><center> Senha </center></th>";            
       echo "</tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($exibir = $consulta->fetch(PDO::FETCH_ASSOC)) {
          echo "<tr>";
          echo "<td><center>" . $exibir['nome'] . "</center></td>";
          echo "<td><center>" . $exibir['login'] . "</center></td>";
          echo "<td><center>" . $exibir['senha'] . "</center></td>";
        ?>

      <td>
        <center>
          <!-- Botão Deletar -->
          <a class="Deletar" href="<?php echo "../model/deletarAcesso.php?id={$exibir['id_usuario']}"; ?>">
            <img src="deletar.png" name="id_deletar">
          </a>
        </center>
      </td>

    <?php
          echo "</tr>";
        }
        
        echo "</tbody>";        
        echo "</table>";

        ?>


        <!-- Botão Relatório -->  
        <a class="Relatorio" href="gerar_pdf.php" name="relatorio">
            <img src="relatorio.png">
        </a>
</center>


</body>

</html>
