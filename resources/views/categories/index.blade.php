@extends('layouts.shop')

@section('main')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <section class="stores-area stores-area-v1">
                    <h3 class="mb-40 t-uppercase">查看所有分类</h3>
                    <div class="row row-rl-15 row-tb-15 t-center">

                        @foreach ($categories as $category)
                            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="/categories/{{ $category->id }}" class="panel is-block">
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <div class="store-logo">
                                            <img src="{{ $category->thumb }}" alt="{{ $category->name }}">
                                        </div>
                                    </div>
                                    <h6 class="store-name ptb-10">{{ $category->title }}</h6>
                                </a>
                            </div>
                        @endforeach

                    </div>
                    <div class="page-pagination text-center mt-30 p-10 panel">
                        <nav>
                            <!-- Page Pagination -->
                            {{ $categories->links() }}
                            <!-- End Page Pagination -->
                        </nav>
                    </div>
                </section>
            </div>
        </div>
        <!-- End Page Container -->


    </main>
@endsection
