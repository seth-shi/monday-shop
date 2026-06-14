@extends('layouts.account')

@section('title', '收货地址 - Monday Shop')

@section('account')
<div><span class="shop-kicker">Delivery</span><h1 class="mt-2 text-3xl font-black">收货地址</h1></div>
@include('hint.status') @include('hint.validate_errors')
<div id="address-message" class="mt-6 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>
<div class="mt-7 grid gap-5 md:grid-cols-2">
    @forelse($addresses as $address)
        <article class="shop-card p-6" data-address-card="{{ $address->id }}">
            <div class="flex items-start justify-between gap-4"><div><h2 class="font-black">{{ $address->name }}</h2><p class="mt-1 text-sm text-slate-500">{{ $address->phone }}</p></div><button type="button" data-default-address="{{ $address->id }}" class="rounded-full px-3 py-1 text-xs font-bold {{ $address->is_default ? 'bg-brand-50 text-brand-700' : 'bg-slate-100 text-slate-500' }}">{{ $address->is_default ? '默认地址' : '设为默认' }}</button></div>
            <p class="mt-5 text-sm leading-6 text-slate-600">{{ $address->format() }}</p>
            <div class="mt-5 flex gap-4 text-sm font-bold"><a href="{{ url('/user/addresses/'.$address->id.'/edit') }}" class="text-brand-600">编辑</a><button type="button" data-delete-address="{{ $address->id }}" class="text-rose-600">删除</button></div>
        </article>
    @empty
        <div class="shop-card col-span-full p-10 text-center text-slate-500">还没有保存收货地址。</div>
    @endforelse
</div>

<section class="shop-card mt-7 p-6 lg:p-8"><h2 class="text-xl font-black">新增地址</h2><form action="{{ url('/user/addresses') }}" method="post" class="mt-6 grid gap-5 md:grid-cols-2">@csrf
    <label class="grid gap-2 text-sm font-bold">收货人<input class="shop-input" name="name" value="{{ old('name') }}" required></label>
    <label class="grid gap-2 text-sm font-bold">手机号码<input class="shop-input" name="phone" value="{{ old('phone') }}" maxlength="11" required></label>
    <label class="grid gap-2 text-sm font-bold">省份<select class="shop-input" name="province_id" data-province required>@foreach($provinces as $province)<option value="{{ $province->id }}" @selected(old('province_id') == $province->id)>{{ $province->name }}</option>@endforeach</select></label>
    <label class="grid gap-2 text-sm font-bold">城市<select class="shop-input" name="city_id" data-city required>@foreach($cities as $city)<option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>@endforeach</select></label>
    <label class="grid gap-2 text-sm font-bold md:col-span-2">详细地址<textarea class="shop-input min-h-28" name="detail_address" required>{{ old('detail_address') }}</textarea></label>
    <div class="md:col-span-2"><button class="shop-button-primary">保存地址</button></div>
</form></section>
@endsection

@push('scripts')
<script>
const addressMessage = document.querySelector('#address-message');
const showAddressMessage = (text, ok = true) => { addressMessage.textContent = text; addressMessage.className = `mt-6 rounded-2xl px-4 py-3 text-sm font-semibold ${ok ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'}`; };
document.querySelector('[data-province]')?.addEventListener('change', async (event) => { const { data } = await axios.get('/user/addresses/cities', { params: { province_id: event.target.value } }); document.querySelector('[data-city]').innerHTML = data.map((city) => `<option value="${city.id}">${city.name}</option>`).join(''); });
document.querySelectorAll('[data-default-address]').forEach((button) => button.addEventListener('click', async () => { try { const { data } = await axios.post(`/user/addresses/default/${button.dataset.defaultAddress}`); if (Number(data.code) !== 200) throw new Error(data.msg); document.querySelectorAll('[data-default-address]').forEach((item) => { item.textContent = '设为默认'; item.className = 'rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500'; }); button.textContent = '默认地址'; button.className = 'rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700'; showAddressMessage(data.msg || '设置成功'); } catch (error) { showAddressMessage(error.response?.data?.msg || error.message, false); } }));
document.querySelectorAll('[data-delete-address]').forEach((button) => button.addEventListener('click', async () => { if (!confirm('确认删除这个地址？')) return; try { const { data } = await axios.delete(`/user/addresses/${button.dataset.deleteAddress}`); if (Number(data.code) !== 200) throw new Error(data.msg); document.querySelector(`[data-address-card="${button.dataset.deleteAddress}"]`)?.remove(); showAddressMessage(data.msg || '删除成功'); } catch (error) { showAddressMessage(error.response?.data?.msg || error.message, false); } }));
</script>
@endpush
