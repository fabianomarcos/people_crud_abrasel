<?php

namespace App\Application\Person\UseCases;

use App\Domain\Person\Repositories\PersonRepositoryInterface;

class DeletePersonUseCase
{
    private PersonRepositoryInterface $repo;

    public function __construct(PersonRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(int $id): void
    {
        $person = $this->repo->findById($id);

        if (!$person) {
            throw new \RuntimeException('Pessoa não encontrada.');
        }

        $this->repo->delete($person->id());
    }
}
