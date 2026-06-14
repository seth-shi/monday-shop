@extends('layouts.modern')

@section('title', '全部商品 · Monday Shop')

@section('main')
<section class="shop-container py-14">
    <div class="max-w-2xl"><p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-600">Product directory</p><h1 class="mt-3 text-4xl font-black">全部商品</h1><p class="mt-4 leading-7 text-slate-500">按商品名称首字母快速浏览。</p></div>
    <div class="mt-8 flex flex-wrap gap-2" id="pinyin-filter">
        @foreach($pinyins as $char)<button type="button" data-pinyin="{{ $char }}" class="rounded-full border border-slate-300 bg-white px-4 py-2 text-sm font-bold uppercase transition hover:border-brand-500 hover:text-brand-700">{{ $char }}</button>@endforeach
    </div>
    <div class="mt-8 rounded-[2rem] border border-slate-200 bg-white p-6 sm:p-8"><div class="flex items-center justify-between"><h2 id="directory-title" class="text-xl font-black">随机推荐</h2><span id="directory-status" class="text-xs text-slate-400"></span></div><div id="directory-products" class="mt-6 grid gap-x-10 gap-y-3 sm:grid-cols-2 lg:grid-cols-3">@foreach($products->flatten() as $product)<a class="rounded-xl px-3 py-3 text-sm font-semibold transition hover:bg-brand-50 hover:text-brand-700" href="{{ url('/products/'.$product->uuid) }}">{{ $product->name }} <span class="float-right">→</span></a>@endforeach</div></div>
</section>
@endsection

@push('scripts')
<script>
document.querySelector('#pinyin-filter')?.addEventListener('click', async (event) => {
    const button = event.target.closest('[data-pinyin]');
    if (!button) return;
    const status = document.querySelector('#directory-status');
    status.textContent = '加载中…';
    try {
        const { data } = await window.axios.get(`/products/pinyin/${button.dataset.pinyin}`);
        const products = data.flat();
        document.querySelector('#directory-title').textContent = `${button.dataset.pinyin.toUpperCase()} 开头的商品`;
        document.querySelector('#directory-products').innerHTML = products.length
            ? products.map(product => `<a class="rounded-xl px-3 py-3 text-sm font-semibold transition hover:bg-brand-50 hover:text-brand-700" href="/products/${product.uuid}">${product.name}<span class="float-right">→</span></a>`).join('')
            : '<p class="text-sm text-slate-500">暂无商品</p>';
    } finally { status.textContent = ''; }
});
</script>
@endpush
