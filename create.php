<?php
	class DB_service{
		private $steamURL='null', $day='null', $ip='null';

		public function add_to_db($s, $d, $i, $ip, $tb){
			if($this->check_hash_sum($s, $d, $i) and $this->check_user_ip($s, $tb)){
				printf("%s", json_encode("added"));
				$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
				$query = "INSERT INTO $tb(offtrade, ip) VALUES (?, ?)";
				if($stmt = mysqli_prepare($conn, $query)){
    				mysqli_stmt_bind_param($stmt, "ss", $s, $ip);
					    mysqli_stmt_execute($stmt);
					    echo "Records inserted successfully.";
					} else{
					    echo "ERROR: Could not prepare query: $query. " . mysqli_error($conn);
					}
 
				mysqli_stmt_close($stmt);
				mysqli_close($conn);
			}
			else {
				printf("%s", json_encode("error"));
				return;}
		}

		public function getDate(){
			return (date('d')).date(".m.")."20".date("y");
		}

		public function getDates(){
			return ("20".date("y")).date("-m-").date('d');
		}

		public function select_from_db($tb){
				$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
				$query = "SELECT * FROM $tb";
				$stack = array();
				$req = mysqli_query($conn, $query);
				while($res = mysqli_fetch_assoc($req)){
					array_push($stack, $res);
				}
				mysqli_close($conn);
				return $stack;
		}

		private function check_hash_sum($offt, $game, $hash){
			$date = $this->getDate();
			
			echo $offt."@".$game."@0x45bc4a@".$date;

			if(md5($offt."@".$game."@0x45bc4a@".$date) == $hash){
				return true;
			}
			else {
				return false;
			}
		}

		public function getversion(){
			$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
			$query = "SELECT * FROM `client_data`";
			$res = mysqli_query($conn, $query);
			
			if ($row = mysqli_fetch_assoc($res)) {
				printf("%s", json_encode($row));
				mysqli_close($conn);
			}
			else {
				mysqli_close($conn);
			}
		}

		private function check_user_ip($offt, $table_name){
			$conn = mysqli_connect('localhost', 'u625594111_root', '1q3rdps9', 'u625594111_mydb');
			$query = "SELECT offtrade FROM `".$table_name."` WHERE offtrade='".$offt."'";
			$res = mysqli_query($conn, $query);
			
			if (mysqli_fetch_assoc($res)) {
				mysqli_close($conn);
				return false;
			}
			else {
				mysqli_close($conn);
				return true;
			}
		}
	}
	

?>