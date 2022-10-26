<?php 

namespace App\Model;

use App\DB\Database;
use App\Response;
use MercadoPago\SDK;
use MercadoPago\Payment;
use PDO;

SDK::setAccessToken($_ENV['MP_ACCESS_TOKEN']);

class PaymentMethod {
        
    public static function pix($paymentData)
    {

        try {

            $payment = new Payment();
          
            $payment->transaction_amount = $paymentData['price'];
            $payment->description = $paymentData['description'];
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
    
            if (!$payment->save()) {

              return Response::handleResponse("error", "Falha ao gerar o QR Code PIX");

            }
          
            return Response::handleResponse($payment->status, $payment->point_of_interaction);
    
        } catch (PDOException $e) {
          
            return Response::handleResponse("error", "Falha ao criar a transação: " . $e->getMessage());
          
        }

    }

}