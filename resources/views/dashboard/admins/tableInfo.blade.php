<thead class="thead-dark">
<tr>
<th scope="col" class="list-lang" ar="الاسم " en ="name">الاسم</th>
<th scope="col" class="list-lang" ar="البريد الاليكتروني " en ="email">البريد الالكتروني </th>
<th scope="col" class="list-lang" ar="سوبر أدمن ؟" en ="super admin ?">سوبر أدمن </th>
<th scope="col" class="list-lang" ar="وقت الإنشاء " en ="Creation time">وقت الإنشاء</th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->name}}</td>
        <td>{{$record->email}}</td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isSuperAdmin) checked @endif data-type="isSuperAdmin">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            @if(Auth::guard('dashboard')->user()->id != $record->id ) 
                <button class="btn-sm btn btn-danger mb-1 delete"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
            @endif
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
