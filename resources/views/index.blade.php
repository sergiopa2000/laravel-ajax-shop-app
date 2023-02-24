@extends('layout')
@section('content')
	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>
		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			
			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="{{ url('assets/images/item-cart-01.jpg') }}" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								White Shirt Pleat
							</a>

							<span class="header-cart-item-info">
								1 x $19.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="{{ url('assets/images/item-cart-02.jpg') }}" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Converse All Star
							</a>

							<span class="header-cart-item-info">
								1 x $39.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="{{ url('assets/images/item-cart-03.jpg') }}" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Nixon Porter Leather
							</a>

							<span class="header-cart-item-info">
								1 x $17.00
							</span>
						</div>
					</li>
				</ul>
				
				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: $75.00
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<!-- Product -->
	<div class="bg0 m-t-23 p-b-140">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div id="category-container" class="flex-w flex-l-m filter-tope-group m-tb-10">
					<a href="#" data-name="category" data-value="0" class="how-active1 stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter="*">
						All Products
					</a>
					@foreach ($categories as $category)
						<a data-name="category" data-value="{{ $params['category'][$category->name] }}" href="#" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
							{{ ucfirst($category->name) }}
						</a>
					@endforeach
				</div>

				<div class="flex-w flex-c-m m-tb-10">
					<div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
						<i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
						<i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						 Filter
					</div>

					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>
				
				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>
							<input id="search-input" class="mtext-107 cl2 size-114 plh2 p-r-15" type="search" name="q" value="{{ $q ?? '' }}" placeholder="Search">
					</div>	
				</div>

				<!-- Filter -->
				<div class="dis-none panel-filter w-full p-t-10">
					<div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Sort Type
							</div>

							<ul id="sort-type-container">
								<li class="p-b-6">
									<a href="#" data-name="sorttype" data-value="{{ $params['sorttype']['params']['asc'] }}" class="filter-link-active filter-link stext-106 trans-04">
										Ascendant
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="sorttype" data-value="{{ $params['sorttype']['params']['desc'] }}" class="filter-link stext-106 trans-04">
										Descendant
									</a>
								</li>
							</ul>
						</div>
						
						<div class="filter-col1 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Sort By
							</div>

							<ul id="sort-by-container">
								<li class="p-b-6">
									<a href="#" data-name="sortby" data-value="{{ $params['sortby']['params']['product.name'] }}" class="filter-link-active filter-link stext-106 trans-04">
										Name
									</a>
								</li>
								
								<li class="p-b-6">
									<a href="#" data-name="sortby" data-value="{{ $params['sortby']['params']['product.created_at'] }}" class="filter-link stext-106 trans-04">
										Newness
									</a>
								</li>
								
								<li class="p-b-6">
									<a href="#" data-name="sortby" data-value="{{ $params['sortby']['params']['product.price'] }}" class="filter-link stext-106 trans-04">
										Price
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Popularity
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" class="filter-link stext-106 trans-04">
										Average rating
									</a>
								</li>


							</ul>
						</div>

						<div class="filter-col2 p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Price
							</div>

							<ul id="price-container">
								<li class="p-b-6">
									<a href="#" data-name="price" data-value="0" class="filter-link-active filter-link stext-106 trans-04">
										All
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="price" data-value="{{ $params['price']['params']['0&50'] }}" class="filter-link stext-106 trans-04">
										$0.00 - $50.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="price" data-value="{{ $params['price']['params']['50&100'] }}" class="filter-link stext-106 trans-04">
										$50.00 - $100.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="price" data-value="{{ $params['price']['params']['100&150'] }}" class="filter-link stext-106 trans-04">
										$100.00 - $150.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="price" data-value="{{ $params['price']['params']['150&200'] }}" class="filter-link stext-106 trans-04">
										$150.00 - $200.00
									</a>
								</li>

								<li class="p-b-6">
									<a href="#" data-name="price" data-value="{{ $params['price']['params']['200'] }}" class="filter-link stext-106 trans-04">
										$200.00+
									</a>
								</li>
							</ul>
						</div>

						<div class="p-r-15 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Color
							</div>

							<ul id="color-container">
								<li class="p-b-6">
									<a id="all-colors" href="#" data-name="color" data-value="0" class="filter-link-active filter-link stext-106 trans-04">
										All
									</a>
								</li>
								@foreach ($colors as $color)
									<li class="p-b-6">
										<span class="fs-15 lh-12 m-r-6" style="color: {{ $color->hexcode }};">
											<i class="zmdi zmdi-circle"></i>
										</span>
	
										<a href="#" data-name="color" data-value="{{ $params['color']['params'][$color->name] }}" class="filter-link stext-106 trans-04">
											{{ ucfirst($color->name) }}
										</a>
									</li>
								@endforeach
							</ul>
						</div>

						<div class="filter-col4 p-b-27">
							<div class="mtext-102 cl2 p-b-15">
								Tags
							</div>

							<div id="tag-container" class="flex-w p-t-4 m-r--5">
								@foreach ($tags as $tag)
								<a  href="#" data-name="tag" data-value="{{ $params['tag']['params'][$tag->name] }}" class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									{{ $tag->name }}
								</a>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="my-product-container" class="row isotope-grid">
				@foreach($products as $product)
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-pic hov-img0 product-img">
							@if($product->images[0] ?? '')
							<img style="object-fit:cover;height:100%;" src="{{ url('product/display/'. $product->images[0]->path) }}" alt="IMG-PRODUCT">
							@endif
							<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-toggle="modal" data-target="#product-modal-{{ $product->id }}">
								Quick View
							</a>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
									{{ $product->name }}
								</a>

								<span class="stext-105 cl3">
									${{ $product->price }}
								</span>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">
								<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
									<img class="icon-heart1 dis-block trans-04" src="{{ url('assets/images/icons/icon-heart-01.png') }}" alt="ICON">
									<img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ url('assets/images/icons/icon-heart-02.png') }}" alt="ICON">
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>

			<!-- Load more -->
			<div class="my-pagination flex-c-m flex-w w-full p-t-45">
				<ul id="pagination-container" class="pagination">
					
				</ul>
			</div>
		</div>
	</div>
	
		<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>
