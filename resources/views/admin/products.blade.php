@extends('layouts.admin')
@section('content')

                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>All Products</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index.html">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">All Products</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{route('admin.product.add')}}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                   <th>Description</th>
                                                   <th>Image</th>
                                                   <th>Quantity</th>
                                                   <!--<th>Category</th>-->
                                                   <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 @foreach($products as $product)
                                                <tr>
                                                    <td>{{$product->id}}</td>
                                                    <td class="pname">
                                                        
                                                        <div class="name">
                                                            <a href="#" class="body-title-2">{{$product->title}}</a>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="price">
                                                            <span class="body-title-2">${{$product->price}}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="description">
                                                            <span class="body-title-2">{{ Str::limit($product->description, 20) }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                @if($product->display_image)
                                    @if(filter_var($product->display_image, FILTER_VALIDATE_URL))
                                        {{-- External URL image --}}
                                        <img src="{{$product->display_image}}" 
                                             alt="{{$product->title}}" 
                                             class="image" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"
                                             onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                                    @else
                                        {{-- Local file image --}}
                                        <img src="{{asset('uploads/products/' . $product->display_image)}}" 
                                             alt="{{$product->title}}" 
                                             class="image" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;"
                                             onerror="this.src='https://placehold.co/60x60?text=No+Image'">
                                    @endif
                                @else
                                    {{-- Fallback placeholder --}}
                                    <img src="https://placehold.co/60x60?text=No+Image" 
                                         alt="No Image" 
                                         class="image" 
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                @endif
                                
                                {{-- Show multiple images indicator if product has more than one image --}}
                                @if(count($product->image_urls) > 1)
                                    <small class="text-muted d-block mt-1">+{{ count($product->image_urls) - 1 }} more</small>
                                @endif
                            </td>
                                                    <td>
                                                        <div class="quantity">
                                                            <span class="body-title-2">{{$product->quantity}}</span>
                                                        </div>
                                                    </td>
                                                   <!--  <td>
                                                        <<div class="category">
                                                            <span class="body-title-2">$product->category->name</span>
                                                        </div>
                                                    </td> -->
                                                     
                                                    <td>
                                                        <div class="list-icon-function">
                                                            <a href="#" target="_blank">
                                                                <div class="item eye">
                                                                    <i class="icon-eye"></i>
                                                                </div>
                                                            </a>
                                                            <a href="{{route('admin.product.edit', $product->id)}}">
                                                                <div class="item edit">
                                                                    <i class="icon-edit-3"></i>
                                                                </div>
                                                            </a>
                                                            <form action="{{ route('admin.product.delete', $product->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit" class="item text-danger delete" onclick="return confirm('Are you sure?')">
        <i class="icon-trash-2"></i>
    </button>
</form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">


                                    </div>
                                </div>
                            </div>
                        </div>
              
@endsection