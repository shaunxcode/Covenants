<?php
namespace Covenants;

class Node {
	protected $_type;
	protected $_vals;
	public function __construct($type, $vals) {
		$this->_type = $type;
		$this->_vals = $vals;
	}
	
	public function __get($name) {
		$valTypes = array();
		foreach($this->_vals as $val) {
			if($val->typeIs($name)) {
				return $val;
			}
			$valTypes[] = $val->getType();
		}
		throw new Exception("{$name} was not found. Did find [" . implode(', ', $valTypes) . ']');
	}
	
	public function first() {
		return reset($this->_vals);
	}
	
	public function last() {
		return end($this->_vals);
	}
	
	public function getType() {
		return $this->_type;
	}
	
	public function typeIs($type) {
		return $this->_type == $type;
	}
}