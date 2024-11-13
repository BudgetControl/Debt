<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Entity;

use Budgetcontrol\Library\Model\Entry;

class Debits extends Entity {

    public readonly float $balance;

    /** @var array<int,Entry> $debts */
    private array $entries = [];

    public function __construct(float $balance, array $entries) {
        $this->balance = $balance;
        $this->entries = $entries;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function getDebts(): array {
        return $this->entries;
    }

    public function toArray(): array {
        return [
            'balance' => $this->balance,
            'entries' => $this->entries,
        ];
    }

}