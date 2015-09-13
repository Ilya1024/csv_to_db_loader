<?php
require_once __DIR__.'\class.tableLoader.php';
$DBLink = mysqli_connect('localhost', 'user', 'pass','test');
$docroot = @$_SERVER[DOCUMENT_ROOT];
$inputfile = __DIR__.'\in\test.csv';
$csv_csv_delimiter = ';';
$tablename ='users_load';
$tablename_recordid_keyname='m_id';
$temp_dir=__DIR__.'/cache/';

# данные для связи полей в файле csv с временной таблицей
$csv_temp_relations = array(
	'id_external'=>'Идентификатор',
	'login'=>'Логин сотрудника',
	'department'=>'Подразделение сотрудника',
	'info'=>'Информация'
	);
# данные длясоздания временной таблицы
$arr_inputfields = array(
		array("name" => "login", "type" => "varchar", "length" => "50"),
		array("name" => "department", "type" => "varchar", "length" => "300"),
		array('name' => 'info', 'type' => 'varchar', 'length' => '300'),
	);
# данные связи временной таблицы с существующей.
$arr_existingfields = array(
		array("name" => "m_login","matchto" =>"login"),
		array("name" => "m_department","matchto"=>"department"),
		array('name' => 'm_info',"matchto"=>'info'),
	);

try{
	$loader = new tableLoader(	$DBLink,
	    						$inputfile,
	    						$csv_csv_delimiter,
								$tablename,
								$tablename_recordid_keyname,
								$temp_dir,
								$csv_temp_relations,
								$arr_inputfields,
								$arr_existingfields
								);
}catch(Exception $e){
	die($e->getMessage());
}
//$loader->setSql_synthasize('login="testname" WHERE 1;department="test" WHERE 1');
$loader->setDebugMode();
$resultMessage = $loader->load();
die(print_r($resultMessage));