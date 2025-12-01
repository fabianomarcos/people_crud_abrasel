<?php
namespace App\Infra\Persistence\Eloquent\Repositories;

use App\Domain\Person\Entities\Person;
use App\Domain\Person\Repositories\PersonRepositoryInterface;
use App\Domain\Person\ValueObjects\CPF;
use App\Infra\Persistence\Eloquent\Models\PersonModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PersonRepositoryEloquent implements PersonRepositoryInterface
{
    public function save(Person $person): Person
    {
        $data = [
            'name' => $person->name(),
            'cpf' => (string)$person->cpf(),
            'birth_date' => $person->birth_date()?->format('Y-m-d'),
        ];

        if ($person->id()) {
            $model = PersonModel::find($person->id());
            $model->update($data);
        } else {
            $model = PersonModel::create($data);
        }

        return $this->toEntity($model);
    }

    public function findById(int $id): ?Person
    {
        $model = PersonModel::find($id);
        return $model ? $this->toEntity($model) : null;
    }

    public function findByCpf(string $cpf): ?Person
    {
        $norm = preg_replace('/\D/', '', $cpf);
        $model = PersonModel::whereRaw("REPLACE(REPLACE(REPLACE(cpf,'.',''),'-',''),' ', '') = ?", [$norm])->first();
        return $model ? $this->toEntity($model) : null;
    }

    public function delete(int $id): void
    {
        PersonModel::destroy($id);
    }

    public function all(): array
    {
        return PersonModel::all()->map(fn($m) => $this->toEntity($m))->all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return PersonModel::paginate($perPage)->through(fn($m) => $this->toEntity($m));
    }

    private function toEntity(PersonModel $model): Person
    {
        $cpf = new Cpf($model->cpf);
        $birth = $model->birth_date ? new \DateTimeImmutable($model->birth_date) : null;
        return new Person($model->id, $model->name, $cpf, $birth);
    }
}
