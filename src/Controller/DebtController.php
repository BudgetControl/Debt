<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Controller;

use Budgetcontrol\Debt\Domain\Repository\DebtRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Budgetcontrol\Library\Model\Payee;

class DebtController extends Controller {

    /**
     * Retrieves the list of payees.
     *
     * @param Request $request The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $args The route arguments.
     * @return Response The HTTP response with the list of payees.
     */
    public function getCreditCardsDebts(Request $request, Response $response, array $args): Response 
    {
        $wsid = (int) $args['wsid'];
        $repository = new DebtRepository($wsid);
        $payeesList = $repository->getCreditCardsDebts();

        if(empty($payeesList)) {
            return response(['message' => 'No credit card debts found'], 404);
        }

        return response($payeesList->toArray());
    }
}