<?php
namespace Budgetcontrol\Debt\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Controller {


    public function monitor(Request $request, Response $response)
    {
        return response([
            'success' => true,
            'message' => env('APP_NAME','Debit').' service is up and running'
        ]);
    }


}