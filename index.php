<?php 
function __autoload($class_name){
	require_once 'class/' . $class_name . '.php';
}
$Tarefa = new Tarefa();
?>
<html>
<head>
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<div class="container">
		
		<?php 
		$avisoCadastro ='';
		//Realiza o cadastro de uma nova tarefa no banco
		if (isset($_POST['cadastrar'])) {
			$nometarefa = $_POST['nometarefa'];
			if ($nometarefa != '') {
				$Tarefa->setTarefa($nometarefa);
				$Tarefa->setFeito(0);
				if ($Tarefa->insert()) {
					$avisoCadastro = '	<br/><div class="alert alert-success alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					Cadastrado com sucesso!
				</div>';
			}
		}else{
			$avisoCadastro = '<br/><div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Por favor</strong>, escreva o nome da tarefa!
		</div>';
	}
}

		//Realiza o delete de uma tarefa no banco
if (isset($_GET['acao']) && $_GET['acao'] == 'deletar') {
	$id = (int)$_GET['id'];
	if ($Tarefa->delete($id)) {
		$redirect = "index.php";
		header("location:$redirect");
	}
}

		//Atualiza o status da tarefa no banco
if (isset($_GET['acao']) && $_GET['acao'] == 'atualizar') {
	$id = (int)$_GET['id'];
	$checked = (int)$_GET['checked'];
	if ($Tarefa->update($id, $checked)) {
		$redirect = "index.php";
		header("location:$redirect");
	}
}
?>

<!-- Esta div contem os dados para cadastro de uma nova tarefa -->
<div>
	<form method="post" action="">
		<div class="container jumbotron">
			<div>
				<h2 style="margin:5px">TO DO LIST</h2>
			</div>
			<div class="row">
				<div class="input-group col-md-12">
					<input type="text"  class="form-control"  placeholder="Tarefa..." name="nometarefa">
					<span class="input-group-btn">
						<button type="submit" name="cadastrar" class="btn btn-success ">Criar</button>
					</span>
				</div>
			</div>

			<div class="row">
				<div class="input-group col-md-12">
					<?php echo $avisoCadastro; ?>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- Esta div contem os dados e as ações possiveis de serem realizadas nas tarefas cadastradas -->
<div class="container ">
	<table class="table">
		<tbody>
			<?php foreach($Tarefa->findAll() as $Tarefa){ 
				$verde = $Tarefa['feito']==0 ?  "" : "class='alert alert-success' role='alert'";
				$feito = $Tarefa['feito']==0 ?  "&nbsp;&nbsp;&nbsp;&nbsp;" : "<span class='glyphicon glyphicon-ok'aria-hidden='true'></span>"; 
				$checked = $Tarefa['feito']==1 ?  0 : 1; 
				?>
				<tr <?php echo $verde ?>>
					<td  class="col-md-11" title='Clique aqui para finalizar a tarefa.' >
						<?php
						echo "<a href='index.php?acao=atualizar&id=". $Tarefa['id']."&checked=".$checked."' ><div class='col-md-12'>".$feito."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Tarefa['tarefa']."</div></a>";
						?>
					</td>
					<td  class="col-md-1" >
						<!-- botão pra excluir na tabela -->
						<button type="button" class="btn btn-default" data-toggle="modal" data-target="#confirm"><span class='glyphicon glyphicon-trash'aria-hidden='true'></span></button>
						<!-- Modal com mensagem que será exibida para excluir a tarefa. -->
						<div class="modal fade" id="confirm" role="dialog">
							<div class="modal-dialog modal-md">

								<div class="modal-content">
									<div class="modal-body">
										<p> Quer realmente apagar essa tarefa?</p>
									</div>
									<div class="modal-footer">
										<a href="index.php?acao=deletar&id=<?php echo $Tarefa['id']; ?>" type="button" class="btn btn-danger" id="delete">Apagar tarefa</a>
										<button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
									</div>
								</div>
							</div>
						</div>
					</td>

				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
</body>
<script src="jquery/jquery-3.1.1.min.js"></script>
<script src="js/app.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</html>



