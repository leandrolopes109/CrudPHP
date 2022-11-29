
<?php
   include_once("../banco/conexao.php");
   $conectar = getConnection();
?>

<?php
	$sql = $conectar->query('SELECT * FROM usuarios');

$html ='<h1> Relatorio de Campus</h1>';
$html .= '<table border=1 width=100%>';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<td>Codigo</td>';
$html .= '<td>Login</td>';
$html .= '<td>Senha</td>';
$html .= '</tr>';
$html .= '</thead>';

while ($linha = $sql->fetch(PDO::FETCH_ASSOC)) {
	$html .='<tbody>';
	$html .= '<tr><td>'.$linha['id_usuario'] .'</td>';
	$html .= '<td>'.$linha['login'] .'</td>';
	$html .= '<td>'.$linha['senha'] .'</td></tr>';
	$html .='</tbody>';	
}
$html .='</table>';


//referenciar o DomPDF com namespace
	use Dompdf\Dompdf;

	// include autoloader
	require_once("dompdf/dompdf/autoload.inc.php");

	//Criando a Instancia
	$dompdf = new DOMPDF();
	
	// Defini o tipo de Papel e sua Orientacao
	$dompdf->setPaper('A4','portrait');

	// Carrega seu HTML
	$dompdf->load_html($html);


	//Renderizar o html
	$dompdf->render();

	//Exibibir a página
	$dompdf->stream(
		"relatorio.pdf", 
		array(
			"Attachment" => false //Para realizar o download somente alterar para true
		)
	);
?>
