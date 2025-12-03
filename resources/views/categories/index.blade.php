@extends('templates.app')

@section('content')
<section class="text-center fade-in py-5 bg-white">
    <h2 class="fw-normal" style="font-family:'Playfair Display'; font-size:1.5rem; color:#2c2c54;">
        Our Categories
    </h2>
    <hr class="mx-auto mt-3 mb-4" style="width:100px; border:1px solid #2c2c54;">

    <div class="container">
        <div class="row justify-content-center">
            @foreach ($categories as $category)
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('categories.products', $category->id) }}"
                       class="btn btn-outline-success w-100 rounded-pill">
                        {{ strtoupper($category->name) }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
