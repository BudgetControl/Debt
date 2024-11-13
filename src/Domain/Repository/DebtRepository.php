<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Domain\Repository;

use Budgetcontrol\Debt\Entity\Debits;
use Budgetcontrol\Debt\Entity\WalletDebts;
use Budgetcontrol\Library\Entity\Entry as EntityEntry;
use Budgetcontrol\Library\Entity\Wallet as WalletType;
use Budgetcontrol\Library\Model\Payee;
use Budgetcontrol\Library\Model\Wallet;
use Illuminate\Database\Eloquent\Collection;
use Budgetcontrol\Library\Model\Entry;
use Webit\Wrapper\BcMath\BcMathNumber;

class DebtRepository extends Repository {

    protected readonly int $workspaceId;

    /**
     * Retrieves the payees.
     *
     * @param int $wsid The workspace id.
     * @return Illuminate\Database\Eloquent\Collection<int, Budgetcontrol\Library\Model\Payee> The payees list.
     */
    public function getPayees(): Collection {
        return Payee::where('workspace_id', $this->workspaceId)->get();
    }

    /**
     * Retrieves the payees.
     *
     * @param int $wsid The workspace id.
     * @return Collection The payees list.
     */
    public function getPayeesWithEntry(): Collection {
        $debitsList = Payee::with('entry')->where('workspace_id', $this->workspaceId)->get();
        $results = new Collection();

        foreach($debitsList as $payee) {
            $walletDebit = new WalletDebts($payee->uuid, $payee->name, $payee->created_at);
            $entries = $payee->entry->toArray();
            $balance = $this->sumEntries($payee->entry, 0);
            $debits = new Debits($balance, $entries);
            $walletDebit->addDebt($debits);

            $results->add($walletDebit->toArray());
        }

        return $results;
    }

    /**
     * Retrieve the payee information by UUID.
     *
     * @param string $uuid The UUID of the payee.
     * @return ?Collection The collection of payee information or null if not found.
     */
    public function getPayeeByUuid(string $uuid): ?Collection
    {
        $payee = Payee::where('workspace_id', $this->workspaceId)->where('uuid', $uuid)->first();

        if($payee) {
            return $payee;
        }

        return null;
    }

    /**
     * Retrieves the total debt for all credit cards.
     *
     * @return Collection The total debt for all credit cards.
     */
    public function getCreditCardsDebts(): ?Collection {
        
        $collection = new Collection();
        $wallets = Wallet::where('type', WalletType::creditCardRevolving->value)->get();

        foreach($wallets as $wallet) {
            $walletDebit = new WalletDebts($wallet->uuid, $wallet->name, $wallet->created_at, WalletType::creditCardRevolving->value);
            $debts = $this->retriveEntries($wallet->id);

            if(!$debts->isEmpty()) {
                $balance = (float) $wallet->balance;
                $debit = new Debits($balance, $debts->toArray());
                $walletDebit->addDebt($debit);
            }

            $collection->add($walletDebit->toArray()); //FIXME: toArray() is not better use here
        }

        return $collection;

    }

    /**
     * Retrieve entries for a given wallet ID.
     *
     * @param int $walletId The ID of the wallet to retrieve entries for.
     * @return Collection The collection of entries associated with the specified wallet ID.
     */
    private function retriveEntries(int $walletId): Collection
    {
        $entries = Entry::where('workspace_id', $this->workspaceId)
        ->where('account_id', $walletId)
        ->where('type', EntityEntry::debit->value)
        ->get();

        return $entries;
    }

    /**
     * Sums the entries in the given collection and adds the result to the provided balance.
     *
     * @param Collection $entries The collection of entries to be summed.
     * @param int|float $balance The initial balance to which the sum of entries will be added.
     * @return float The resulting balance after adding the sum of entries.
     */
    protected function sumEntries(Collection $entries, int|float $balance): float
    {
        $total = new BcMathNumber($balance);

        foreach($entries as $entry) {
            if(!$entry instanceof Entry) {
                throw new \InvalidArgumentException('Invalid entry type');
            }

            $total = $total->add($entry->amount);
        }

        return $total->toFloat();
    }

}
