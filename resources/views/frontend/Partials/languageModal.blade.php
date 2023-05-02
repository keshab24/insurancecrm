<!-- Language Modal -->
<div class="modal fade" id="languageModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="languageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-size-control modal-lg">
        <div class="modal-content language-modal">
            <div class="modal-header header-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <h2 class="language-modal-title">Welcome to Ebeema</h2>
            <div class="modal-body text-center language-modal-body">
                <div class="row">
                    <div class="col-sm-5 language-text-left">
                        <h2>Select language</h2>
                        <h3>भाषा चयन गर्नुस</h3>
                        <a href="{{route('setLanguage',['lang'=>'en'])}}"
                            class="btn btn-lang-select @if(session()->get('locale') == 'en') fa fa-dot-circle-o @else fa fa-circle-o @endif">
                            &nbsp;English</a>
                        <a href="{{route('setLanguage',['lang'=>'np'])}}"
                            class="btn btn-lang-select @if(session()->get('locale') == 'np') fa fa-dot-circle-o @else fa fa-circle-o @endif">
                            &nbsp;नेपाली</a>
                    </div>
                    <div class="col-sm-7 language-img">
                        <img src="{{asset('frontend/img/home/language-select.png')}}">
                    </div>
                </div>
            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
