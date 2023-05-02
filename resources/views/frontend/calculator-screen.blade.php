@extends('frontend.layouts.app')

@section('css')
    <style>
.proposer{
  display:none !important;
}
.d-none{
  display: none !important;
}
    </style>
@endsection
@section('script')

<script type="text/javascript">
 $(document).ready(function () {
  $('.search-select').select2();

$('#ageForm').on('submit',function(e){
    e.preventDefault();

    let day = $('#day').val();
    let month = $('#month').val();
    let year = $('#year').val();
   

    $.ajax({
      url: "/age",
      type:"POST",
      data:{
        "_token": "{{ csrf_token() }}",
        day:day,
        month:month,
        year:year,
        
      },
      success:function(response){
        console.log(response);
      },
     });
    });
  });

$('.ftCalculate').on('change',function(){
  let productId = $(".ftCalculate:checked").val();
            $.ajax({
                 type: "GET",
                url: "{{ route('admin.get.category.feature') }}",
                dataType: 'json',
                data: {
                    'id': productId,
                },
                success: function (response) {
                  // console.log(response);
                  
                    if (response.data.length > 0) {
                        let html = '';
                        for (let j = 0; j < response.data.length; j++) {

                            html += ' <div class="form-check">' +
                                '<input type="checkbox" name="features[]" class="form-check-input sum-cal" value="' + response.data[j].code + '">' +
                                '<label class="form-check-label text-capitalize">' + response.data[j].name + '</label>' +
                                '</div>'
                        }
                        $('#featuresTab').html(html);
                        $('#featureRow').removeClass('d-none')

                    } else {
                        $('#featureRow').addClass('d-none')
                    }
                }
            });
          });

  </script>

@endsection

@section('content')
    <section class="calculator-section">
        <div class="container">
            <div class="calculation-form">
                @include('frontend.Partials.premiumCalculatorForm')
            </div>
        </div>

    </section>
@endsection
@section('script')
 

@endsection
