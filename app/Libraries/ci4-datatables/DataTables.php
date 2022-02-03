<?php namespace Irsyadulibad\DataTables;

use Irsyadulibad\DataTables\Processor;
use \Config\Database;

class DataTables
{

	public static function use($table, $db_array = null)
	{
		return self::create($table, $db_array);
	}

	public static function create($table, $db_array)
	{
		$db = Database::connect($db_array);
		return new TableProcessor($db, $table);
	}
}
