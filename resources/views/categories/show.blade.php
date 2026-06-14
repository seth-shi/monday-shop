@extends('layouts.modern')

@section('title', $category->title.' · Monday Shop')

@section('main')
<section class="shop-container py-14">
    <div class="grid overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-slate-200 lg:grid-cols-[320px_1fr]">
        <div class="aspect-[4/3] bg-slate-100 lg:aspect-auto"><img src="{{ $category->thumb }}" alt="{{ $category->title }}" class="h-full w-full object-cover"></div>
        <div class="flex flex-col justify-center p-8 sm:p-12"><a href="{{ url('/categories') }}" class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">← 所有分类</a><h1 class="mt-4 text-4xl font-black">{{ $category->title }}</h1><p class="mt-4 max-w-2xl leading-7 text-slate-500">{{ $category->description ?: '这个分类收录了我们精心挑选的商品。' }}</p><p class="mt-6 text-sm font-bold">共 {{ $categoryProducts->total() }} 件商品</p></div>
    </div>

    <div class="mt-10 flex flex-wrap items-center justify-between gap-4"><h2 class="text-2xl font-black">分类商品</h2><form method="get"><select name="orderBy" onchange="this.form.submit()" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-semibold outline-none focus:border-brand-500"><option value="created_at" @selected(request('orderBy') === 'created_at')>最新上架</option><option value="sale_count" @selected(request('orderBy') === 'sale_count')>销量优先</option><option value="price" @selected(request('orderBy') === 'price')>价格排序</option></select></form></div>
    <div class="mt-7 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@forelse($categoryProducts as $product)<x-product-card :product="$product" />@empty<div class="col-span-full rounded-3xl border border-dashed border-slate-300 bg-white py-16 text-center text-slate-500">该分类暂时没有商品</div>@endforelse</div>
    <div class="mt-10">{{ $categoryProducts->appends(request()->only('orderBy'))->links() }}</div>
</section>
@endsection
