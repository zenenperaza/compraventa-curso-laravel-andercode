<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        // 🔹 Solo el ADMINISTRADOR y MANTENEDOR pueden acceder a este controlador
        // $this->middleware(['auth', 'role:Administrador,Mantenedor']);
    }

    public function index()
    {
        $products = Product::with('category', 'user')->get(); // Incluye las relaciones
        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,sold,archived',
            'fechvencimiento' => 'nullable|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'price', 'quantity', 'category_id', 'status', 'fechvencimiento']);
        $data['user_id'] = auth()->id(); // Agrega el ID del usuario autenticado

        $product = Product::create($data);

        // 1. Generar código de barras (usando el ID del producto)
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeData = $barcodeGenerator->getBarcode($product->id, BarcodeGeneratorPNG::TYPE_CODE_128);
        $barcodePath = "barcodes/{$product->id}.png";
        Storage::disk('public')->put($barcodePath, $barcodeData);
        $product->barcode = $barcodePath;

        // 2. Generar código QR en formato SVG para evitar problemas con Imagick
        $qrCodeData = "Producto: {$product->name}\nPrecio: {$product->price}\nCantidad: {$product->quantity}\nEstado: {$product->status}";
        $qrCodeSvg = QrCode::format('svg')->size(200)->generate($qrCodeData);
        $qrCodePath = "qrcodes/{$product->id}.svg";
        Storage::disk('public')->put($qrCodePath, $qrCodeSvg);
        $product->qrcode = $qrCodePath;

        // Guardar los datos actualizados en la base de datos
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }


    public function show(string $id)
    {

    }

    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }


    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,sold,archived',
            'fechvencimiento' => 'nullable|date',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->only(['name', 'description', 'price', 'quantity', 'category_id', 'status', 'fechvencimiento']));

        // 1. Generar código de barras (usando el ID del producto)
        $barcodeGenerator = new BarcodeGeneratorPNG();
        $barcodeData = $barcodeGenerator->getBarcode($product->id, BarcodeGeneratorPNG::TYPE_CODE_128);
        $barcodePath = "barcodes/{$product->id}.png";
        Storage::disk('public')->put($barcodePath, $barcodeData);
        $product->barcode = $barcodePath;

        // 2. Generar código QR en formato SVG para evitar problemas con Imagick
        $qrCodeData = "Producto: {$product->name}\nPrecio: {$product->price}\nCantidad: {$product->quantity}\nEstado: {$product->status}";
        $qrCodeSvg = QrCode::format('svg')->size(200)->generate($qrCodeData);
        $qrCodePath = "qrcodes/{$product->id}.svg";
        Storage::disk('public')->put($qrCodePath, $qrCodeSvg);
        $product->qrcode = $qrCodePath;

        // Guardar los datos actualizados en la base de datos
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Eliminar imágenes relacionadas
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // Eliminar imagen del almacenamiento
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Imagen eliminada correctamente.']);
    }
}
