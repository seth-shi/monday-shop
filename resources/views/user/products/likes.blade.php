@extends('layouts.account')

@section('title', '我的收藏 - Monday Shop')

@section('account')
<div><span class="shop-kicker">Wishlist</span><h1 class="mt-2 text-3xl font-black">我的收藏</h1></div>
<div id="like-message" class="mt-6 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>
<div class="mt-7 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
    @forelse($likesProducts as $product)
        <div class="relative" data-like-card="{{ $product->uuid }}">
            <x-product-card :product="$product" />
            <button type="button" data-unlike="{{ $product->uuid }}" class="absolute right-3 top-3 grid size-10 place-items-center rounded-full bg-white/95 text-lg text-slate-500 shadow hover:text-rose-600" aria-label="取消收藏">×</button>
        </div>
    @empty
        <div class="shop-card col-span-full p-12 text-center"><p class="text-slate-500">收藏夹还是空的。</p><a href="{{ url('/products') }}" class="shop-button-primary mt-5">去逛逛</a></div>
    @endforelse
</div>
<div class="mt-8">{{ $likesProducts->links() }}</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-unlike]').forEach((button) => button.addEventListener('click', async () => {
    const message = document.querySelector('#like-message');
    try {
        const { data } = await axios.delete(`/user/likes/${button.dataset.unlike}`);
        if (![0, 200].includes(Number(data.code))) throw new Error(data.msg || '操作失败');
        document.querySelector(`[data-like-card="${button.dataset.unlike}"]`)?.remove();
        message.textContent = data.msg || '已取消收藏';
        message.className = 'mt-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700';
    } catch (error) {
        message.textContent = error.response?.data?.msg || error.message || '操作失败';
        message.className = 'mt-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700';
    }
}));
</script>
@endpush
