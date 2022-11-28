<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\Address;

$app->post('/getbycep', function (Request $request, Response $response) {

  $data = $request->getParsedBody();

  $result = Address::getByCEP($data["cep"]);

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});