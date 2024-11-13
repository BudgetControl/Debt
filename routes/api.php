<?php
/**
 *  application apps
 */

 $app->get('/{wsid}/payees', \Budgetcontrol\Debt\Controller\DebtController::class . ':getPayees');
 $app->get('/{wsid}/debits', \Budgetcontrol\Debt\Controller\DebtController::class . ':getDebits');
 $app->delete('/{wsid}/debt/{debt_id}', \Budgetcontrol\Debt\Controller\DebtController::class . ':delete');

$app->get('/monitor', \Budgetcontrol\Debt\Controller\DebtController::class . ':monitor');
