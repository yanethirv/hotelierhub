@extends('layouts.vuexy')

@section('title')
{{ __("Show Invoice") }}
@endsection

@section('extra-css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/invoice.css') }}">
@endsection

@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __("Dashboard") }}</a>
                                </li>
                                <li class="breadcrumb-item active">{{ __("Show Invoice") }}
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">

                            <!-- invoice functionality start -->
                            <section class="invoice-print mb-1">
                                <div class="row">
            
                                    <fieldset class="col-12 col-md-5 mb-1 mb-md-0">
                                        <div class="input-group">
                                           {{--   <input type="text" class="form-control" placeholder="Email" aria-describedby="button-addon2">
                                            <div class="input-group-append" id="button-addon2">
                                                <button class="btn btn-outline-primary" type="button">Send Invoice</button>
                                            </div>--}}
                                        </div>
                                    </fieldset> 
                                    <div class="col-12 col-md-7 d-flex flex-column flex-md-row justify-content-end">
                                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary ml-0 ml-md-1">{{ __("Back") }}</a>
                                        <a href="{{ route("orders.downloadInvoice", ["order" => $order->id]) }}" class="btn btn-primary  ml-0 ml-md-1">
                                            <i class="feather icon-download"></i> {{ __("Download") }}
                                        </a>
                                        </a>
                                    </div>
                                </div>
                            </section>
                            <!-- invoice functionality end -->
                            <!-- invoice page -->
                            <section class="card invoice-page">
                                <div id="invoice-template" class="card-body">
                                    <!-- Invoice Company Details -->
                                    <div id="invoice-company-details" class="row">
                                        <div class="col-sm-6 col-12 text-left pt-1">
                                            <div class="media pt-1">
                                                <img src="{{ asset('images/logo/logo-soh.png') }}" alt="company logo" />
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12 text-right">
                                            <h1>Invoice</h1>
                                            <div class="invoice-details mt-2">
                                                <h6>INVOICE NO.</h6>
                                                <p>{{ $order->invoice_id }}</p>
                                                <h6 class="mt-2">INVOICE DATE</h6>
                                                <p>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Invoice Company Details -->
            
                                    <!-- Invoice Recipient Details -->
                                    <div id="invoice-customer-details" class="row pt-2">
                                        <div class="col-sm-6 col-12 text-left">
                                            <h5>Recipient</h5>
                                            <div class="recipient-info my-2">
                                                <p>{{ Auth::user()->name }}</p>
                                               {{--   <p>8577 West West Drive</p>
                                                <p>Holbrook, NY</p>
                                                <p>90001</p>--}}
                                            </div>
                                            <div class="recipient-contact pb-2">
                                                <p>
                                                    <i class="feather icon-mail"></i>
                                                    {{ Auth::user()->email }}
                                                </p>
                                                <p>
                                                    <i class="feather icon-phone"></i>
                                                    {{ Auth::user()->mobile }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12 text-right">
                                            <h5>Stand Out Hotels</h5>
                                            <div class="company-info my-2">
                                               {{--   <p>9 N. Sherwood Court</p>
                                                <p>Elyria, OH</p>
                                                <p>94203</p>--}}
                                            </div>
                                            <div class="company-contact">
                                                <p>
                                                    <i class="feather icon-mail"></i>
                                                    admin@hotelierhub.net
                                                </p>
                                                <p>
                                                    <i class="feather icon-phone"></i>
                                                    +91 999 999 9999
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!--/ Invoice Recipient Details -->
            
                                    <!-- Invoice Items Details -->
                                    <div id="invoice-items-details" class="pt-1 invoice-items-table">
                                        <div class="row">
                                            <div class="table-responsive col-12">
                                                <table class="table table-borderless">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th>DESCRIPTION</th>
                                                            <th>DATE</th>
                                                            <th>AMOUNT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-center">
                                                        @foreach($order->orderLines as $orderLine)
                                                            <tr>
                                                                <td>{{ $orderLine->product->name }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($orderLine->created_at)->format('d/m/Y')}}</td>
                                                                <td>{{ format_currency_helper($orderLine->product->price) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="invoice-total-details" class="invoice-total-table">
                                        <div class="row">
                                            <div class="col-7 offset-5">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <th>SUBTOTAL</th>
                                                                <td>{{ format_currency_helper($orderLine->product->price) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>TAX (%)</th>
                                                                <td>$0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th>TOTAL</th>
                                                                <td>{{ format_currency_helper($orderLine->product->price) }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
                                    <!-- Invoice Footer -->
                                   {{--   <div id="invoice-footer" class="text-right pt-3">
                                        <p>Transfer the amounts to the business amount below. Please include invoice number on your check.
                                            <p class="bank-details mb-0">
                                                <span class="mr-4">BANK: <strong>FTSBUS33</strong></span>
                                                <span>IBAN: <strong>G882-1111-2222-3333</strong></span>
                                            </p>
                                    </div> --}}
                                    <!--/ Invoice Footer -->
            
                                </div>
                            </section>
                            <!-- invoice page end -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection

@section('extra-script')
<script src="{{ asset('js/scripts/pages/invoice.js') }}"></script>
@endsection