<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDisciplineRequest;
use App\Http\Requests\Admin\UpdateDisciplineRequest;
use App\Http\Resources\Admin\DisciplineCollection;
use App\Http\Resources\Admin\DisciplineResource;
use App\Models\Discipline;
use App\Models\Question;
use Illuminate\Http\JsonResponse;

class DisciplineController extends Controller
{
    /**
     * @return DisciplineCollection
     */
    public function index(): DisciplineCollection
    {
        return new DisciplineCollection(Discipline::all());
    }

    /**
     * @param Discipline $discipline
     * @return DisciplineResource
     */
    public function show(Discipline $discipline): DisciplineResource
    {
        return new DisciplineResource($discipline);
    }

    /**
     * @param StoreDisciplineRequest $request
     * @return JsonResponse
     */
    public function store(StoreDisciplineRequest $request): JsonResponse
    {
        $discipline = Discipline::create($request->validated());

        return response()->json([
            'message' => 'Disciplina criada com sucesso!',
            'discipline' => new DisciplineResource($discipline)
        ], 201);
    }

    /**
     * @param UpdateDisciplineRequest $request
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function update(UpdateDisciplineRequest $request, Discipline $discipline): JsonResponse
    {
        $discipline->update($request->validated());

        return response()->json([
            'message' => 'Disciplina atualizada com sucesso!',
            'discipline' => new DisciplineResource($discipline)
        ], 200);
    }

    /**
     * @param Discipline $discipline
     * @return JsonResponse
     */
    public function destroy(Discipline $discipline): JsonResponse
    {
        if ($discipline->id === 1) {
            return response()->json([
                'message' => 'Não é possível excluir a disciplina padrão!'
            ], 400);
        }

        $discipline->delete();

        Question::whereNull('discipline_id')->update(['discipline_id' => 1]);

        return response()->json([
            'message' => 'Disciplina excluída com sucesso!'
        ], 200);
    }
}
