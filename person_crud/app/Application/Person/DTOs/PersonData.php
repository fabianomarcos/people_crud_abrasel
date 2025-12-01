<?php
namespace App\Application\Person\DTOs;

class PersonData
{
    public ?int $id;
    public string $name;
    public string $cpf;
    public ?string $birth_date;

    public function __construct(array $data)
    {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->cpf = $data['cpf'];
        $this->birth_date = $data['birth_date'] ?? null;
    }
}
