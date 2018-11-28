@extends('layouts.shop')


@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container pt-40 pb-60">
            <div class="container">
                <section class="error-page-area">
                    <div class="container">
                        <div class="error-page-wrapper t-center">
                            <div class="error-page-header">
                                <span class="color-blue">5</span>
                                <span class="color-green">0</span>
                                <span class="color-blue">0</span>
                            </div>
                            <div class="error-page-footer">
                                <h5 class="color-mid mb-5">Oops !</h5>
                                <h2 class="t-uppercase m-10 color-green">
                                    {{ $exception->getMessage()  ? $exception->getMessage() : '服务器未知错误~ '}}
                                </h2>
                                <p class="color-muted mb-30 font-15">
                                    不好意思
                                </p>
                            </div>
                            <a  href="javascript:;" onclick="history.go(-1)" class="btn btn-rounded">返回上一页</a>

                            <!-- 判断当前路由是否是后台的 -->
                            <a href="{{ str_contains(url()->current(), 'admin') ? url('/admin/welcome') : url('/') }}" class="btn btn-rounded">去首页</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection
