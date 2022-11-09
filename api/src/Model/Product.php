<?php 

namespace App\Model;

use App\DB\Database;
use App\Response;
use PDO;

class Product {

	public static function all() 
	{
		
		$sql = "SELECT * FROM tb_products ORDER BY desproduct";		
		
		try {

			$db = new Database();

			$result = $db->select($sql);
			
			if (count($result) > 0) {

				return Response::handleResponse("success", $result);

			} else {

				return Response::handleResponse("success", "Nenhum produto encontrado!");

			}

		} catch (PDOException $e) {

			return Response::handleResponse("error", "Falha ao obter produtos: " . $e->getMessage());
			
		}		

	}

}

 ?>