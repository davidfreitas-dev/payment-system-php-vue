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

$app->get('/addresses/{id}', function (Request $request, Response $response) {

  $id = $request->getAttribute('id');

  $result = Address::all($id);

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});

$app->post('/address/add', function (Request $request, Response $response) {

  $data = $request->getParsedBody();

  $result = Address::save($data);

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});