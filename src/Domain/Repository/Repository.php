<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Domain\Repository;

abstract class Repository {

    protected readonly int $workspaceId;

    public function __construct(int $workspaceId) {
        $this->workspaceId = $workspaceId;
    }
}