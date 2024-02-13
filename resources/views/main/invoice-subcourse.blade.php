@extends('layout.master-main')
@section('content')

<!-- Page Header Start -->
<div class="container-fluid page-header py-6 my-6 mt-0 wow">
    <div class="container text-center">
        <h1 class="display-4 text-white animated slideInDown mb-4">DETAIL ORDER</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="text-white" href="#">Sub Course</a></li>
                <li class="breadcrumb-item text-primary active" aria-current="page">Detail Order</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Courses Start -->
<div class="container-xxl py-6" style="padding: 4px">
    <div class="container">
        <div class="row g-5">
            <h1 class="display-6" style="margin-bottom: -19px">COMPLETE PAYMENT</h1>
            <form method="POST" action="/user-pay-subcourse/{{$detailSub['id']}}">
                @csrf
                <div class="mb-3">
                  <label for="exampleInputSubCourseName" class="form-label">Sub Course Name</label>
                  <input type="text" class="form-control" name="sub_course" value="{{$detailSub['sub_course']}}" id="exampleInputSubCourseName" aria-describedby="emailHelp" readonly>
                </div>
                <div class="mb-3">
                  <label for="exampleInputPrice" class="form-label">Price</label>
                  <input type="text" class="form-control" name="pricing" value="{{number_format($detailSub['pricing'])}}" id="exampleInputPrice" readonly>
                </div>
                <input type="hidden" class="form-control" name="id_user" value="{{$dataUser['id']}}" id="exampleInputEmail" readonly>
                <button type="button" class="btn btn-primary" id="pay-button">Pay Now</button>
              </form>
        </div>
    </div>
</div>
<!-- Courses End -->

<script type="text/javascript">
    // For example trigger on button clicked, or any time you need
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
      // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token.
      // Also, use the embedId that you defined in the div above, here.
      window.snap.pay('{{$snapToken}}', {
        onSuccess: function (result) {
          /* You may add your own implementation here */
          window.location.href = '/user-invoice-subcourse/{{$detailSub['id']}}/{{$makeInvoice['id']}}'
        //   alert("payment success!"); console.log(result);
        },
        onPending: function (result) {
          /* You may add your own implementation here */
          alert("wating your payment!"); console.log(result);
        },
        onError: function (result) {
          /* You may add your own implementation here */
          alert("payment failed!"); console.log(result);
        },
        onClose: function () {
          /* You may add your own implementation here */
          alert('you closed the popup without finishing the payment');
        }
      });
    });
  </script>

@endsection
