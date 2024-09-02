<?php
/**
 *  application apps
 */

 $app->get('/{wsid}/payees', \Budgetcontrol\Debt\Controller\DebtController::class . ':getPayees');
 $app->delete('/{wsid}/debt/{debt_id}', \Budgetcontrol\Debt\Controller\DebtController::class . ':delete');

$app->get('/monitor', 'Budgetcontrol\Core\Http\Controller\Controller:monitor');