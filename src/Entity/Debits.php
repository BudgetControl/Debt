<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Entity;

use Budgetcontrol\Library\Model\Entry;

class Debits extends Entity {

    public readonly float $balance;

    /** @var array<int,Entry> $debts */
    private array $debts = [];

    public function __construct(float $balance, array $debts) {
        $this->balance = $balance;
        $this->debts = $debts;
    }

    public function getBalance(): float {
        return $this->balance;
    }

    public function getDebts(): array {
        return $this->debts;
    }

    public function toArray(): array {
        return [
            'balance' => $this->balance,
            'debts' => $this->debts,
        ];
    }

}