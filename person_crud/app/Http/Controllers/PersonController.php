<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\{PersonStoreRequest, PersonUpdateRequest};
use App\Application\Person\DTOs\PersonData;
use App\Application\Person\Presenters\PersonPresenter;
use App\Application\Person\UseCases\{CreatePersonUseCase, DeletePersonUseCase, FindPersonByIdUseCase, ListPersonUseCase, UpdatePersonUseCase};
use App\Exceptions\ResourceAlreadyExistsException;

class PersonController extends Controller
{
    private PersonPresenter $presenter;

    private CreatePersonUseCase $createUseCase;
    private UpdatePersonUseCase $updateUseCase;
    private DeletePersonUseCase $deleteUseCase;
    private ListPersonUseCase $listUseCase;
    private FindPersonByIdUseCase $findByIdUseCase;

    public function __construct(
        PersonPresenter $presenter,
        CreatePersonUseCase $createUseCase,
        UpdatePersonUseCase $updateUseCase,
        DeletePersonUseCase $deleteUseCase,
        ListPersonUseCase $listUseCase,
        FindPersonByIdUseCase $findByIdUseCase,
    ) {
        $this->presenter = $presenter;
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

            return response()->json([
                'data' => $this->presenter->presentList($people)
            ]);
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $p = $this->findByIdUseCase->execute($id);
            if (!$p) return response()->json(['message' => 'Not found'], 404);

            return response()->json($this->presenter->present($p));
        } catch (\DomainException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function store(PersonStoreRequest $request): JsonResponse
    {
        try {
            $dto = new PersonData($request->validated());
            $person = $this->createUseCase->execute($dto);

            return response()->json(
                $this->presenter->present($person),
                201
            );
        } catch (ResourceAlreadyExistsException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function update(int $id, PersonUpdateRequest $request): JsonResponse
    {
        try {
            $dto = new PersonData($request->validated());
            $person = $this->updateUseCase->execute($id, $dto);

            return response()->json($this->presenter->present($person));
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
