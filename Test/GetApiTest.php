<?php

use Budgetcontrol\Debt\Controller\DebtController;
use Budgetcontrol\Library\Model\Payee;
use MLAB\PHPITest\Entity\Json;
use MLAB\PHPITest\Assertions\JsonAssert;
use Slim\Http\Interfaces\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetApiTest extends \PHPUnit\Framework\TestCase
{

    public function test_get_payees_list()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new DebtController();
        $result = $controller->getPayees($request, $response, ['wsid' => 1]);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(200, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/debit-list.json'));

        $assertionContent->assertJsonStructure((array) $assertions);
    }

    public function test_get_debits_list()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new DebtController();
        $result = $controller->getDebits($request, $response, ['wsid' => 1]);
        $contentArray = json_decode((string) $result->getBody());

        $this->assertEquals(200, $result->getStatusCode());

        $assertionContent = new JsonAssert(new Json($contentArray));
        $assertions = json_decode(file_get_contents(__DIR__ . '/assertions/debit-list.json'));

        $assertionContent->assertJsonStructure((array) $assertions);
    }

    public function test_delete_debt()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $controller = new DebtController();
        $result = $controller->delete($request, $response, ['wsid' => 1, 'debt_id' => '0a06e21c-895b-4be0-9585-4fb0780d9358']);

        $this->assertEquals(200, $result->getStatusCode());

        $debt = Payee::where('uuid', '0a06e21c-895b-4be0-9585-4fb0780d9358')->first();
        $this->assertNull($debt);
    }

}
