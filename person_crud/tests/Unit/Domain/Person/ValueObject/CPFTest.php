<?php

namespace Tests\Domain\Person\ValueObjects;

use PHPUnit\Framework\TestCase;
use App\Domain\Person\ValueObjects\CPF;
use InvalidArgumentException;

class CpfTest extends TestCase
{
    public function test_valid_cpf()
    {
        $cpf = new Cpf('111.444.777-35');
        $this->assertEquals('111.444.777-35', (string)$cpf);
    }

    public function test_invalid_cpf_throws()
    {
        $this->expectException(InvalidArgumentException::class);
        new Cpf('000.000.000-00');
    }
}
