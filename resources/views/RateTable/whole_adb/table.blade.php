<table class="table">
        <thead>
        <tr>
            <th><!-- Empty for the left top corner of the table --></th>
            @foreach($columns as $term)
                <th scope="col">{{ $term }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $age_id => $age)
            <tr>
                <td scope="row"><strong>{{ $age_id }}</strong></td>
                @foreach($columns as $key=> $ccc)
                    <td>
                        <a href="#" class="xedit"
                           data-pk="{{isset($age[$ccc]) ? $age[$ccc][1] : 'add'}}"
                           data-age="{{$age_id ? $age_id : ''}}"
                           data-name="{{$age_id.','.$ccc.','.$selectedCompany->id.','.$selectedProduct->id}}">
                            {{isset($age[$ccc]) ? $age[$ccc][0] : '0'}}
                        </a>
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
    