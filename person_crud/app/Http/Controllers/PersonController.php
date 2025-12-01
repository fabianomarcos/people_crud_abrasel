<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{PersonStoreRequest, PersonUpdateRequest};
use App\Application\Person\DTOs\PersonData;
use App\Application\Person\UseCases\{CreatePersonUseCase, DeletePersonUseCase, FindPersonByIdUseCase, ListPersonUseCase, UpdatePersonUseCase};
use App\Exceptions\ResourceAlreadyExistsException;

class PersonController extends Controller
{
    private CreatePersonUseCase $createUseCase;
    private UpdatePersonUseCase $updateUseCase;
    private DeletePersonUseCase $deleteUseCase;
    private ListPersonUseCase $listUseCase;
    private FindPersonByIdUseCase $findByIdUseCase;

    public function __construct(
        CreatePersonUseCase $createUseCase,
        UpdatePersonUseCase $updateUseCase,
        DeletePersonUseCase $deleteUseCase,
        ListPersonUseCase $listUseCase,
        FindPersonByIdUseCase $findByIdUseCase,
    ) {
        $this->createUseCase = $createUseCase;
        $this->updateUseCase = $updateUseCase;
        $this->deleteUseCase = $deleteUseCase;
        $this->listUseCase = $listUseCase;
        $this->findByIdUseCase = $findByIdUseCase;
    }

    public function index(): JsonResponse
    {
        try {
            $people = $this->listUseCase->execute();

            $result = array_map(fn($p) => [
                'id' => $p->id(),
                'name' => $p->name(),
                'cpf' => (string)$p->cpf(),
                'birth_date' => $p->birth_date()?->format('Y-m-d'),
                'age' => $p->age(),
            ], $people);

            return response()->json(["data" => $result]);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $p = $this->findByIdUseCase->execute($id);
            if (!$p) return response()->json(['message' => 'Not found'], 404);

            return response()->json([
                'id' => $p->id(),
                'name' => $p->name(),
                'cpf' => (string)$p->cpf(),
                'birth_date' => $p->birth_date()?->format('Y-m-d'),
                'age' => $p->age(),
            ]);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(PersonStoreRequest $request): JsonResponse
    {
        try {
            $dto = new PersonData($request->validated());
            $person = $this->createUseCase->execute($dto);

            return response()->json([
                'id' => $person->id(),
                'name' => $person->name(),
                'cpf' => (string)$person->cpf(),
                'birth_date' => $person->birth_date()?->format('Y-m-d'),
                'age' => $person->age(),
            ], 201);
        } catch (ResourceAlreadyExistsException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(int $id, PersonUpdateRequest $request): JsonResponse
    {
        try {
            $dto = new PersonData($request->validated());
            $person = $this->updateUseCase->execute($id, $dto);

            return response()->json([
                'id' => $person->id(),
                'name' => $person->name(),
                'cpf' => (string)$person->cpf(),
                'birth_date' => $person->birth_date()?->format('Y-m-d'),
                'age' => $person->age(),
            ]);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->deleteUseCase->execute($id);
            return response()->json(null, 204);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
