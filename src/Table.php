<?php
namespace Covenants;

class Table {
	public static $tableName;
	
	public static function tableName() {
		return !empty(static::$tableName) ? static::$tableName : end(explode('\\', get_called_class()));
	}
	
	public static function query() {
		return new Query(self::tableName(), func_get_args());
	}
}