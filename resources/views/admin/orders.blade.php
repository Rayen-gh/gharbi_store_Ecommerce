@extends('layouts.admin')
@section('content')


                        <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Orders</h3>
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
                                            <div class="text-tiny">Orders</div>
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
                                    </div>
                                    <div class="wg-table table-all-user">
                                        <div class="table-responsive">
                                            <table class="table-auto w-full border border-gray-200 rounded-lg overflow-hidden shadow-sm">
    <thead class="bg-gray-100 text-sm text-gray-600">
        <tr>
            <th class="px-4 py-3 text-left">Order #</th>
            <th class="px-4 py-3 text-left">Customer</th>
            <th class="px-4 py-3 text-left">Email</th>
            
        </tr>
    </thead>
    <tbody class="text-sm text-gray-700">
        @forelse ($orders as $order)
            <tr class="border-t hover:bg-gray-50 transition">
                <td class="px-4 py-3">{{ $order->id }}</td>
                <td class="px-4 py-3">{{ $order->customer_name }}</td>
                <td class="px-4 py-3">{{ $order->customer_email }}</td>
             
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-6 text-center text-gray-500">No orders found.</td>
            </tr>
        @endforelse
    </tbody>
</table>

                      
                                        </div>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                                    </div>
                                </div>
                            </div>
                        </div>


                 
                
@endsection