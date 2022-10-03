<?php

        $dbname = 'nw-lab_dice';
        $dbuser = 'nw-lab_mysql';
        $dbpass = 'ibkzstcu';
        $dbserver = 'nw-lab.mysql';

	include_once('query.class.php');
	
	//connection
	$db = new mysqli($dbserver,$dbuser,$dbpass,$dbname);
	//mysql_pconnect($dbserver,$dbuser,$dbpass); 
	
	
	//mysql_select_db($dbname); 

	$q = new Query('SET NAMES utf8');
	$db->set_charset('utf8');
	//mysql_set_charset('utf8');
	
	$mysqlfuncs = array('RAND()');
	
	function insertIntoDB($options){
		$default = array (
			'action' => 'insert'
		);
		
		$options = array_merge($default,$options);
		
		$q = new Query(createQueryString($options));
	}
	
	function loadFromDB($options){
		$default = array (
			'action' => 'select',
			'single' => false,
			'return' => 'rows',
			'limit' => '',
			'orderby' => 'id',
			'order' => 'asc'
		);
			
		$options = array_merge($default,$options);
		
		//print_r($options);
		
		$single = $options['single'];
		unset($options['single']);
		$return = $options['return'];
		unset($options['return']);
		
		$q = new Query(createQueryString($options));
					
		if ($single){
			return $q->Get();
		} else {
			if ($return=='columns')
				return $q->GetColumns('str');
			else
				return $q->GetRows('str');
		}
	}
	
	function createQueryString($options){
		$action = $options['action'];
		unset($options['action']);
		
		switch ($action){
			case 'insert':
				return createInsertQueryString($options);
			break;
			case 'select':
			default:
				return createSelectQueryString($options);
			break;
		}
	}
	
	function createSelectQueryString($options){
		$where = '';
		$table = $options['table'];
		$fields = formatFields($options['fields']);
		$limit = formatLimit($options['limit']);
		$orderby = formatOrderby($options['orderby'],$options['order']);
		$where = formatWhere($options['conditions']);
		//echo "select $fields from `$table` $where $orderby $limit\r\n\r\n";
		return "select $fields from `$table` $where $orderby $limit";
	}
	
	function createInsertQueryString($options){
		$where = '';
		$table = $options['table'];
		$fields = formatFields($options['fields']);
		$values = formatValues($options['values']);
		if (!empty($options['conditions'])) $where = formatWhere($options['conditions']);
		//echo "insert into `$table` ($fields) values ($values) $where";
		return "insert into `$table` ($fields) values ($values) $where";
	}
	
	function formatFields($fields){
		if (is_array($fields)){
			$tmp = '';
			foreach ($fields as $field){
				$tmp.="`$field`,";
			}
			$fields = trim($tmp,',');
		} else $fileds = "`$fields`";
		
		return $fields;
	}
	
	function formatValues($values){
		if (is_array($values)){
			$tmp = '';
			foreach ($values as $value){
				if ($value=='NULL') $tmp.='NULL,';
				elseif (is_numeric($value)) $tmp.="$value,";
				else $tmp.="'$value',";
			}
			$values = trim($tmp,',');
		} else $values = "'$values'";
		
		return $values;
	}
	
	function formatWhere($conditions){
		if (is_array($conditions)){
			if (!isset($conditions['fields'])){
				$conditions = array(
					'operation' => 'and',
					'compartion' => '=',
					'fields' => $conditions
				);
			}
			$default = array(
				'operation' => 'and',
				'compartion' => '='
			);
			
			$conditions = array_merge($default,$conditions);
				
			$tmp = '';
			foreach($conditions['fields'] as $key=>$value){
				if (isset($value)&&$value!='')	$tmp.="`$key`{$conditions['compartion']}'$value' {$conditions['operation']} ";
			}
			$len=strlen($conditions['operation'])+2;
			$tmp = substr($tmp,0,strlen($tmp)-$len);
			if (!empty($tmp)) return "WHERE $tmp"; else return '';
		} else return "WHERE $conditions";
	}
		
	function formatOrderBy($orderby,$sortorder='asc'){
		global $mysqlfuncs;
		
		$order = 'ORDER BY ';
		
		if (is_array($orderby)){
			if (is_array($sortorder)){
				for ($i=0;$i<count($orderby);$i++){
					$order.="`$orderby[$i]` $sortorder[$i],";
				}
				$order = trim($order,',');
			} else {
				for ($i=0;$i<count($orderby);$i++){
					$order.="`$orderby[$i]` $sortorder,";
				}
				$order = trim($order,',');
			}
		} else $order.="`$orderby` $sortorder";
		
		return $order;
	}
	
	function formatLimit($limit){
		if (empty($limit)) return '';
		if (is_array($limit)){
			return "LIMIT {$limit[0]},{$limit[1]}";
		} else {
			return "LIMIT $limit";
		}
	}
		
	
	function isTableExists($table){
		$q = new Query('select 1 from `'.$table.'` where 0');
		return $q->is();
	}

	function isFieldExists($table,$field){
		$q = new Query('select `'.$field.'` from `'.$table.'` where 0 limit 1');
		return $q->is();
	}
?>