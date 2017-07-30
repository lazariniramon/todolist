<div class="modal-header" style="color:#000;">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title">Deletar Tarefa</h4>
</div>			
<div class="modal-body" style="color:#000;">
	<p>Deseja realmente apagar essa tarefa?</p>
</div>			
<div class="modal-footer">
	<a href="index.php?acao=deletar&id=<?php echo $_GET['id']; ?>" type="button" class="btn btn-danger" id="delete">Apagar tarefa</a>
	<button type="button" data-dismiss="modal" class="btn btn-default">Cancelar</button>
</div>