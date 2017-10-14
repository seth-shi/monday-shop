@extends('layouts.shop')


@section('title')
    404
@endsection

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container pt-40 pb-60">
            <div class="container">
                <section class="error-page-area">
                    <div class="container">
                        <div class="error-page-wrapper t-center">
                            <div class="error-page-header">
                                <span class="color-blue">4</span>
                                <span class="color-green">0</span>
                                <span class="color-blue">4</span>
                            </div>
                            <div class="error-page-footer">
                                <h5 class="color-mid mb-5">Oops !</h5>
                                <h2 class="t-uppercase m-10 color-green">Sorry</h2>
                                <p class="color-muted mb-30 font-15">
                                    The Page you are looking for cannot be found!
                                </p>
                            </div>
                            <a href="index.html" class="btn btn-rounded">Back to home page</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection