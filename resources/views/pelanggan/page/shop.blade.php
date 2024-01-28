@extends('pelanggan.layout.index')

@section('conten')
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Katalog
                </div>
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                Wanita
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body p-0">
                                <div class="d-flex flex-column gap-4">
                                    <a href="{{ route('shop', ['type' => 'baju', 'category' => 'wanita']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Baju Wanita
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'celana', 'category' => 'wanita']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Celana Wanita
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'acesoris', 'category' => 'wanita']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Acesoris Wanita
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                Pria
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body p-0">
                                <div class="d-flex flex-column gap-4">
                                    <a href="{{ route('shop', ['type' => 'baju', 'category' => 'pria']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Baju Pria
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'celana', 'category' => 'pria']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Celanan Pria
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'acesoris', 'category' => 'pria']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Acesoris Pria
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree"
                                aria-expanded="false"aria-controls="flush-collapseThree">
                                Anak-anak
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body p-0 ">
                                <div class="d-flex flex-column gap-4">
                                    <a href="{{ route('shop', ['type' => 'baju', 'category' => 'anak-anak']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Baju Anak
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'celana', 'category' => 'anak-anak']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Celana Anak
                                    </a>
                                    <a href="{{ route('shop', ['type' => 'acesoris', 'category' => 'anak-anak']) }}"
                                        class="page-link p-3">
                                        <i class="fas fa-plus"></i> Acesoris Anak
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9 d-flex flex-wrap gap-3 mb-4 mt-3 justify-content-center">
            @if ($data->isEmpty())
                <h1>Belum ada product ...!</h1>
            @else
                @foreach ($data as $x)
                    <div class="card tilt-card" style="width: 190px;" data-tilt data-tilt-max="20" data-tilt-scale="1.1">
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
                                <span>Rp</span>{{ number_format($x->harga) }}
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
            @endif
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
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
            max: 20,
            scale: 1.1,
            speed: 400,
        });
    });

</script>
