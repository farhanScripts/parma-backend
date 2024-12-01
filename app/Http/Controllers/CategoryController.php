<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Classes\ApiResponseClass;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepositoryInterface;    
    /**
     * Display a listing of the resource.
     */
    public function __construct(CategoryRepositoryInterface $categoryRepositoryInterface){
        $this->categoryRepositoryInterface = $categoryRepositoryInterface;
    }
     public function index()
    {
        $data = $this->categoryRepositoryInterface->index();
        return ApiResponseClass::sendResponse(CategoryResource::collection($data), 'Data retrieved success!', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $iconPath = null;

        // cek apakah request memiliki file icon
        if($request->hasFile('icon')){
            $iconPath = $request->file('icon')->store('category_icon', 'public');
        }

        $data = [
            'name' => $request->name, 
            'slug'=>Str::slug($request->name),
            'icon' => $iconPath
        ];

        DB::beginTransaction();
        try {
            $category = $this->categoryRepositoryInterface->store($data);
            DB::commit();

            return ApiResponseClass::sendResponse(new CategoryResource($category), 'Category Create Success!', 201);
        } catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = $this->categoryRepositoryInterface->getById($id);

        return ApiResponseClass::sendResponse(new CategoryResource($category), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request -> icon
        ];

        DB::beginTransaction();

        try {
            $category = $this->categoryRepositoryInterface->update($updateData, $id);
            DB::commit();
            return ApiResponseClass::sendResponse('Category Updated Successfully!', 201);
        } catch(\Exception $ex){
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->categoryRepositoryInterface->delete($id);

        return ApiResponseClass::sendResponse('Category Delete Successful!', '', 204);
    }
}
