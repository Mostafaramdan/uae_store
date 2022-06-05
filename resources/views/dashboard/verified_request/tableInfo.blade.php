<thead class="thead-dark">
<tr>
<th scope="col">الاسم</th>
<th scope="col">التليفون</th>
<th scope="col">البريد الإلكتروني</th>
<th scope="col">وقت الإنشاء</th>
<th scope="col">المواققة</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->users->name}}</td>
        <td>{{$record->users->phone}}</td>
        <td>{{$record->users->email}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->is_approve) checked @endif data-type="is_approve">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
        </td>
        <td>
          <button class="btn-sm btn btn-danger"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-primary get-record" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
