<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryCollection;
use App\Http\Resources\Admin\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * @return CategoryCollection
     */
    public function index(): CategoryCollection
    {
        return new CategoryCollection(Category::all());
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $cloudinaryFolder = config('app.cloudinary_folder');

        $data['image_url'] = $request->file('image')
            ->storeOnCloudinary("$cloudinaryFolder/categorias")
            ->getSecurePath();

        $category = Category::create($data);

        return response()->json([
            'message' => 'Categoria criada com sucesso!',
            'category' => new CategoryResource($category)
        ], 201);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $cloudinaryFolder = config('app.cloudinary_folder');

            $imageUrlArray = explode('/', $category->image_url);
            $publicId = explode('.', end($imageUrlArray))[0];

            $data['image_url'] = $request->file('image')
                ->storeOnCloudinaryAs("$cloudinaryFolder/categorias", $publicId)
                ->getSecurePath();
        }

        $category->update($data);

        return response()->json([
            'message' => 'Categoria atualizada com sucesso!',
            'category' => new CategoryResource($category)
        ], 200);
    }
}
