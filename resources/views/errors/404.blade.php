@extends('layouts.modern')
@section('title', '404 - 页面不存在')
@section('main')<section class="shop-container grid min-h-[60vh] place-items-center py-16 text-center"><div><p class="text-8xl font-black text-brand-600">404</p><h1 class="mt-5 text-3xl font-black">页面走丢了</h1><p class="mt-3 text-slate-500">你访问的地址不存在，或内容已经被移动。</p><a href="{{ url('/') }}" class="shop-button-primary mt-7">回到首页</a></div></section>@endsection