<div id="product-modal-container">
@foreach($products as $product)
	<div id="product-modal-{{ $product->id }}" class="my-product-modal wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button type="button" class="close how-pos3 hov3 trans-04" data-dismiss="modal" aria-label="Close">
					<img src="{{ url('assets/images/icons/icon-close.png') }}" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									@foreach($product->images as $image)
									<div class="item-slick3" data-thumb="{{ url('product/display/'. $image->path) }}">
										<div class="wrap-pic-w pos-relative" style="height: 500px;" >
											<img style="height:100%;object-fit:cover;" src="{{ url('product/display/'. $image->path) }}" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{ url('product/display/'. $image->path) }}">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<div class="d-flex">
							@foreach($product->tags as $tag)
								<a href="{{ $urls['tag'][$tag->name] }}" class="tag-active flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
									{{ $tag->name }}
								</a>
							@endforeach
							</div>
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								{{ $product->name }}
							</h4>

							<span class="mtext-106 cl2">
								${{ $product->price }}
							</span>

							<p class="stext-102 cl3 p-t-23">
								{{ $product->description }}
							</p>
							
							<!--  -->
							<div class="p-t-33">

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>
									
									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="my-form-select" name="time">
												@foreach($product->colors as $color)
												<option>{{ ucfirst($color->name) }}</option>
												@endforeach
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">

										<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Buy Now
										</button>
									</div>
								</div>	
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endforeach
</div>
@endsection

@section('scripts')
	<script type="text/javascript" src="{{ url('assets/js/ajax.js') }}"></script>
@endsection