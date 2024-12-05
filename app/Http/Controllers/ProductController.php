<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use App\Classes\ApiResponseClass;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Interfaces\ProductRepositoryInteface;

class ProductController extends Controller
{
    private ProductRepositoryInteface $productRepositoryInterface;
    public function __construct(ProductRepositoryInteface $productRepositoryInterface) 
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->getAllProducts();

        return ApiResponseClass::sendResponse(ProductResource::collection($data), '');
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
        $photo_path = null;

        if($request->hasFile('photo')){
            $photo_path = $request->file('photo')->store('product_photo', 'public');
        }
       //dapetin data dari request user 
       $detailProduct = [
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'photo' => $photo_path,
        'price' => $request->price,
        'about' => $request->about
       ];

       DB::beginTransaction();

       try {
        //code...
        $newProduct = $this->productRepositoryInterface->storeProduct($detailProduct);
        DB::commit();

        return ApiResponseClass::sendResponse(new ProductResource($newProduct), 'Product created successfully!', 201);
       } catch (\Exception $ex) {
        return ApiResponseClass::rollback($ex);
       }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepositoryInterface->getProductById($id);

        return ApiResponseClass::sendResponse(new ProductResource($product), '', 200);
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
    public function update(UpdateProductRequest $request,$id)
    {
        $photo_path = null;

        if($request->hasFile('photo')) {
            $photo_path = $request->file('photo')->store('product_photo', 'public');
        }
        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'photo' => $photo_path,
            'price' => $request->price,
            'about' => $request->about,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
