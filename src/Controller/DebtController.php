<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Controller;

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

        $wsid = $args['wsid'];
        $payeesList = Payee::with('entry')->where('workspace_id', $wsid)->get();

        return response($payeesList->toArray());
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

        $wsid = $args['wsid'];
        $debtId = $args['debt_id'];

        $payee = Payee::where('workspace_id', $wsid)->where('uuid', $debtId)->first();

        if ($payee) {
            $payee->delete();
            return response(['message' => 'Payee deleted successfully']);
        }

        return response(['message' => 'Payee not found'], 404);
    }
}