<?php 
function __autoload($class_name){
	require_once 'class/' . $class_name . '.php';
}
$Tarefas = new Tarefa();
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
				$Tarefas->setTarefa($nometarefa);
				$Tarefas->setFeito(0);
				if ($Tarefas->insert()) {
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
	if ($Tarefas->delete($id)) {
		$redirect = "index.php";
		header("location:$redirect");
	}
}

		//Atualiza o status da tarefa no banco
if (isset($_GET['acao']) && $_GET['acao'] == 'atualizar') {
	$id = (int)$_GET['id'];
	$checked = (int)$_GET['checked'];
	if ($Tarefas->update($id, $checked)) {
		$redirect = "index.php";
		header("location:$redirect");
	}
}
		//Atualiza o nome da tarefa no banco
if (isset($_GET['acao']) && $_GET['acao'] == 'atualizarTarefa') {
	 $id = (int)$_GET['id'];
	echo $nometarefa = $_GET['tarefa'];
	if ($Tarefas->updateTarefa($id, $nometarefa)) {
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
			<?php foreach($Tarefas->findAll() as $Tarefa){ 
				$verde = $Tarefa['feito']==0 ?  "" : "class='alert alert-success' role='alert'";
				$feito = $Tarefa['feito']==0 ?  "&nbsp;&nbsp;&nbsp;&nbsp;" : "<span class='glyphicon glyphicon-ok'aria-hidden='true'></span>"; 
				$checked = $Tarefa['feito']==1 ?  0 : 1; 
				?>
				<tr <?php echo $verde ?>>
					<td  class="col-md-10" title='Clique aqui para finalizar a tarefa.' >
						<?php
						echo "<a href='index.php?acao=atualizar&id=". $Tarefa['id']."&checked=".$checked."' ><div class='col-md-12'>".$feito."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Tarefa['tarefa']."</div></a>";
						?>
					</td>
					<td  class="col-md-2" >
						<!--  -->
						<?php 
						$tarefa = $Tarefa['tarefa'];
						echo '<button data-toggle="modal" data-target="#myModal" type="button" class="btn btn-default" data-toggle="modal" href="update.php?id='.$Tarefa['id'].'"><span class="glyphicon glyphicon-pencil" aria-hidden="true" ><i class="icon-zoom-in"></i> </span></button>'; ?>
						
						<!-- botão pra excluir na tabela -->
						<?php echo '<button data-toggle="modal" data-target="#myModalDelete" type="button" class="btn btn-default" data-toggle="modal" href="delete.php?id='.$Tarefa['id'].'"><span class="glyphicon glyphicon-trash" aria-hidden="true" ><i class="icon-zoom-in"></i> </span></button>'; ?>
						<!-- Janela Modal -->
						<div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body"><div class="te"></div></div>
								</div>
							</div>
						</div>
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-body"><div class="te"></div></div>
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



