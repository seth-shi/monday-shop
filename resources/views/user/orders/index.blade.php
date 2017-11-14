@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">

                <!-- Checkout Area -->
                <section class="section checkout-area panel prl-30 pt-20 pb-40">
                    <h2 class="h3 mb-20 h-title">支付信息</h2>
                    @if (session()->has('status'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="mb-30" method="post" action="{{ url('/user/orders/') }}">
                        {{ csrf_field() }}

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>选择收货地址</label>
                                    <select class="form-control" name="address_id">
                                        <option value="0">请选择收货地址</option>
                                        @foreach (Auth::user()->addresses as $address)
                                            <option value="{{ $address->id }}">{{ $address->name }}/{{ $address->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit"  class="btn btn-lg btn-rounded mr-10">下单</button>
                    </form>
                </section>

            </div>
        </div>
        <!-- End Page Container -->


    </main>
@endsection