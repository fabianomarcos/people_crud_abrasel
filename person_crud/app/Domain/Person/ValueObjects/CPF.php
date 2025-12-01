<?php

namespace App\Domain\Person\ValueObjects;

use InvalidArgumentException;

final class CPF
{
    private string $value;

    public function __construct(string $cpf)
    {
        $normalized = $this->normalize($cpf);
        if (!$this->isValid($normalized)) {
            throw new InvalidArgumentException("CPF inválido: {$cpf}");
        }
        $this->value = $this->format($normalized);
    }

    private function normalize(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }

    private function format(string $cpf): string
    {
        return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
    }

    private function isValid(string $cpf): bool
    {
        if (strlen($cpf) !== 11) return false;
        if (preg_match('/(^(\d)\1+$)/', $cpf)) return false;

        // cálculo dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function raw(): string
    {
        return preg_replace('/\D/', '', $this->value);
    }
}
