@extends('pelanggan.layout.index')

@section('conten')
    <div class="mt-5">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="7000">
                    <img src="{{ asset('asset/img/1.png') }}" class="d-block w-100 img-fluid" style="max-height: 350px;"
                        alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="7000">
                    <img src="{{ asset('asset/img/2.png') }}" class="d-block w-100 img-fluid" style="max-height: 350px;"
                        alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="7000">
                    <img src="{{ asset('asset/img/3.png') }}" class="d-block w-100 img-fluid" style="max-height: 350px;"
                        alt="...">
                </div>
            </div>
        </div>
    </div>
    @if ($best->count() == 0)
        <div class="container"></div>
    @else
        <h4 class="mt-5 text-center">Best Seller</h4>
        <div class="content mt-3 d-flex flex-wrap gap-4 mb-5 justify-content-center">
            @foreach ($best as $b)
                <div class="card tilt-card" style="width: 190px;" data-tilt data-tilt-max="20" data-tilt-scale="1.1">
                    <div class="card-header m-auto" style="height: 100%; width: 100%;">
                        <img src="{{ asset('storage/product/' . $b->foto) }}" alt="baju 1"
                            style="width: 100%; height: 150px; object-fit: cover; padding: 0;">
                    </div>
                    <div class="card-body">
                        <p class="m-0 text-justify">{{ $b->nama_product }}</p>
                    </div>
                    <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                        <p class="m-0" style="font-size: 16px; font-weight: 600;">
                            <span>IDR</span>{{ number_format($b->harga) }}
                        </p>
                        @auth
                            <form action="{{ route('addTocart') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $b->id }}">
                                <button type="submit" class="btn btn-outline"
                                    style="font-size: 24px; --bs-btn-color: #35155C; --bs-btn-border-color: #35155D; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #35155D; --bs-btn-hover-border-color: #35155D; --bs-btn-focus-shadow-rgb: 13,110,253; --bs-btn-active-color: #fff; --bs-btn-active-bg: #351552; --bs-btn-active-border-color: #35155D; --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); --bs-btn-disabled-color: #35155D; --bs-btn-disabled-bg: transparent; --bs-btn-disabled-border-color: #35155D; --bs-gradient: none;">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline"
                                style="font-size: 24px; --bs-btn-color: #35155C; --bs-btn-border-color: #35155D; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #35155D; --bs-btn-hover-border-color: #35155D; --bs-btn-focus-shadow-rgb: 13,110,253; --bs-btn-active-color: #fff; --bs-btn-active-bg: #351552; --bs-btn-active-border-color: #35155D; --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); --bs-btn-disabled-color: #35155D; --bs-btn-disabled-bg: transparent; --bs-btn-disabled-border-color: #35155D; --bs-gradient: none;">
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                        @endguest
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="container">
        <h4 class="mt-5 text-center">New Product</h4>
        <div class="content mt-3 d-flex flex-wrap gap-4 justify-content-center">
            @if ($data->isEmpty())
                <h1>Belum ada product ...!</h1>
            @else
                @foreach ($data as $x)
                    <div class="card tilt-card mb-4" style="width: 190px;" data-tilt data-tilt-max="20"
                        data-tilt-scale="1.1">
                        <div class="card-header m-auto" style="height: 100%; width: 100%;">
                            <a href="{{ asset('storage/product/' . $x->foto) }}" data-lightbox="gallery"
                                data-title="{{ $x->nama_product }}">
                                <img src="{{ asset('storage/product/' . $x->foto) }}" alt="{{ $x->nama_product }}"
                                    style="width: 100%; height: 150px; object-fit: cover; padding: 0;"
                                    class="enlarge-image">
                            </a>
                        </div>
                        <div class="card-body">
                            <p class="m-0 text-justify">{{ $x->nama_product }}</p>
                        </div>
                        <div class="card-footer d-flex flex-row justify-content-between align-items-center">
                            <p class="m-0" style="font-size: 16px; font-weight: 600;">
                                <span>IDR</span>{{ number_format($x->harga) }}
                            </p>
                            @auth
                                <form action="{{ route('addTocart') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $x->id }}">
                                    <button type="submit" class="btn btn-outline"
                                        style="font-size: 24px; --bs-btn-color: #35155C; --bs-btn-border-color: #35155D; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #35155D; --bs-btn-hover-border-color: #35155D; --bs-btn-focus-shadow-rgb: 13,110,253; --bs-btn-active-color: #fff; --bs-btn-active-bg: #351552; --bs-btn-active-border-color: #35155D; --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); --bs-btn-disabled-color: #35155D; --bs-btn-disabled-bg: transparent; --bs-btn-disabled-border-color: #35155D; --bs-gradient: none;">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                            @endauth
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-outline"
                                    style="font-size: 24px; --bs-btn-color: #35155C; --bs-btn-border-color: #35155D; --bs-btn-hover-color: #fff; --bs-btn-hover-bg: #35155D; --bs-btn-hover-border-color: #35155D; --bs-btn-focus-shadow-rgb: 13,110,253; --bs-btn-active-color: #fff; --bs-btn-active-bg: #351552; --bs-btn-active-border-color: #35155D; --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125); --bs-btn-disabled-color: #35155D; --bs-btn-disabled-bg: transparent; --bs-btn-disabled-border-color: #35155D; --bs-gradient: none;">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            @endguest
                        </div>
                    </div>
                @endforeach
        </div>
    </div>

    <center>
        <div class="pagination mt-5 d-flex flex-row justify-content-between">
            <div class="showData">
                Data ditampilkan {{ $data->count() }} dari {{ $data->total() }}
            </div>
            <div>
                {{ $data->links() }}
            </div>
        </div>
    </center>
    </div>
    </div>
    @endif
@endsection
@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
                max: 20,
                scale: 1.1,
                speed: 400,
            });
        });
    </script>
@endsection
