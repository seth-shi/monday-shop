@extends('layouts.admin')
@section('title', '编辑商品') 
@section('heading', '编辑商品')
@section('content')
<section class="overflow-hidden rounded-3xl bg-white shadow-sm">
    <form action="{{ route('admin.products.update', $product->id) }}" method="post" class="p-6 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">商品名称</label>
                <input type="text" name="name" value="{{ $product->name }}" class="shop-input w-full" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">商品分类</label>
                <select name="category_id" class="shop-input w-full" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">商品简介</label>
            <input type="text" name="title" value="{{ $product->title }}" class="shop-input w-full">
        </div>

        <div class="grid grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">售价 (元)</label>
                <input type="number" name="price" value="{{ $product->price }}" step="0.01" min="0" class="shop-input w-full" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">原价 (元)</label>
                <input type="number" name="original_price" value="{{ $product->original_price }}" step="0.01" min="0" class="shop-input w-full">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">库存</label>
                <input type="number" name="count" value="{{ $product->count }}" min="0" class="shop-input w-full" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">缩略图 URL</label>
            <input type="text" name="thumb" value="{{ $product->getRawOriginal('thumb') }}" class="shop-input w-full">
            @if($product->thumb)
            <img src="{{ $product->thumb }}" class="mt-2 h-20 rounded object-cover">
            @endif
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="shop-button-primary">保存</button>
            <a href="{{ route('admin.products.index') }}" class="shop-button">返回列表</a>
        </div>
    </form>
</section>
@endsection