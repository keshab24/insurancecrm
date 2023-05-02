<label class=" mt-5 mx-auto">Ages |</label>
<label class=" mt-5 mx-auto">Terms -></label>
<table class="table">
    <thead>
    <tr>
        <th><!-- Empty for the left top corner of the table --></th>
        @foreach($columns as $term)
            <th scope="col"><strong>{{ $term }}</strong></th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($rows as $age_id => $age)
        <tr>
            <td scope="row"><strong>{{ $age_id }}</strong></td>
            @foreach($columns as $key=> $ccc)
                <td>
                        {{isset($age[$ccc]) ? $age[$ccc][0] : '0'}}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
