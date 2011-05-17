<?php
namespace Covenants;

class Query extends Node {
	
	public function getTableName() {
		return $this->getType();
	}
}