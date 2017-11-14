@extends('layouts.home')


@section('main')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <div class="row row-rl-10 row-tb-20">
                    <div class="page-content col-xs-12 col-sm-8 col-md-9">

                        <!-- Checkout Area -->
                        <section class="section checkout-area panel prl-30 pt-20 pb-40">
                            <h2 class="h3 mb-20 h-title">Payment Information</h2>
                            <form class="mb-30">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name on card</label>
                                            <input type="text" class="form-control" placeholder="Enter Name on Card">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Credit card number</label>
                                            <input type="text" class="form-control" placeholder="Enter Credit Card Number">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Card Type</label>
                                            <select class="form-control">
                                                <option>Select Card Type</option>
                                                <option>VISA</option>
                                                <option>MASTER CARD</option>
                                                <option>DISCOVER</option>
                                                <option>AMERICAN EXPRESS</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Expiration date</label>
                                            <input type="text" class="form-control" placeholder="MM/YY">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CCV Code</label>
                                            <input type="text" class="form-control" placeholder="3 digits only">
                                        </div>
                                    </div>

                                </div>
                            </form>
                            <a href="#" class="btn btn-lg btn-rounded mr-10">Continue</a>
                            <a href="cart.html" class="btn btn-lg btn-warning btn-rounded">Cancel Order</a>
                        </section>
                        <!-- End Checkout Area -->

                    </div>
                    <div class="page-sidebar col-xs-12 col-sm-4 col-md-3">

                        <!-- Blog Sidebar -->
                        <aside class="sidebar blog-sidebar">
                            <div class="row row-tb-10">
                                <div class="col-xs-12">
                                    <!-- Recent Posts -->
                                    <div class="widget checkout-widget panel p-20">
                                        <div class="widget-body">
                                            <table class="table mb-15">
                                                <tbody>
                                                <tr>
                                                    <td class="color-mid">Total products</td>
                                                    <td>$150.16</td>
                                                </tr>
                                                <tr>
                                                    <td class="color-mid">Shipping</td>
                                                    <td>$60.00</td>
                                                </tr>
                                                <tr>
                                                    <td class="color-mid">Total tax</td>
                                                    <td>$10.00</td>
                                                </tr>
                                                <tr class="font-15">
                                                    <td class="color-mid">Total</td>
                                                    <td class="color-green">$220.16</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <a href="cart.html" class="btn btn-info btn-block btn-sm">Edit Cart</a>
                                        </div>
                                    </div>
                                    <!-- End Recent Posts -->
                                </div>
                            </div>
                        </aside>
                        <!-- End Blog Sidebar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Container -->


    </main>
@endsection