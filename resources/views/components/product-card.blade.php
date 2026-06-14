@props(['product'])

<article class="shop-card overflow-hidden">
    <a href="{{ url('/products/'.$product->uuid) }}" class="group relative block aspect-[4/3] overflow-hidden bg-slate-100">
        <img src="{{ $product->thumb }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @if($product->original_price > $product->price)
            <span class="absolute left-4 top-4 rounded-full bg-slate-950 px-3 py-1 text-xs font-bold text-white">省 {{ intval((1 - $product->price / $product->original_price) * 100) }}%</span>
        @endif
    </a>
    <div class="p-5">
        <div class="flex items-center justify-between text-xs text-slate-400"><span>{{ $product->users_count ?? 0 }} 人收藏</span><span>已售 {{ $product->sale_count ?? 0 }}</span></div>
        <h2 class="mt-3 line-clamp-1 text-lg font-black"><a href="{{ url('/products/'.$product->uuid) }}">{{ $product->name }}</a></h2>
        <p class="mt-2 line-clamp-2 min-h-10 text-sm leading-5 text-slate-500">{{ strip_tags($product->title) }}</p>
        <div class="mt-5 flex items-end justify-between gap-4">
            <div><strong class="text-2xl">¥{{ number_format($product->price, 2) }}</strong>@if($product->original_price > $product->price)<del class="ml-2 text-xs text-slate-400">¥{{ number_format($product->original_price, 2) }}</del>@endif</div>
            <span class="grid size-9 place-items-center rounded-full bg-slate-950 text-white">→</span>
        </div>
    </div>
</article>
