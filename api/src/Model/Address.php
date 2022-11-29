<?php 

namespace App\Model;

use App\DB\Database;
use App\Response;
use PDO;

class Address {

    public static function getByCEP($nrcep)
    {

        $nrcep = str_replace("-", "", $nrcep);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "http://viacep.com.br/ws/$nrcep/json/");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $data = json_decode(curl_exec($ch), true);

        curl_close($ch);

        if (count($data) === 1 && $data["erro"]) {

          return Response::handleResponse("error", "CEP incorreto ou inexistente.");
          
        }

        return Response::handleResponse("success", $data);

    }

    public static function save($address)
    {

      $sql = "CALL sp_addresses_save(:idaddress, :idperson, :desaddress, :desnumber, :descomplement, :descity, :desstate, :descountry, :deszipcode, :desdistrict)";

      try {
        
        $db = new Database();

        $results = $db->select($sql, array(
          ":idaddress"=>$address['addressId'],
          ":idperson"=>$address['userId'],
          ":desaddress"=>$address['addressName'],
          ":desnumber"=>$address['addressNumber'],
          ":descomplement"=>$address['complement'],
          ":descity"=>$address['city'],
          ":desstate"=>$address['state'],
          ":descountry"=>'Brasil',
          ":deszipcode"=>$address['zipcode'],
          ":desdistrict"=>$address['district']
        ));

        if (count($results) > 0) {
          
          return Response::handleResponse("success", "Endereço cadastrado com sucesso!");
          
        }

      } catch (PDOException $e) {
        
        return Response::handleResponse("error", "Falha ao cadastrar endereço: " . $e->getMessage());

      }      

    }

}