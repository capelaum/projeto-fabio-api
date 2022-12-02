<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DisciplineCollection;
use App\Http\Resources\Admin\DisciplineResource;
use App\Models\Discipline;

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
}
