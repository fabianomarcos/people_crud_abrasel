<?php

namespace App\Application\Person\UseCases;

use App\Domain\Person\ValueObjects\CPF;
use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Application\Person\DTOs\PersonData;

class UpdatePersonUseCase
{
    private PersonRepositoryInterface $repo;

    public function __construct(PersonRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function execute(int $id, PersonData $data): Person
    {
        $person = $this->repo->findById($id);
        if (!$person) {
            throw new \RuntimeException('Pessoa não encontrada.');
        }

        if ($data->cpf) {
            $cpfVo = new CPF($data->cpf);

            $existing = $this->repo->findByCpf((string)$cpfVo);
            if ($existing && $existing->id() !== $id) {
                throw new \RuntimeException('CPF já cadastrado.');
            }

            $person = $person->withCpf($cpfVo);
        }

        if ($data->name) {
            $person = $person->withName($data->name);
        }

        if ($data->birth_date) {
            $person = $person->withBirthDate(new \DateTimeImmutable($data->birth_date));
        }

        return $this->repo->save($person);
    }
}
