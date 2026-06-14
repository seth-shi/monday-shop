@extends('layouts.modern')
@section('title', '500 - 服务异常')
@section('main')<section class="shop-container grid min-h-[60vh] place-items-center py-16 text-center"><div><p class="text-8xl font-black text-rose-600">500</p><h1 class="mt-5 text-3xl font-black">服务暂时不可用</h1><p class="mt-3 text-slate-500">我们已经记录这个问题，请稍后再试。</p><div class="mt-7 flex justify-center gap-3"><button onclick="location.reload()" class="shop-button-secondary">重新加载</button><a href="{{ url('/') }}" class="shop-button-primary">回到首页</a></div></div></section>@endsection
