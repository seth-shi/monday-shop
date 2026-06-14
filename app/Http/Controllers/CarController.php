<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('user.auth')->only('store', 'destroy');
    }

    public function index()
    {
        $cars = auth()->user()
            ? auth()->user()->cars()->with('product')->get()
            : collect();

        return view('cars.index', compact('cars'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'string'],
            'number' => ['required', 'integer', 'min:1', 'max:999'],
            'action' => ['nullable', 'in:sync'],
        ]);

        $product = Product::query()->where('uuid', $validated['product_id'])->firstOrFail();
        $car = $request->user()->cars()->firstOrNew([
            'user_id' => $request->user()->getKey(),
            'product_id' => $product->getKey(),
        ]);

        $currentNumber = (int) ($car->number ?? 0);
        $number = $validated['number'];
        $isSync = ($validated['action'] ?? null) === 'sync';
        $newNumber = $isSync ? $number : $currentNumber + $number;

        if ($newNumber > $product->count) {
            return responseJson(403, '库存不足');
        }

        $car->number = $newNumber;
        $car->save();

        return responseJson(200, '购物车已更新', [
            'change' => $newNumber - $currentNumber,
            'number' => $newNumber,
        ]);
    }

    public function destroy(Request $request, int $id)
    {
        $car = $request->user()->cars()->whereKey($id)->firstOrFail();
        $car->delete();

        return responseJson(200, '删除成功');
    }
}
