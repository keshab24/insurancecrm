@if(Request::is('/'))
    <style>
        .side-calc select, .side-calc input {
            margin: 1px !important;
        }

        .sidecalc-btn {
            padding: 1px !important;
        }

        .my-prem-calc {
            width: 500px !important;
        }

        span.form-control.radio-select-box.sidecalc-btn.text-black.age-title {
            display: none;
        }

        .responsive-hide {
            display: none !important;
        }

        .responsive-show {
            display: block !important;
        }

        .calculate-input {
            padding: 15px 5px !important;
        }

        .subBtn {
            left: -25px !important;
            padding: 0 10px !important;
        }

        .addBtn {
            right: -26px !important;
            padding: 0 8px !important;
        }

        .responsive-full-width-box-responsive {
            width: 100% !important;
        }

        @media only screen and (max-width: 768px) {
            .modal-dialog.my-prem-calc {
                width: 100% !important;
            }
        }
    </style>
@endif

<a href="#" class="float" title="Calcualate Policy" data-toggle="modal" data-target="#CalculateBox">
    <i class="fa fa-calculator my-float-btn"></i>
</a>
<a href="#" class="float float-btn" title="Request Callback" data-toggle="modal" data-target="#expertTalk">
    <i class="fa fa-phone my-float"></i>
</a>
<!-- Modal -->
<div class="modal right fade" id="CalculateBox" tabindex="-1" role="dialog" aria-labelledby="CalculateBox">
    <div class="modal-dialog my-prem-calc" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="talkToExpert">Premium Calculation</h4>
            </div>

            <div class="modal-body">
                @include('frontend.Partials.premiumCalculatorForm')
            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
<!-- Modal -->
<div class="modal right fade" id="expertTalk" tabindex="-1" role="dialog" aria-labelledby="talkToExpert">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="talkToExpert">Talk to an Expert Now</h4>
            </div>

            <div class="modal-body">
                @if (session()->has('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
                <form class="expert-talk" action="{{route('contact.message')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="phoneNumberInput text-grey">Phone Number</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" pattern="[0-9]{1}[0-9]{9}" name="phone" id="phone"
                               value="{{ old('phone') }}" placeholder="+977 |" required>
                        @error('phone')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="Name">Full Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="full_name"
                               value="{{ old('name') }}" placeholder="e.g. Radha Krisna" required>
                        @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email"
                               value="{{ old('email') }}" placeholder="e.g. radha.krisha@email.com" required>
                        @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted d-none">We'll never share your email with anyone
                            else.</small>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" name="message" id="message"
                                  rows="5" placeholder="Type your message here.">{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">Request Call back</button>
                    </div>
                </form>
            </div>

        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->
