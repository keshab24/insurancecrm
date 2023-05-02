@php
$amountFormatter = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
$amountFormatter->setSymbol(NumberFormatter::CURRENCY_SYMBOL, '');
@endphp



<div class="col-sm-9">
    <div class="compare-search-sort">
        <p class="left-sort">Term Life: <a class="" href="#">{{count($products)}} Plans match your search</a></p>
        {{-- <p class="right-sort">
            <i class="fa fa-search" aria-hidden="true"></i>
            Sort by Relevance
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
        </p> --}}
        <div class="navbar-nav right-sort">
            <div class="nav-item dropdown">
                <i style="margin-right: 30px;" class="fa fa-search" aria-hidden="true"></i>
                <a class="nav-link dropdown-toggle fa fa-filter filter-opt" id="navbarDropdown"
                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sort by Relevance <span class="fa fa-chevron-down" aria-hidden="true"></span>
                </a>
                <div class="dropdown-menu filter-opt-list" aria-labelledby="navbarDropdown">
                    <ul style="list-style: none;padding: 5px;">
                        <li>
                            <a class="dropdown-item" href="#">Premium: <span class="text-lght">High to
                                    Low</span>
                                <i class="fa fa-exchange filter-icn" aria-hidden="true"></i></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Premium paying term: <span
                                    class="text-lght">High to Low</span> </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Total Bonus: <span class="text-lght">High to
                                    Low</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Term: <span class="text-lght">High to
                                    Low</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Expected Return: <span class="text-lght">High
                                    to Low</span></a>
                        </li>
                        <hr style="    margin-top: 5px;margin-bottom: 5px;">
                        <li>
                            <a class="dropdown-item" href="#"><span class="text-lght">Default</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="compare-plans">
        <table class="table">
            <thead class="thead-dark">
                <tr class="heading-dark">
                    <th scope="col">Insurer & Plan</th>
                    <th scope="col">Premium</th>
                    <th scope="col">Details</th>
                    <th scope="col">Benefits</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
              
                 <tr class="content-compare">
                    <td style="width: 20%" class="compare-parts line-rht-cmp" scope="row">
                        <p class="cont-plan"> {{$product->company->name}}</p>
                        <img src="{{$product->company->logo}}">
                        <p class="prod-name">{{$product->name}}</p>
                    </td>
                    <td style="width: 20%" class="prem-box line-rht-cmp">
                        <p class="sum-title">Sum Assured</p>
                        <p class="sum-title-val">Rs. {{$amountFormatter->format($selectedSumAssured)}}</p>
                        <span class="gap-0"></span>
                        <p class="sum-title">Premium Amount</p>
                        <p class="prem-val" id="pamount">Rs. {{$amountFormatter->format($product->totalPremiumAmount)}}</p>
                        <span class="gap-0"></span>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="lower-title">Age</p>
                                <p class="lower-title-val">{{$selectedAge}}Y</p>
                            </div>
                            <div class="col-sm-3">
                                <p class="lower-title">Term</p>
                                <p class="lower-title-val"> {{$selectedTerm}}Y</p>
                            </div>
                            <div class="col-sm-6">
                                <p class="lower-title">Premium paying Term</p>
                                <p class="lower-title-val"> {{$selectedMop}}</p>
                            </div>
                        </div>
                    </td>
                    <td style="width: 20%" class="details-box line-rht-cmp">
                        <p class="details-title">Total Bonus</p>
                        <p class="details-val2">Rs. {{$amountFormatter->format($product->bonus ?? '0')}}</p>
                        <span class="gap-0"></span>
                        <p class="details-title2">Expected Return</p>
                        <p class="details-val2" id="return"><input type="hidden" value=" {{$product->return}}" name="bonus">Rs. {{$amountFormatter->format($product->return)}}</p>
                        <span class="gap-0"></span>
                        <p class="details-title2">Net Gain</p>
                        <p class="details-val2">Rs. {{$amountFormatter->format(($product->return) - ($product->totalPremiumAmount))}}</p>
                    </td>
                    
                    <td style="width: 20%" class="benefit-box line-rht-cmp">
                        <ul class="benefit-lists">
                            
                           
                            @if(isset($selectedfeatures))
                            @foreach($selectedfeatures as $selfeature)
                            <li> {{featureName($selfeature)}}
                              {{--  @if(in_array($feature->id ,$product->features->pluck('id')->toArray()))--}}
                              @if(in_array(featureName($selfeature) , $product->features->pluck('name')->toArray()))
                                <i class="fa fa-check-square-o to-right" aria-hidden="true"></i>
                                @else
                                <i class="fa fa-times to-right cross-fa" aria-hidden="true"></i>
                                @endif
                            </li>
                            @endforeach
                            @endif
                        </ul>
                         {{--   <li> Permanent Total Disability
                                <i class="fa fa-times to-right cross-fa" aria-hidden="true"></i>
                            </li>
                            <li> Premium Waiver Benefit
                                <i class="fa fa-check-square-o to-right" aria-hidden="true"></i>
                            </li>
                            <li> Critical Illness
                                <i class="fa fa-check-square-o to-right" aria-hidden="true"></i>
                            </li>
                            <li> Child Risk Coverage (CRC)
                                <i class="fa fa-check-square-o to-right" aria-hidden="true"></i>
                            </li>
                            <li> Term Rider
                          
                                <i class="fa fa-check-square-o to-right" aria-hidden="true"></i>
                            </li>--}}
                        {{-- </ul> --}}
                       
                    </td>

                    <td style="width: 20%">
                        <div class="select-plan-box">
                            <form action="{{route('front.confirm')}}" method="POST" enctype="multipart/form">
                                @csrf
                                <input type="hidden" value="{{$selectedAge}}" name="age">
                                <input type="hidden" value="{{$selectedTerm}}" name="term">
                            <input type="hidden" name="category" value="{{$selectedCategory}}">
                            <input type="hidden" name="features[]" value="{{json_encode($selectedfeatures)}}">
                            <input type="hidden" name="sum" value="{{$selectedSumAssured}}">
                            <input type="hidden" name="product" value="{{$product->id}}">
                            <input type="hidden" value=" {{$selectedMop}}" name="mop">
                            <button type="submit" class="btn btn-primary select-plan">Select Plan</button>
                            </form>
                        </div>
                    </td>
                    </tr>
                   
                    <tr class="spacer">
                        <td></td>
                    </tr>

                    @endforeach 
            </tbody>
        </table>
    </div>
</div>