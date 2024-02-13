<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>24EnglishCenter || Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{asset('invoice/assets/css/bootstrap.min.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('invoice/assets/fonts/font-awesome/css/font-awesome.min.css')}}">

    <!-- Favicon icon -->
    {{-- <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" > --}}

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('invoice/assets/css/style.css')}}">
</head>
<body>

<!-- Invoice 1 start -->
<div class="invoice-1 invoice-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row g-0">
                                <div class="col-sm-6">
                                    <div class="invoice-logo">
                                        <!-- logo started -->
                                        <div class="logo">
                                            <img src="{{asset('logo/logo.png')}}" style="width: 300px; margin-top:-90px;" alt="logo">
                                        </div>
                                        <!-- logo ended -->
                                    </div>
                                </div>
                                <div class="col-sm-6 invoice-id">
                                    <div class="info">
                                        <h1 class="inv-header-1">Invoice</h1>
                                        <p class="mb-1">Invoice Number <span>#{{$order['id']}}</span></p>
                                        <p class="mb-0">Invoice Date <span>{{$formattedDate}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-top">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <h4 class="inv-title-1">Invoice To</h4>
                                        <h2 class="name mb-10">{{$dataUser['first_name']}} {{$dataUser['last_name']}}</h2>
                                        <p class="invo-addr-1">
                                            {{$dataUser['email']}} <br/>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="invoice-number mb-30">
                                        <div class="invoice-number-inner">
                                            <h4 class="inv-title-1">Invoice From</h4>
                                            <h2 class="name mb-10">24EnglishCenter</h2>
                                            <p class="invo-addr-1">
                                                24englishcenter@gmail.com <br/>
                                                Denpasar, Bali 80343 <br/>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-center">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped invoice-table">
                                    <thead class="bg-active">
                                    <tr class="tr">
                                        <th>No.</th>
                                        <th class="pl0 text-start">Item Description</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="tr">
                                        <td>
                                            <div class="item-desc-1">
                                                <span>01</span>
                                            </div>
                                        </td>
                                        <td class="pl0">{{$sub['sub_course']}}</td>
                                        <td class="text-center">Rp {{number_format($sub['pricing'])}}</td>
                                        <td class="text-center">1</td>
                                        <td class="text-end">Rp {{number_format($sub['pricing'])}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="invoice-btn-section clearfix d-print-none">
                        <a href="/detail-subcourse/{{$sub['id']}}" class="btn btn-lg btn-primary">
                            <i class="fa fa-book"></i> Get My Course
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> Download Invoice
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Invoice 1 end -->

<script src="{{asset('invoice/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('invoice/assets/js/jspdf.min.js')}}"></script>
<script src="{{asset('invoice/assets/js/html2canvas.js')}}"></script>
<script src="{{asset('invoice/assets/js/app.js')}}"></script>
</body>
</html>