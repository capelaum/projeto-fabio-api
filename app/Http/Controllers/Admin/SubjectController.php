<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubjectRequest;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Http\Resources\Admin\SubjectCollection;
use App\Http\Resources\Admin\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    /**
     * @return SubjectCollection
     */
    public function index(): SubjectCollection
    {
        return new SubjectCollection(Subject::all());
    }

    /**
     * @param Subject $subject
     * @return SubjectResource
     */
    public function show(Subject $subject): SubjectResource
    {
        return new SubjectResource($subject);
    }

    /**
     * @param StoreSubjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreSubjectRequest $request): JsonResponse
    {
        $subject = Subject::create($request->validated());

        return response()->json([
            'message' => 'Assunto criado com sucesso!',
            'discipline' => new SubjectResource($subject)
        ], 201);
    }

    /**
     * @param UpdateSubjectRequest $request
     * @param Subject $subject
     * @return JsonResponse
     */
    public function update(UpdateSubjectRequest $request, Subject $subject): JsonResponse
    {
        $subject->update($request->validated());

        return response()->json([
            'message' => 'Assunto atualizado com sucesso!',
            'discipline' => new SubjectResource($subject)
        ], 200);
    }
    /**
     * @param Subject $subject
     * @return JsonResponse
     */
    public function destroy(Subject $subject): JsonResponse
    {
        $subject->delete();

        return response()->json([
            'message' => 'Assunto excluído com sucesso!'
        ], 200);
    }
}
