<?php

namespace App\Http\Controllers\User;

use App\Enums\ScoreRuleIndexEnum;
use App\Exceptions\UploadException;
use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Product;
use App\Models\ScoreRule;
use App\Models\Subscribe;
use App\Models\User;
use App\Services\ScoreLogServe;
use App\Services\UploadServe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        /**
         * @var $user User
         */
        $user = $this->user();

        // 获取优惠券数量
        $today = Carbon::today()->toDateString();
        $user->coupons_count = $user->coupons()->where('end_date', '>=', $today)->whereNull('used_at')->count();
        $user->cars_count = $user->cars()->sum('number');
        $user->orders_count = $user->orders()->count();
        $user->likeProducts = $user->products()->latest()->take(9)->get();
        $user->notifications_count = $user->unreadNotifications()->count();
        $user->addresses_count = $user->addresses()->count();
        $user->like_products_count = $user->products()->count();

        // 查出用户的等级
        $level = Level::query()
                      ->where('min_score', '<=', $user->score_all)
                      ->orderBy('min_score', 'desc')
                      ->first();

        // 获取所有积分记录
        $scoreLogs = $user->scoreLogs()->latest()->limit(5)->get();

        return view('user.homes.index', compact('user', 'level', 'scoreLogs'));
    }


    public function indexScores()
    {
        /**
         * @var $user User
         */
        $user = $this->user();

        /**
         * 显示所有可能的任务
         *
         * @var $rules Collection
         */
        $rules = Cache::rememberForever(ScoreRule::CACHE_KEY, function () {

            return ScoreRule::query()
                            ->whereIn('index_code', ScoreRule::OPEN_RULES)
                            ->orderBy('index_code')
                            ->orderBy('score')
                            ->get();
        });

        // 连续登录, 浏览商品特殊处理
        $loginDays = $user->login_days;
        // 浏览的数量
        $visitedNumber = (new ScoreLogServe)->getUserVisitedNumber(Carbon::today()->toDateString(), $user->id);

        // 如果 completed_times === times 那么代表这个任务完成了
        $rules->transform(function (ScoreRule $rule) use ($loginDays, $visitedNumber) {

                  if ($rule->index_code == ScoreRuleIndexEnum::CONTINUE_LOGIN) {

                      $rule->completed_times = $loginDays > $rule->times ? $rule->times : $loginDays;

                  } elseif ($rule->index_code == ScoreRuleIndexEnum::VISITED_PRODUCT) {

                      $rule->completed_times = $visitedNumber > $rule->times ? $rule->times : $visitedNumber;
                  }

                  $rule->plan = ($rule->completed_times / $rule->times) * 100;

                  return $rule;
              });

        $logs = $user->scoreLogs()->latest()->paginate(10);

        return view('user.scores.index', compact('user', 'logs', 'rules'));
    }


    public function setting()
    {
        $user = $this->user();

        return view('user.users.setting', compact('user'));
    }


    public function update(Request $request)
    {
        $user = $this->user();

        $this->validate(
            $request, [
            'avatar' => 'required',
            'sex' => 'in:0,1',
        ], [
                'avatar.required' => '头像不能为空',
                'sex.in' => '性别格式不对',
            ]
        );

        // 除了第三方授权登录的用户导致没有名字之外
        // 其他用户是不允许修改用户名和邮箱
        $user->sex = $request->input('sex');
        $user->avatar = $request->input('avatar');


        // 如果当前用户第一次修改用户名
        if ($user->is_init_name && $request->filled('name')) {

            $name = $request->input('name');

            if (User::query()->where('name', $name)->exists()) {

                return back()->withErrors('用户名已经存在');
            }

            $user->name = $name;
            $user->is_init_name = false;
        }

        // 如果当前用户第一次修改邮箱
        if ($user->is_init_email && $request->filled('email')) {

            $email = $request->input('email');

            if (User::query()->where('email', $email)->exists()) {

                return back()->withErrors('邮箱已经存在');
            }

            $user->email = $email;
            $user->is_init_email = false;
        }

        // 初始用户可以修改邮箱
        $user->save();

        return back()->with('status', '修改成功');
    }


    public function subscribe(Request $request)
    {
        $subscribeModel = $this->user()->subscribe()->firstOr(function () {

            return new Subscribe();
        });

        $subscribeModel->email = $request->input('email');
        // 如果已经存在了记录
        if ($subscribeModel->exists) {

            // 如果是已经有数据的, 代表已经订阅过了
            $subscribeModel->is_subscribe = ! $subscribeModel->is_subscribe;
        } else {
            $subscribeModel->is_subscribe = 1;
            $subscribeModel->user_id = $this->user()->id;
        }
        $subscribeModel->save();

        if ($subscribeModel->is_subscribe) {
            return responseJson(201, '订阅成功');
        }

        return responseJson(200, '欢迎下次再订阅');
    }

    /**
     * 用户上传头像
     *
     * @param UploadServe $uploadServe
     * @return array
     */
    public function uploadAvatar(UploadServe $uploadServe)
    {
        $disk = 'public';

        try {
            $link = $uploadServe->setFileInput('file')
                                ->setMaxSize('5M')
                                ->setExtensions(['jpg', 'jpeg', 'png', 'bmp', 'gif'])
                                ->validate()
                                ->store('avatars', compact('disk'));

        } catch (UploadException $e) {

            return [
                'code' => 302,
                'msg' => $e->getMessage(),
                'data' => []
            ];
        }


        return [
            'code' => 0,
            'msg' => '图片上传成功',
            'data' => ['src' => $link, 'link' => \Storage::url($link)]
        ];
    }


    public function showPasswordForm()
    {
        $user = $this->user();

        return view('user.users.password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $this->validate(
            $request, [
            'password' => 'required|min:6|confirmed',
        ], [
                'old_password.required' => '旧密码不能为空',
                'password.required' => '新密码不能为空',
                'password.min' => '新密码必须大于6位',
                'password.confirmed' => '两次密码不一致',
            ]
        );

        $user = $request->user();
        // 如果是从未设置过密码就就不用验证旧密码
        if (! $user->is_init_password && ! $this->validatePassword($request->input('old_password'))) {
            return back()->withErrors(['old_password' => '旧密码不正确']);
        }

        // 设置过密码之后，再也不是初始密码
        $user->is_init_password = false;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return back()->with('status', '密码修改成功');
    }

    private function validatePassword($oldPassword)
    {
        return Hash::check($oldPassword, $this->user()->password);
    }

    /**
     * @return User|null
     */
    protected function user()
    {
        return auth()->user();
    }


}
