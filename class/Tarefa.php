<?php

require_once 'Crud.php';

class Tarefa extends Crud{
	
	protected $table = 'Tarefa';
	private $id;
	private $tarefa;
	private $feito;

	public function setTarefa($tarefa){
		$this->tarefa = $tarefa;
	}

	public function getTarefa(){
		return $this->tarefa;
	}
	public function setId($id){
		$this->id = $id;
	}

	public function getId(){
		return $this->id;
	}

	public function setFeito($feito){
		$this->feito = $feito;
	}

	public function getFeito(){
		return $this->feito;
	}
	
	public function insert(){
        $sql = "INSERT INTO $this->table (tarefa, feito) VALUES (:tarefa, :feito)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(":tarefa", $this->tarefa);
		$stmt->bindParam(':feito', $this->feito);
		return $stmt->execute(); 
	}

	public function update($id, $checked){
		$sql = "UPDATE $this->table SET feito = :feito WHERE id = :id";
		$stmt = DB::prepare($sql);
        $stmt->bindParam(":feito",$checked);
		$stmt->bindParam(':id', $id);
		return $stmt->execute(); 
	}
	public function updateTarefa($id, $tarefa){
		$sql = "UPDATE $this->table SET tarefa = :tarefa WHERE id = :id";
		$stmt = DB::prepare($sql);
        $stmt->bindParam(":tarefa",$tarefa);
		$stmt->bindParam(':id', $id);
		return $stmt->execute(); 
	}
}