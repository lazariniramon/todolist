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
		//Realiza o cadastro de uma nova tarefa no banco
		if (isset($_POST['cadastrar'])) {
			$nometarefa = $_POST['nometarefa'];
			if ($nometarefa != '') {
				$Tarefa->setTarefa($nometarefa);
				$Tarefa->setFeito(0);
				if ($Tarefa->insert()) {
					echo "<script> alert('Inserido com sucesso'); </script>";
				}
			}else{
				echo "<script> alert('Por favor, escreva o nome da tarefa!'); </script>";
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
				<div id="myDIV" class="header">
					<h2 style="margin:5px">To Do List</h2>
					<div class="input-prepend">
						<input type="text" id="myInput" placeholder="Title..." name="nometarefa">
					</div>
					<input type="submit" name="cadastrar"  class="addBtn"/>
				</div>
			</form>
		</div>
		
		<!-- Esta div contem os dados e as ações possiveis de serem realizadas nas tarefas cadastradas -->
		<div>
			<table class="table table-striped" align="center">
			<thead>
				<th class="col-md-1">Feito</th>
				<th class="col-md-10">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tarefa</th>
				<th class="col-md-1">Excluir</th>
			</thead>
			<tbody>
				<?php foreach($Tarefa->findAll() as $Tarefa){ ?>
				<tr>
					<td  class="col-md-1">

						<?php

						$feito = $Tarefa['feito']==0 ?  "" : "<span class='glyphicon glyphicon-ok'aria-hidden='true'></span>"; 
						echo $feito;
						?>
					</td>
					<td  class="col-md-10"><!-- <input type="checkbox" name="feito" <?php echo $Tarefa['feito']==1 ?  ' checked' : ''; ?>> -->
						<?php 
						$checked = $Tarefa['feito']==1 ?  0 : 1;
						echo "<a href='index.php?acao=atualizar&id=". $Tarefa['id']."&checked=".$checked."' >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$Tarefa['tarefa']."</a>"; ?>

					</td>
					<!-- <td  class="col-md-10" class="checked"><?php echo $Tarefa['tarefa']; ?></td> -->
					<td  class="col-md-1">
						<?php 
						echo "<a href='index.php?acao=deletar&id=". $Tarefa['id']."' onClick='return confirm(\"Deseja realmente deletar?\")'><span class='glyphicon glyphicon-trash'aria-hidden='true'></span></a>"; ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
</body>
<script src="jquery/jquery-3.1.1.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
</html>

