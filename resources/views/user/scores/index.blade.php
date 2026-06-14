@extends('layouts.account')

@section('title', '我的积分 - Monday Shop')

@section('account')
<div><span class="shop-kicker">Points</span><h1 class="mt-2 text-3xl font-black">我的积分</h1></div>
<div class="mt-7 grid gap-4 sm:grid-cols-2"><div class="rounded-[2rem] bg-slate-950 p-7 text-white"><p class="text-sm text-slate-400">累计积分</p><p class="mt-2 text-4xl font-black">{{ number_format($user->score_all) }}</p></div><div class="rounded-[2rem] bg-brand-600 p-7 text-white"><p class="text-sm text-brand-100">可用积分</p><p class="mt-2 text-4xl font-black">{{ number_format($user->score_now) }}</p></div></div>
<section class="shop-card mt-6 p-6"><h2 class="text-lg font-black">积分任务</h2><div class="mt-5 grid gap-5">@foreach($rules as $rule)<div><div class="flex justify-between gap-4 text-sm"><span class="font-semibold">{{ $rule->description }} <b class="text-emerald-600">+{{ $rule->score }}</b></span><span class="text-slate-400">{{ $rule->completed_times }}/{{ $rule->times }}</span></div><div class="mt-2 h-2 overflow-hidden rounded-full bg-slate-100"><div class="h-full rounded-full bg-brand-500" style="width: {{ min(100, $rule->plan) }}%"></div></div></div>@endforeach</div></section>
<section class="shop-card mt-6 overflow-hidden"><div class="border-b border-slate-100 p-6"><h2 class="text-lg font-black">积分明细</h2></div><div class="divide-y divide-slate-100">@forelse($logs as $log)<div class="flex items-center justify-between gap-4 p-5"><div><p class="font-semibold">{{ $log->description }}</p><p class="mt-1 text-xs text-slate-400">{{ $log->created_at }}</p></div><strong class="{{ $log->score > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $log->score > 0 ? '+' : '' }}{{ $log->score }}</strong></div>@empty<div class="p-10 text-center text-slate-500">暂无积分记录。</div>@endforelse</div></section>
<div class="mt-8">{{ $logs->links() }}</div>
@endsection
