<?php
namespace App\Domain\Person\Repositories;

use App\Domain\Person\Entities\Person;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PersonRepositoryInterface
{
    public function save(Person $person): Person;
    public function findById(int $id): ?Person;
    public function findByCpf(string $cpf): ?Person;
    public function delete(int $id): void;
    public function all(): array;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
}
