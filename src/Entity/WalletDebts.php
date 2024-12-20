<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Entity;

use Budgetcontrol\Library\Entity\Wallet;
use Budgetcontrol\Library\Model\Entry;
use Carbon\Carbon;

class WalletDebts extends Entity {

    private readonly string $type;
    private readonly string $uuid;
    private readonly string $name;
    private readonly string $createdAt;

    private Debits $debts;

    public function __construct(string $uuid, string $name, Carbon $createdAt, string $type = 'debit') {
        $this->type = $type;
        $this->uuid = $uuid;
        $this->name = $name;
        $this->createdAt = $createdAt->toDateTimeString();
        $this->debts = new Debits(0, []);
    }

    /**
     * Retrieves the wallet type.
     *
     * @return Wallet The wallet type.
     */
    public function getWalletType(): string {
        return $this->type;
    }

    /**
     * Retrieves the wallet UUID.
     *
     * @return string The wallet UUID.
     */
    public function getWalletUuid(): string {
        return $this->uuid;
    }

    /**
     * Retrieves the wallet name.
     *
     * @return string The wallet name.
     */
    public function getWalletName(): string {
        return $this->name;
    }

    /**
     * Retrieves the wallet creation date.
     *
     * @return string The wallet creation date.
     */
    public function getCreatedAt(): string {
        return $this->createdAt;
    }

    /**
     * Retrieves the debts.
     *
     * @return Debits The debts.
     */
    public function getDebts(): Debits {
        return $this->debts;
    }

    /**
     * Add a debt.
     *
     * @param Debt $debt The debt to add.
     * @return void
     */
    public function addDebt(Debits $debt): void {
        $this->debts = $debt;
    }

    /**
     * Converts the WalletDebts entity to an array.
     *
     * @return array The WalletDebts entity as an associative array.
     */
    public function toArray(): array {
        return [
            'type' => $this->type,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'createdAt' => $this->createdAt,
            'debts' => $this->debts->toArray(),
        ];
    }
}