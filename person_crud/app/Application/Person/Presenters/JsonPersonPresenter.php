<?php

namespace App\Application\Person\Presenters;

use App\Application\Person\Presenters\PersonPresenter;
use App\Domain\Person\Entities\Person;

class JsonPersonPresenter implements PersonPresenter
{
    public function present(Person $person): array
    {
        return [
            'id' => $person->id(),
            'name' => $person->name(),
            'cpf' => (string)$person->cpf(),
            'birth_date' => $person->birth_date()?->format('Y-m-d'),
            'age' => $person->age(),
        ];
    }

    public function presentList(array $people): array
    {
        return array_map(fn(Person $p) => $this->present($p), $people);
    }
}
