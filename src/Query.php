<?php
namespace Covenants;

class Query extends \Phutility\Node {
	
	public function getTableName() {
		return $this->getType();
	}
	
	public function getSql() {
		//genrate in a certain order
		if($select = $this->has(select)) {
			echo "YEP";
		}
		
		if($where = $this->has(where)) {
			var_dump($where);
		}
	}
	
	public function parse($sql) {
		$special = array('select', 'from', 'where', 'order');

		//first get sub expressions i.e. ( x )
		
		
		$tree = array_map(
			function($t) { 
				$tokens = explode(' ', $t);
				return new Node(array_shift($tokens), $tokens); 
			},
			explode(chr(0), 
				trim(
					preg_replace('/\s+/', ' ', 
						str_ireplace(
							array_map(function($i) { return " $i ";}, $special),
							array_map(function($i) { return chr(0)."$i "; }, $special),
							" $sql ")))));
		print_r($tree);
		
	}
}