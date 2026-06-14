@extends('layouts.modern')

@section('title', '搜索商品 · Monday Shop')

@section('main')
<section class="shop-container py-14">
    <div class="rounded-[2rem] bg-slate-950 px-6 py-12 text-white sm:px-10">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-500">Search</p>
        <h1 class="mt-3 text-4xl font-black">寻找你的下一件好物</h1>
        <form action="{{ url('/products/search') }}" method="get" class="mt-7 flex max-w-2xl gap-3">
            <input name="keyword" value="{{ request('keyword') }}" placeholder="输入商品名称" class="min-w-0 flex-1 rounded-full border-0 bg-white px-5 py-3 text-sm text-slate-900 outline-none">
            <button class="rounded-full bg-brand-500 px-6 py-3 text-sm font-bold text-white">搜索</button>
        </form>
    </div>

    <div class="mt-12 flex items-end justify-between"><div><p class="text-sm text-slate-500">关键词：{{ request('keyword', '全部') }}</p><h2 class="mt-2 text-2xl font-black">找到 {{ $products->total() }} 件商品</h2></div><a href="{{ url('/categories') }}" class="text-sm font-bold text-brand-700">浏览分类 →</a></div>

    @if($products->isEmpty())
        <div class="mt-8 rounded-3xl border border-dashed border-slate-300 bg-white py-20 text-center"><div class="text-4xl">⌕</div><h2 class="mt-4 text-xl font-black">没有找到匹配商品</h2><p class="mt-2 text-sm text-slate-500">换一个更简短的关键词试试。</p></div>
    @else
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@foreach($products as $product)<x-product-card :product="$product" />@endforeach</div>
        <div class="mt-10">{{ $products->appends(request()->only('keyword'))->links() }}</div>
    @endif
</section>
@endsection
