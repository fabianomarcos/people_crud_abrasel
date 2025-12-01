<?php

namespace App\Application\Person\UseCases;

use App\Domain\Person\ValueObjects\Cpf;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Application\Person\DTOs\PersonData;
use App\Exceptions\ResourceAlreadyExistsException;

class CreatePersonUseCase
{
    private PersonRepositoryInterface $repo;

    public function __construct(PersonRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(PersonData $data): Person
    {
        $cpfVo = new Cpf($data->cpf);
        $birth = $data->birth_date ? new \DateTimeImmutable($data->birth_date) : null;
        $cpfExists = $this->repo->findByCpf((string)$cpfVo);

        if ($cpfExists) {
            throw new ResourceAlreadyExistsException('CPF já cadastrado.');
        }

        $person = new Person(null, $data->name, $cpfVo, $birth);
        return $this->repo->save($person);
    }
}
