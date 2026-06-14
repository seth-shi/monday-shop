@extends('layouts.account')

@section('title', $notification->title.' - Monday Shop')

@section('account')
<nav class="flex items-center justify-between gap-3 text-sm font-bold"><a class="{{ $last ? 'text-brand-600' : 'pointer-events-none text-slate-300' }}" href="{{ $last ? url('/user/notifications/'.$last->id) : '#' }}">← 上一条</a><a href="{{ url('/user/notifications') }}" class="text-slate-500">返回列表</a><a class="{{ $next ? 'text-brand-600' : 'pointer-events-none text-slate-300' }}" href="{{ $next ? url('/user/notifications/'.$next->id) : '#' }}">下一条 →</a></nav>
<article class="shop-card mt-6 p-6 lg:p-10"><p class="text-xs text-slate-400">{{ $notification->created_at }}</p><h1 class="mt-3 text-3xl font-black">{{ $notification->title }}</h1><div class="prose prose-slate mt-8 max-w-none">@include($view)</div></article>
@endsection
