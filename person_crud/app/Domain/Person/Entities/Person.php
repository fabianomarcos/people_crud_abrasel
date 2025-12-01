<?php

namespace App\Domain\Person\Entities;

use App\Domain\Person\ValueObjects\CPF;

final class Person
{
    private ?int $id;
    private string $name;
    private CPF $cpf;
    private ?\DateTimeImmutable $birth_date;

    public function __construct(?int $id, string $name, CPF $cpf, ?\DateTimeImmutable $birth_date = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->cpf = $cpf;
        $this->birth_date = $birth_date;
    }

    public function id(): ?int
    {
        return $this->id;
    }
    public function name(): string
    {
        return $this->name;
    }
    public function cpf(): CPF
    {
        return $this->cpf;
    }
    public function birth_date(): ?\DateTimeImmutable
    {
        return $this->birth_date;
    }

    public function age(): ?int
    {
        if (!$this->birth_date) return null;
        $now = new \DateTimeImmutable("now");
        $diff = $now->diff($this->birth_date);
        return $diff->y;
    }

    public function withName(string $name): self
    {
        return new self($this->id, $name, $this->cpf, $this->birth_date);
    }

    public function withCpf(CPF $cpf): self
    {
        return new self($this->id, $this->name, $cpf, $this->birth_date);
    }

    public function withBirthDate(\DateTimeImmutable $birth_date): self
    {
        return new self($this->id, $this->name, $this->cpf, $birth_date);
    }
}
