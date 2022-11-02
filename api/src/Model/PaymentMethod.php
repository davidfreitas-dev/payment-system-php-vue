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
          
            $payment->transaction_amount = (float)$paymentData['price'];
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

    public static function getAll()
    {

        $results = [];

        try {
          
            $payment = new Payment();

            $payments = $payment->search([
                'sort' => 'date_created',
                'criteria' => 'desc'
            ])->getIterator();

            foreach ($payments as $key => $value) {

                $paymentDetails = array(
                    "id"  => $value->id,
                    "status"  => $value->status,
                    "description" => $value->description,
                    "transaction_amount" => $value->transaction_amount,
                    "payment_method_id" => $value->payment_method_id,
                    "date_created" => $value->date_created
                );

                $results[] = $paymentDetails;

            }
            
            if (count($results) === 0) {

              return Response::handleResponse("error", "Nenhum pagamento encontrado");

            }

            return Response::handleResponse("success", $results);

        } catch (PDOException $e) {
          
            return Response::handleResponse("error", "Falha ao obter a lista de pagamentos: " . $e->getMessage());

        }
        
    }

    public static function get($id)
    {

        try {
          
            $payment = new Payment();

            $paymentDetails = $payment->get($id);            
            
            if (!$paymentDetails) {                

                return Response::handleResponse("error", "Pagamento não encontrado");

            }

            $details = array(
                "id"  => $paymentDetails->id,
                "status"  => $paymentDetails->status,
                "description" => $paymentDetails->description,
                "transaction_amount" => $paymentDetails->transaction_amount,
                "payment_method_id" => $paymentDetails->payment_method_id,
                "date_created" => $paymentDetails->date_created
            );

            return Response::handleResponse("success", $details);

        } catch (PDOException $e) {
          
            return Response::handleResponse("error", "Falha ao obter detalhes do pagamento: " . $e->getMessage());

        }
        
    }

}