<div class="Product-box sm-margin-top-96px xs-margin-top-0">
    <div class="container">
        <div class="biolife-title-box mb-30">
            <div class="g-img">
                <h3 class="main-title" style="margin-bottom: 8px">
                    Product Category
                </h3>
            </div>
        </div>

        <div class="row">
            @forelse ($categories as $category)
                <div class="col-lg-2 col-md-3 col-12 mb-2 mb-lg-0">
                    <div class="card cat-card">
                        <div class="card-body">
                            <img
                                src="{{ asset($category->image ?? 'uploads/no_images/no-image.png') }}"
                                alt="{{ $category->name }}"
                                class="cat-thumnail"
                            />
                        </div>
                        <div class="card-footer text-center">
                            <h4 class="b-font">{{ $category->name }}</h4>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No categories found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
