<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\PaymentMethod;

$app->post('/payment/pix', function (Request $request, Response $response, array $args) {

  $data = $request->getParsedBody();
 
  $result = PaymentMethod::pix($data);

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});

$app->get('/payments', function (Request $request, Response $response, array $args) {
 
  $result = PaymentMethod::getAll();

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});