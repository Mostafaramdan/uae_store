<thead class="thead-dark">
<tr>
<th scope="col">الاسم</th>
<th scope="col">وقت الإنشاء</th>
<th scope="col">التفعيل</th>
<th scope="col">مفتوحة</th>
<th scope="col">مشاهدة الرسايل</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->name}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->is_active) checked @endif data-type="is_active">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if(!$record->is_closed) checked @endif data-type="is_closed">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>
            <button class="btn-sm btn btn-info show-messages-modal" data-toggle="modal" data-target="#show-messages"> 
                مشاهدة الرسايل 
                <i class="far fa-comment"></i>
            </button>
        </td>
        <td>
          <button class="btn-sm btn btn-danger delete"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
