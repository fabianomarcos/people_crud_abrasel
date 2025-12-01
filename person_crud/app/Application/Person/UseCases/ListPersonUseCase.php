<?php

namespace App\Application\Person\UseCases;

use App\Domain\Person\Repositories\PersonRepositoryInterface;

class ListPersonUseCase
{
    private PersonRepositoryInterface $repo;

    public function __construct(PersonRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(): array
    {
        return $this->repo->all();
    }
}
