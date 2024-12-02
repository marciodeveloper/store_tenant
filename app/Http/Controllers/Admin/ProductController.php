<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class ProductController extends Controller
{
    public function __construct(private Product $product)
    {

    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->product->paginate(10);
        
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $categories = $category->all('id', 'name');
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Store $store)
    {
        $data = $request->all();

        $product = $store->first()->products()->create($data);
        
        $product->categories()->sync($request->categories);
        
        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao cadastrar produto']);
        
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Category $category)
    {
        $categories = $category->all('id', 'name');

        $product = $this->product->findOrFail($id);
        
        return view('admin.products.create', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = $this->product->findOrFail($id);
        $product->update($request->all());

        $product->categories()->sync($request->categories);

        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao atualizar produto']);

        return redirect()->route('admin.products.edit', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = $this->product->findOrFail($id);

        $product->delete();

        session()->flash('message', ['type' => 'success', 'body' => 'Sucesso ao remover produto']);

        return redirect()->route('admin.products.index');
    }
}
