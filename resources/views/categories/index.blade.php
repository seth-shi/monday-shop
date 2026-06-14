@extends('layouts.modern')

@section('title', '商品分类 · Monday Shop')

@section('main')
<section class="shop-container py-14">
    <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Categories</p><h1 class="mt-3 text-4xl font-black tracking-tight">从兴趣开始探索</h1><p class="mt-4 leading-7 text-slate-500">按场景与品类浏览，快速找到真正需要的商品。</p></div>
    <div class="mt-10 grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">
        @foreach($categories as $category)
            <a href="{{ url('/categories/'.$category->id) }}" class="shop-card group overflow-hidden">
                <div class="aspect-square overflow-hidden bg-slate-100"><img src="{{ $category->thumb }}" alt="{{ $category->title }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105"></div>
                <div class="p-4"><h2 class="font-black">{{ $category->title }}</h2><p class="mt-1 line-clamp-2 text-xs leading-5 text-slate-500">{{ $category->description ?: '浏览该分类下的精选商品' }}</p></div>
            </a>
        @endforeach
    </div>
    <div class="mt-10">{{ $categories->links() }}</div>
</section>
@endsection
