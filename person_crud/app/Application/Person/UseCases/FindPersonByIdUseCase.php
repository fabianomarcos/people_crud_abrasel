<?php

namespace App\Application\Person\UseCases;

use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\Entities\Person;

class FindPersonByIdUseCase
{
    private PersonRepositoryInterface $repo;

    public function __construct(PersonRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(int $id): Person
    {
        $person = $this->repo->findById($id);

        if (!$person) {
            throw new \RuntimeException('Pessoa não encontrada.');
        }

        return $person;
    }
}
