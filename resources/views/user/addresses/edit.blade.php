@extends('layouts.account')

@section('title', '编辑收货地址 - Monday Shop')

@section('account')
<div><a href="{{ url('/user/addresses') }}" class="text-sm font-bold text-brand-600">← 返回地址列表</a><h1 class="mt-3 text-3xl font-black">编辑收货地址</h1></div>
@include('hint.status') @include('hint.validate_errors')
<section class="shop-card mt-7 p-6 lg:p-8"><form action="{{ url('/user/addresses/'.$address->id) }}" method="post" class="grid gap-5 md:grid-cols-2">@csrf @method('PUT')
    <label class="grid gap-2 text-sm font-bold">收货人<input class="shop-input" name="name" value="{{ old('name', $address->name) }}" required></label>
    <label class="grid gap-2 text-sm font-bold">手机号码<input class="shop-input" name="phone" value="{{ old('phone', $address->phone) }}" maxlength="11" required></label>
    <label class="grid gap-2 text-sm font-bold">省份<select class="shop-input" name="province_id" data-province required>@foreach($provinces as $province)<option value="{{ $province->id }}" @selected(old('province_id', $address->province_id) == $province->id)>{{ $province->name }}</option>@endforeach</select></label>
    <label class="grid gap-2 text-sm font-bold">城市<select class="shop-input" name="city_id" data-city required>@foreach($cities as $city)<option value="{{ $city->id }}" @selected(old('city_id', $address->city_id) == $city->id)>{{ $city->name }}</option>@endforeach</select></label>
    <label class="grid gap-2 text-sm font-bold md:col-span-2">详细地址<textarea class="shop-input min-h-28" name="detail_address" required>{{ old('detail_address', $address->detail_address) }}</textarea></label>
    <div class="md:col-span-2"><button class="shop-button-primary">保存修改</button></div>
</form></section>
@endsection

@push('scripts')
<script>document.querySelector('[data-province]')?.addEventListener('change', async (event) => { const { data } = await axios.get('/user/addresses/cities', { params: { province_id: event.target.value } }); document.querySelector('[data-city]').innerHTML = data.map((city) => `<option value="${city.id}">${city.name}</option>`).join(''); });</script>
@endpush
