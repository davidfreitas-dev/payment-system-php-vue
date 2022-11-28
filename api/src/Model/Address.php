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

}