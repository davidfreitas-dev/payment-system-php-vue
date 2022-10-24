<?php 

namespace App\Model;

use App\DB\Database;
use App\Response;
use MercadoPago\SDK;
use MercadoPago\Payment;
use PDO;

SDK::setAccessToken($_ENV['MP_ACCESS_TOKEN']);

class PaymentMethod {
        
    public static function pix()
    {
        try {

            $payment = new Payment();
          
            $payment->transaction_amount = 100;
            $payment->description = "Título do produto";
            $payment->payment_method_id = "pix";
            $payment->payer = array(
                "email" => "test@test.com",
                "first_name" => "Test",
                "last_name" => "User",
                "identification" => array(
                    "type" => "CPF",
                    "number" => "19119119100"
                  ),
                "address"=>  array(
                    "zip_code" => "06233200",
                    "street_name" => "Av. das Nações Unidas",
                    "street_number" => "3003",
                    "neighborhood" => "Bonfim",
                    "city" => "Osasco",
                    "federal_unit" => "SP"
                  )
              );
      
              $payment->save();
          
              return Response::handleResponse($payment->status, $payment->point_of_interaction);
    
        } catch (PDOException $e) {
          
              return Response::handleResponse("error", "Falha ao gerar QR code PIX: " . $e->getMessage());
          
        }
    }

}