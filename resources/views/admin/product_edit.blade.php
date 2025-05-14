@extends('layouts.admin')
@section('content')
 <!-- main-content-wrap -->
                        <div class="main-content-inner">
                            <!-- main-content-wrap -->
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Add Product</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="index-2.html">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <a href="all-product.html">
                                                <div class="text-tiny">Products</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Add product</div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- form-add-product -->
                                <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('admin.product.update', $product->id) }}">
            @csrf
            @method('PUT')
            
            <div class="wg-box">
                {{-- Product Name --}}
                <fieldset class="name">
                    <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                    <input class="mb-10" type="text" placeholder="Enter product name" name="name" value="{{ old('name', $product->name) }}" required>
                    @error('name') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Category --}}
                <div class="gap22 cols">
                    <fieldset class="category">
                        <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                        <div class="select">
                            <select name="category_id" required>
                                <option value="">Choose category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </fieldset>
                </div>

                {{-- Description --}}
                <fieldset class="description">
                    <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                    <textarea name="description" required>{{ old('description', $product->description) }}</textarea>
                    @error('description') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </fieldset>
            </div>

            <div class="wg-box">
                {{-- Current Image Preview --}}
                @if($product->image)
                    <div class="mb-3">
                        <strong>Current Image:</strong><br>
                        <img src="{{ asset('uploads/products/' . $product->image) }}" width="120">
                    </div>
                @endif

                {{-- Image Upload --}}
                <fieldset>
                    <div class="body-title">Upload image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">Drop your image or <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                    @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                </fieldset>

                {{-- Price --}}
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Price <span class="tf-color-1">*</span></div>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}" required>
                        @error('price') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </fieldset>
                </div>

                {{-- Quantity --}}
                <div class="cols gap22">
                    <fieldset class="name">
                        <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                        <input type="text" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                        @error('quantity') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror
                    </fieldset>
                </div>
            </div>

            <div class="cols gap10">
                <button class="tf-button w-full" type="submit">Update Product</button>
            </div>
        </form>
                                <!-- /form-add-product -->
                            </div>
                            <!-- /main-content-wrap -->
                        </div>
                        <!-- /main-content-wrap -->

@endsection