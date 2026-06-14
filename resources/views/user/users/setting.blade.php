@extends('layouts.account')

@section('title', '账户设置 - Monday Shop')

@section('account')
<div><span class="shop-kicker">Profile</span><h1 class="mt-2 text-3xl font-black">账户设置</h1></div>
@include('hint.status') @include('hint.validate_errors')
<div id="profile-message" class="mt-6 hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

<section class="shop-card mt-7 p-6 lg:p-8">
    <form method="post" action="{{ url('/user/update') }}" class="grid gap-7">@csrf @method('PUT')
        <div class="flex flex-wrap items-center gap-5"><img id="avatar-preview" src="{{ $user->avatar }}" alt="{{ $user->name }}" class="size-24 rounded-[2rem] object-cover ring-4 ring-slate-100"><div><label class="shop-button-secondary cursor-pointer">上传新头像<input id="avatar-file" type="file" accept="image/jpeg,image/png,image/gif,image/bmp" class="hidden"></label><p class="mt-2 text-xs text-slate-400">JPG、PNG、GIF 或 BMP，最大 5MB</p></div></div>
        <input id="avatar-value" type="hidden" name="avatar" value="{{ $user->avatar }}">
        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 text-sm font-bold">用户名<input class="shop-input disabled:bg-slate-50 disabled:text-slate-400" name="name" value="{{ $user->name }}" @disabled(!$user->is_init_name)></label>
            <label class="grid gap-2 text-sm font-bold">电子邮箱<input class="shop-input disabled:bg-slate-50 disabled:text-slate-400" type="email" name="email" value="{{ $user->email }}" @disabled(!$user->is_init_email)></label>
        </div>
        <fieldset><legend class="text-sm font-bold">性别</legend><div class="mt-3 flex gap-5 text-sm"><label class="flex items-center gap-2"><input type="radio" name="sex" value="1" @checked((int) $user->sex === 1)> 男</label><label class="flex items-center gap-2"><input type="radio" name="sex" value="0" @checked((int) $user->sex === 0)> 女</label></div></fieldset>
        <div><button class="shop-button-primary">保存资料</button></div>
    </form>
</section>

<section class="shop-card mt-6 p-6 lg:p-8"><h2 class="text-xl font-black">第三方账户</h2><div class="mt-5 grid gap-3">
    @foreach([['github', $user->github_id, $user->github_name, 'GitHub'], ['qq', $user->qq_id, $user->qq_name, 'QQ'], ['weibo', $user->weibo_id, $user->weibo_name, '微博']] as [$provider, $id, $name, $label])
        <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 p-4"><div><p class="font-bold">{{ $label }}</p><p class="mt-1 text-xs text-slate-400">{{ $id ? '已绑定 '.$name : '尚未绑定' }}</p></div><a href="{{ $id ? url('/auth/oauth/unbind/'.$provider) : url('/auth/oauth/'.$provider) }}" class="text-sm font-black {{ $id ? 'text-rose-600' : 'text-brand-600' }}">{{ $id ? '解除绑定' : '立即绑定' }}</a></div>
    @endforeach
</div></section>
@endsection

@push('scripts')
<script>
document.querySelector('#avatar-file')?.addEventListener('change', async (event) => {
    const file = event.target.files[0];
    if (!file) return;
    const message = document.querySelector('#profile-message');
    const form = new FormData(); form.append('file', file);
    try {
        const { data } = await axios.post('/user/upload/avatar', form, { headers: { 'Content-Type': 'multipart/form-data' } });
        if (Number(data.code) !== 0) throw new Error(data.msg || '上传失败');
        document.querySelector('#avatar-value').value = data.data.src;
        document.querySelector('#avatar-preview').src = data.data.link;
        message.textContent = data.msg || '头像上传成功';
        message.className = 'mt-6 rounded-2xl bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700';
    } catch (error) {
        message.textContent = error.response?.data?.msg || error.message || '上传失败';
        message.className = 'mt-6 rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700';
    }
});
</script>
@endpush
