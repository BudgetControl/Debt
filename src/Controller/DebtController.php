<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Controller;

use Budgetcontrol\Debt\Domain\Repository\DebtRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Budgetcontrol\Library\Model\Payee;

class DebtController extends Controller {

    /**
     * Retrieves the payees.
     *
     * @param Request $request The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $args The route parameters.
     * @return Response The HTTP response.
     */
    public function getPayees(Request $request, Response $response, array $args): Response {

        $wsid = (int) $args['wsid'];
        $repository = new DebtRepository($wsid);
        $payeesList = $repository->getPayeesWithEntry();
        $creditCardsDebts = $repository->getCreditCardsDebts();

        if(empty($payeesList) && empty($creditCardsDebts)) {
            return response(['message' => 'No payees found'], 404);
        }

        $payees = $payeesList->toArray();
        $creditCards = $creditCardsDebts->toArray();

        $results = array_merge($payees, $creditCards);

        return response($results);
    }

    /**
     * Delete a debt.
     *
     * @param Request $request The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $args The route parameters.
     * @return Response The updated HTTP response object.
     */
    public function delete(Request $request, Response $response, array $args): Response {

        $wsid = (int) $args['wsid'];
        $debtId = $args['debt_id'];

        $repository = new DebtRepository($wsid);
        $payee = $repository->getPayeeByUuid($debtId);

        if ($payee) {
            $payee->delete();
            return response(['message' => 'Payee deleted successfully']);
        }

        return response(['message' => 'Payee not found'], 404);
    }

    /**
     * Retrieves the total debt for all credit cards.
     *
     * @param Request $request The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $args The route arguments.
     * @return Response The HTTP response with the total credit card debt.
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