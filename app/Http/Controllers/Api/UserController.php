<?php

namespace App\Http\Controllers\Api;


use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends BaseController
{
    protected $userRepository;
    protected $userTransfromer;

    public function __construct(UserRepository $userRepository, UserTransformer $userTransfromer)
    {
        $this->userRepository = $userRepository;
        $this->userTransfromer = $userTransfromer;
    }

    public function getUserByAccount(Request $request)
    {
        Storage::disk();
        // 获取用户信息
        $user = $this->userRepository->getUserByAccount($request->input('account'));

        if ($user)
        {
            $data = $this->userTransfromer->transform($user);
            $this->setStatusCode(200)->setMessage('查找成功')->setData($data);
        }
        else
        {
            $this->setStatusCode(401)->setMessage('不存在此用户');
        }

        return $this->response();
    }

    public function index()
    {
        $users = $this->userRepository->getUsers();

        if ($users)
        {
            $data = $this->userTransfromer->transformCollection($users->toArray());
            $this->setStatusCode(200)->setMessage('查找成功')->setData($data);
        }
        else
        {
            $this->setStatusCode(401)->setMessage('不存在此用户');
        }

        return $this->response();
    }

    public function show($id)
    {
        $user = $this->userRepository->getUserById($id);

        if ($user)
        {
            $data = $this->userTransfromer->transform($user);
            $this->setStatusCode(200)->setMessage('查找成功')->setData($data);
        }
        else
        {
            $this->setStatusCode(401)->setMessage('不存在此用户');
        }

        return $this->response();
    }
}
