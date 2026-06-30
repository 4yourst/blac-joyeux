<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Liste des produits du catalogue (doc §10.5).
     */
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('admin.products.create', [
            'product' => new Product(['is_available' => true]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->resolveSlug($data['name'], $data['slug'] ?? null);
        $data['image'] = $this->storeImage($request) ?? null;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('status', 'Le produit « '.$data['name'].' » a été créé.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateData($request, $product);
        $data['slug'] = $this->resolveSlug($data['name'], $data['slug'] ?? null, $product);

        if ($image = $this->storeImage($request)) {
            $data['image'] = $image;
        } else {
            unset($data['image']); // On conserve le visuel existant si aucun nouveau fichier.
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('status', 'Le produit « '.$product->name.' » a été mis à jour.');
    }

    public function destroy(Product $product)
    {
        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('status', 'Le produit « '.$name.' » a été supprimé.');
    }

    /**
     * Règles de validation communes à la création et à la modification.
     *
     * @return array<string, mixed>
     */
    private function validateData(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'nullable', 'string', 'max:140', 'alpha_dash',
                Rule::unique('products', 'slug')->ignore($product),
            ],
            'price' => ['required', 'integer', 'min:0', 'max:100000000'],
            'description' => ['required', 'string'],
            'story' => ['nullable', 'string'],
            'dimensions' => ['nullable', 'string', 'max:120'],
            'material' => ['nullable', 'string', 'max:120'],
            'care' => ['nullable', 'string', 'max:255'],
            'is_available' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    /**
     * Génère un slug unique à partir du nom (ou du slug fourni).
     */
    private function resolveSlug(string $name, ?string $provided, ?Product $product = null): string
    {
        $base = Str::slug($provided ?: $name);
        $slug = $base;
        $i = 2;

        while (Product::where('slug', $slug)->when($product, fn ($q) => $q->whereKeyNot($product->getKey()))->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * Déplace le visuel téléversé vers public/images/products et renvoie son chemin relatif.
     */
    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');
        $directory = public_path('images/products');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = Str::slug($request->input('name')).'-'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'products/'.$filename;
    }
}
