<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $validator = $this->buildValidator($request->all());

        if ($validator->fails()) {
            return response()->json(['code' => 400, 'msg' => $validator->errors()->first()]);
        }

        /**
         * @var $orderDetail OrderDetail
         */
        $orderDetail = OrderDetail::query()->find($request->input('id'));
        $masterOrder = $orderDetail->order()->first();

        $data = $request->only(['score', 'content']);

        // TODO 还可以验证是否支付等等，暂不做
        // 主订单的人是否是当前这个人
        if ($masterOrder->user_id != auth()->id()) {
            return response()->json(['code' => 400, 'msg' => '非法评论']);
        }

        // 可以评论
        $data['order_id'] = $masterOrder->id;
        $data['product_id'] = $orderDetail->product_id;
        $data['user_id'] = auth()->id();

        $orderDetail->comment()->create($data);
        $orderDetail->setAttribute('is_commented', true)->save();

        return response()->json(['code' => 200, 'msg' => '评论成功']);
    }


    /**
     * @param $data
     * @return \Illuminate\Validation\Validator
     */
    public function buildValidator($data)
    {
        return Validator::make($data, [
            'id' => ['required', Rule::exists('order_details')->where('is_commented', 0)],
            'score' => 'required:in,1,2,3,4,5',
            'content' => 'required',
        ], [
            'id.required' => '非法评论',
            'id.exists' => '非法评论',
            'score.in' => '分值不合法',
        ]);
    }
}
