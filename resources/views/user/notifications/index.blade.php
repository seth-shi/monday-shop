@extends('layouts.account')

@section('title', '消息通知 - Monday Shop')

@section('account')
<div class="flex flex-wrap items-end justify-between gap-4"><div><span class="shop-kicker">Inbox</span><h1 class="mt-2 text-3xl font-black">消息通知</h1></div><button id="read-all" class="shop-button-secondary">全部标为已读</button></div>
<nav class="mt-7 flex gap-2">@foreach([1 => '未读 ('.$unreadCount.')', 2 => '全部 ('.($unreadCount + $readCount).')', 3 => '已读 ('.$readCount.')'] as $tab => $label)<a href="?tab={{ $tab }}" class="rounded-full px-4 py-2 text-sm font-bold {{ (int) request('tab', 1) === $tab ? 'bg-slate-950 text-white' : 'bg-white text-slate-500' }}">{{ $label }}</a>@endforeach</nav>
<div id="notification-message" class="mt-5 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>
<div class="shop-card mt-6 divide-y divide-slate-100 overflow-hidden">@forelse($notifications as $notification)<article class="p-5" data-notification="{{ $notification->id }}"><div class="flex items-start justify-between gap-4"><div><a href="{{ url('/user/notifications/'.$notification->id) }}" class="font-black {{ $notification->read_at ? 'text-slate-400' : 'text-slate-950' }}" data-notification-title>{{ $notification->title }}</a><p class="mt-2 text-xs text-slate-400">{{ $notification->created_at }}</p></div>@unless($notification->read_at)<button data-read-notification="{{ $notification->id }}" class="whitespace-nowrap text-xs font-black text-brand-600">标为已读</button>@endunless</div></article>@empty<div class="p-12 text-center text-slate-500">这里暂时没有消息。</div>@endforelse</div>
<div class="mt-8">{{ $notifications->appends(request()->all())->links() }}</div>
@endsection

@push('scripts')
<script>
const notificationMessage = document.querySelector('#notification-message'); const showNotificationMessage = (text, ok = true) => { notificationMessage.textContent = text; notificationMessage.className = `mt-5 rounded-2xl px-4 py-3 text-sm font-semibold ${ok ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'}`; };
document.querySelectorAll('[data-read-notification]').forEach((button) => button.addEventListener('click', async () => { try { const { data } = await axios.get(`/user/notifications/${button.dataset.readNotification}/read`); if (Number(data.code) !== 200) throw new Error(data.msg); document.querySelector(`[data-notification="${button.dataset.readNotification}"] [data-notification-title]`)?.classList.add('text-slate-400'); button.remove(); } catch (error) { showNotificationMessage(error.response?.data?.msg || error.message, false); } }));
document.querySelector('#read-all')?.addEventListener('click', async () => { try { const { data } = await axios.get('/user/notifications/read_all'); if (Number(data.code) !== 200) throw new Error(data.msg); showNotificationMessage(data.msg); document.querySelectorAll('[data-read-notification]').forEach((button) => button.remove()); document.querySelectorAll('[data-notification-title]').forEach((title) => title.classList.add('text-slate-400')); } catch (error) { showNotificationMessage(error.response?.data?.msg || error.message, false); } });
</script>
@endpush
