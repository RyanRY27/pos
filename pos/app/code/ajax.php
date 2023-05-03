<?php 

defined("ABSPATH") ? "":die();

//capture ajax data
$raw_data = file_get_contents("php://input");
if(!empty($raw_data))
{

	$OBJ = json_decode($raw_data,true);
	if(is_array($OBJ))
	{
		if($OBJ['data_type'] == "search")
		{

			$productClass = new Product();

			if(!empty($OBJ['text']))
			{
				//search
				$barcode = $OBJ['text'];
				$text = "%".$OBJ['text']."%";
				$query = "select * from products where description like :find || barcode = :barcode limit 10";
				$rows = $productClass->query($query,['find'=>$text,'barcode'=>$barcode]);

			}else{
				//get all
				$rows = $productClass->getAll();
			}
			
			if($rows){

				foreach ($rows as $key => $row) {
					
					$rows[$key]['description'] = strtoupper($row['description']);
					$rows[$key]['image'] = crop($row['image']);
				}

				$info['data_type'] = "search";
				$info['data'] = $rows;
				
				echo json_encode($info);

			}

		}else

		if($OBJ['data_type'] == "checkout")
		{

			$data 		= $OBJ['text'];
			$receipt_no = get_receipt_no();
			$user_id 	= auth("id");
			$date 		= date("Y-m-d H:i:s");

			$db = new Database();

			//read database
			foreach ($data as $row) {
				
				$arr = [];
				$arr['id'] = $row['id'];
				$query = "select * from products where id = :id limit 1";
				$check = $db->query($query, $arr);

				if(is_array($check))
				{	
					$check = $check[0];

					//save database
					$arr = [];
					$arr['barcode'] 	= $check['barcode']; 
					$arr['description'] = $check['description'];
					$arr['amount'] 		= $check['amount'];
					$arr['qty'] 		= $row['qty'];
					$arr['total'] 		= $row['qty'] * $check['amount'];
					$arr['receipt_no'] 	= $receipt_no;
					$arr['date'] 		= $date;
					$arr['user_id'] 	= $user_id; 

					$query = "insert into sales (barcode,date,receipt_no,description,qty,amount,total,user_id) values (:barcode,:date,:receipt_no,:description,:qty,:amount,:total,:user_id)";
					$db->query($query, $arr);
				}


			}

			//barcode date	receipt_no	description	qty	amount	total	date	user_id

			$info['data_type'] = "checkout";
			$info['data'] = "Items saved succesfully!";
				
			echo json_encode($info);

		}
	}
}

