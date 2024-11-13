<?php
declare(strict_types=1);

namespace Budgetcontrol\Debt\Entity;

abstract class Entity {

    abstract public function toArray(): array;
    
}