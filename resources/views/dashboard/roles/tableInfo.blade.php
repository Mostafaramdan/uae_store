<thead class="thead-dark">
<tr>
<th scope="col">الاسم</th>
<th scope="col">وقت الإنشاء</th>
<th scope="col">#</th>
<th scope="col">التفعيل</th></tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->name}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <button class="btn-sm btn btn-danger"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
            <button class="btn-sm btn btn-success edit" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
            <button class="btn-sm btn btn-primary get-record" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->is_active) checked @endif>
                <span class="check-box-container d-inline-block">
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
    </tr>
@endforeach
</tbody>
