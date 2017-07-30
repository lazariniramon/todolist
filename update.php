<?php 
function __autoload($class_name){
	require_once 'class/' . $class_name . '.php';
}
$Tarefas = new Tarefa();

$Tarefa = $Tarefas->find($_GET['id']);
?>

<div class="modal-header" style="color:#000;">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Alterar Tarefa</h4>
</div>			

<form class="form-horizontal" role="form" >
	<div class="modal-body" style="color:#000;">
		<div class="form-group">

			<input type="hidden" name="acao" value="atualizarTarefa">
			<input type="hidden" name="id" value="<?php echo $Tarefa['id'] ?>">
			<label  class="col-sm-2 control-label" >Tarefa</label>

			<div class="col-sm-10">
				<input type="text" name="tarefa" class="form-control" value="<?php echo $Tarefa['tarefa'] ?>"/>
			</div>
		</div>
		


	</div>			
	<div class="modal-footer">
				<button type="submit" class="btn btn-success">Cadastrar</button>
		<button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
	</div>
</form>