<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\PaymentMethod;

$app->post('/payment/pix', function (Request $request, Response $response, array $args) {
 
  $result = PaymentMethod::pix();

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});