<?php

use Budgetcontrol\Library\Model\Debit;
use Budgetcontrol\Library\Model\Payee;
use Budgetcontrol\Seeds\Resources\Seed;
use Phinx\Seed\AbstractSeed;
use Ramsey\Uuid\Uuid;

class MainSeeds extends AbstractSeed
{

    public function run(): void
    {
        $seeds = new Seed();
        $seeds->runAllSeeds();

        // create list of payees
        $payees = [
            [
                'name' => 'John Doe',
                'workspace_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'uuid' => "0a06e21c-895b-4be0-9585-4fb0780d9358"
            ],
            [
                'name' => 'Jane Doe',
                'workspace_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'uuid' => Uuid::uuid4()
            ],
            [
                'name' => 'John Smith',
                'workspace_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'uuid' => Uuid::uuid4()
            ],
            [
                'name' => 'Jane Smith',
                'workspace_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'uuid' => Uuid::uuid4()
            ]
        ];

        foreach ($payees as $payeeData) {
            $payee = new Payee();
            $payee->name = $payeeData['name'];
            $payee->workspace_id = $payeeData['workspace_id'];
            $payee->created_at = $payeeData['created_at'];
            $payee->updated_at = $payeeData['updated_at'];
            $payee->uuid = $payeeData['uuid'];
            $payee->save();

            $payeeId = $payee->id;
            $entry = new Debit();
            $entry->payee_id = $payeeId;
            $entry->workspace_id = 1;
            $entry->created_at = date('Y-m-d H:i:s');
            $entry->updated_at = date('Y-m-d H:i:s');
            $entry->uuid = Uuid::uuid4();
            $entry->amount = rand(1, 1000) * -1;
            $entry->note = 'Test entry';
            $entry->date_time = date('Y-m-d H:i:s');
            $entry->account_id = 1;
            $entry->currency_id = 1;
            $entry->save();

        }
    }
}
