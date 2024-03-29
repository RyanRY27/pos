<?php

/**
 * 
 */
class Database
{


	protected function db_connect(){

	    $DBHOST = "localhost";
	    $DBNAME = "rmms_pos";
	    $DBUSER = "root";
	    $DBPASS = "";
	    $DBDDRIVER = "mysql";

	    try{

	        $con = new PDO("$DBDDRIVER:host=$DBHOST;dbname=$DBNAME",$DBUSER,$DBPASS);
	    }catch(PDOException $e){

	        echo $e->getMessage();
	    }

	    return $con;
	}




	public function query($query,$data = array())
	{

		$con = $this->db_connect();
		$smt = $con->prepare($query);
		$check = $smt->execute($data);

		if($check)
		{
			$result = $smt->fetchAll(PDO::FETCH_ASSOC);
			if(is_array($result) && count($result) > 0){

				return $result;
			}
			
		}

		return false;
	}



}