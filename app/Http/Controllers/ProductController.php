<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Repositories\CategoryRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface) {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
    public function index()
    {
        $products = $this->productRepositoryInterface->index();
        return ApiResponseClass::sendResponse(ProductResource::collection($products), "Get products success!", 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $categoryId = (int) $request->category_id;

        $categoryRepo = new CategoryRepository();
        $category = $categoryRepo->getById($categoryId); 
            
        if(!$category) { //validasi
            return ApiResponseClass::errorResponse("Category not found", 400);
        }

        try {
            $photoPath = $request->file('photo')->store('product_photo', 'public');
            
            $reqBody = [
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'photo' => $photoPath,
                'about' => $request->about,
                'price' => $request->price,
                'category_id' => $categoryId,
            ];

            DB::beginTransaction();

            $product = $this->productRepositoryInterface->store($reqBody);

            DB::commit();

            return ApiResponseClass::sendResponse(new ProductResource($product), 'Product created!', 201);
        
        } catch (Exception $ex) {
            return ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
