<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeckillRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Seckill;
use Carbon\Carbon;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class SeckillController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('秒杀列表')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('新建秒杀')
            ->description('')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Seckill);

        $grid->model()->latest();

        $grid->column('id');

        $grid->column('product.id', '商品ID');
        $grid->column('product.name', '商品名字')->display(function ($name) {
            return str_limit($name, 30);
        });
        $grid->column('product.thumb', '商品图')->display(function ($thumb) {
            return image($thumb);
        });

        $grid->column('price', '秒杀价');
        $grid->column('number', '秒杀数量');
        $grid->column('start_at', '开始时间');
        $grid->column('end_at', '结束时间');
        $grid->column('rollback_count', '回滚量');
        $grid->column('is_rollback', '是否回滚数量')->display(function ($is) {
            return $is ? '是' : '否';
        });
        $grid->column('created_at', '创建时间');
        $grid->column('updated_at', '修改时间');

        $grid->actions(function (Grid\Displayers\Actions $actions) {

            $actions->disableView();
            $actions->disableEdit();
        });

        return $grid;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Seckill);

        $categories = Category::selectOrderAll();
        $form->select('category_id', '分类')
             ->options($categories)
             ->load('product_id', admin_url('api/products'));
        $form->select('product_id', '秒杀商品');

        $form->number('price', '秒杀价')
             ->default(1);
        $form->number('number', '秒杀数量')
             ->default(1)
             ->help('保证商品的库存数量大于此数量，会从库存中减去');

        $now = Carbon::now()->addHour(1);
        $form->datetime('start_at', '开始时间')
             ->default($now->format('Y-m-d H:00:00'));
        $form->datetime('end_at', '结束时间')
             ->default($now->addHour(1)->format('Y-m-d H:00:00'))
             ->rules('required|date|after_or_equal:start_at');

        return $form;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $number = $request->input('number', 0);
        $product = Product::query()->findOrFail($request->input('product_id'));

        if ($number > $product->count) {

            return back()->withInput()->withErrors(['number' => '秒杀数量不能大于库存数量']);
        }

        if (Product::query()->whereKey($request->input('product_id'))->doesntExist()) {

            return back()->withInput()->withErrors(['product_id' => '无效的商品']);
        }

        DB::beginTransaction();

        try {

            $attributes = $request->only(['category_id', 'product_id', 'price', 'number', 'start_at', 'end_at']);
            Seckill::create($attributes);

            // 减去库存数量
            $product->decrement('count', $number);

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->withInput()->withErrors(['category_id' => $e->getMessage()]);
        }

        DB::commit();

        admin_toastr('添加成功');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        /**
         * @var $seckill Seckill
         * @var $product Product
         */
        $seckill = Seckill::query()->findOrFail($id);


        // 如果已经到了开始抢购时间，就不能删除了
        $now = Carbon::now();
        $startTime = Carbon::make($seckill->start_at);
        $endTime = Carbon::make($seckill->end_at);

        // 如果正处于抢购的时间，不允许删除
        if ($now->gte($startTime) && $now->lte($endTime)) {

            return response()->json([
                'status' => false,
                'message' => '秒杀已经开始，不能删除',
            ]);
        }

        DB::beginTransaction();


        try {

            // 先把 redis 数据删除掉
            // 虽然过期会自动清理，但是如果用户是
            // 删除还没有开始的秒杀，只能在这里手动清理
            \Redis::connection()->del([$seckill->getRedisModelKey(), $seckill->getRedisQueueKey()]);


            $seckill->delete();

            $data = [
                'status'  => false,
                'message' => trans('admin.delete_succeeded'),
            ];

        } catch (\Exception $e) {

            $data = [
                'status'  => true,
                'message' => trans('admin.delete_failed'),
            ];
            DB::rollBack();
        }

        DB::commit();
        return response()->json($data);
    }
}
