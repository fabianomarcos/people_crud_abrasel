<?php
class PeopleRepository {
    private PDO $pdo;
    public function __construct(PDO $pdo) { $this->pdo = $pdo; }

    public function all(): array {
        $stmt = $this->pdo->query("SELECT id, name, cpf, age, created_at, updated_at FROM people ORDER BY updated_at");
        return $stmt->fetchAll();
    }

    public function create(string $name, string $cpf, ?int $age): int {
        $stmt = $this->pdo->prepare("INSERT INTO people (name, cpf, age) VALUES (?, ?, ?)");
        $stmt->execute([$name, $cpf, $age]);
        return (int)$this->pdo->lastInsertId();
    }
}