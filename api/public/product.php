<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Model\Product;

$app->get('/products', function (Request $request, Response $response) {

  $result = Product::all();

  $response->getBody()->write($result);

  return $response->withHeader('content-type', 'application/json');

});