<?php

namespace App\Application\Person\Presenters;

use App\Domain\Person\Entities\Person;

interface PersonPresenter
{
    public function present(Person $person): array;
    public function presentList(array $people): array;
}
