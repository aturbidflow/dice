<?php

	class Query {
		var $result;
		var $result_array=array();
		var $db;
		
		public static function _($q){
			return new Query($q);
		}
		
		public function __construct($q){
			global $db;

			$this->db = $db;
			$this->result = $this->db->query($q);
			$this->result_array=$this->GetRows();
		}

		public function Get($colname=0, $row=0) {
			if (isset($this->result_array[$row][$colname])){
				return $this->result_array[$row][$colname];
			} else { return false; }
		}

		public function GetColumn($colname=0) {
			$res=array();
			for ($i=0;$i<count($this->result_array);$i++){
				$res[$i]=$this->result_array[$i][$colname];
			}
			return $res;
		}

		public function GetRows($filter='all') {
			$res=array();
			if ($this->HaveData()){
				if (empty($this->result_array)){
					for ($i=0;$i<$this->result->num_rows;$i++) {
						$res[$i]=$this->result->fetch_array();
					}
				} else { 
					for ($i=0;$i<count($this->result_array);$i++) {
						foreach ($this->result_array[$i] as $skey => $svalue){
							switch($filter){
								case 'int':
								case 'num':
								case 'integer':
								case 'number':
									if (is_numeric($skey)){ $res[$i][$skey]=$this->result_array[$i][$skey]; }
								break;
								case 'str':
								case 'string':
								case 'assoc':
									if (is_string($skey)){ $res[$i][$skey]=$this->result_array[$i][$skey]; }
								break;
								case 'all':
								default:
									$res[$i][$skey]=$this->result_array[$i][$skey];
								break;
							}
						}
					}
					//$res=$this->result_array; 
				}
			}
			return $res;
		}
		
		public function GetRow($filter='all',$row=0){
			$res=array();
			if ($this->HaveResult()){
				foreach ($this->result_array as $key => $value){
					foreach ($value as $skey => $svalue){
						switch($filter){
							case 'int':
							case 'num':
							case 'integer':
							case 'number':
								if (is_numeric($skey)){ $res[$skey]=$this->result_array[$row][$skey]; }
							break;
							case 'str':
							case 'string':
							case 'assoc':
								if (is_string($skey)){ $res[$skey]=$this->result_array[$row][$skey]; }
							break;
							case 'all':
							default:
								$res[$skey]=$this->result_array[$row][$skey];
							break;
						}
					}
				}
			}
			return $res;
		}
		
		public function GetColumns($filter='all'){
			$res=array();
			if ($this->HaveData()){
				foreach($this->result_array[0] as $key => $value){
					switch($filter){
						case 'int':
						case 'num':
						case 'integer':
						case 'number':
							if (is_numeric($key)){ $res[$key]=$this->GetColumn($key); }
						break;
						case 'str':
						case 'string':
						case 'assoc':
							if (is_string($key)){ $res[$key]=$this->GetColumn($key); }
						break;
						case 'all':
						default:
							$res[$key]=$this->GetColumn($key);
						break;
					}
				}
			}
			return $res;
		}

		public function HaveResult() {
			if (@$this->result){ return true; } else { return false; }
		}
		
		public function HaveData(){
			if (@$this->result->num_rows>0) { return true; } else { return false; }
		}
		
		public function is(){
			return $this->HaveResult();
		}
                
                public function InsertID(){
                    global $db;
                    return $db->insert_id;
                }
		

	}	
?>