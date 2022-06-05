<thead class="thead-dark">
<tr>
<th scope="col" class="list-lang" ar="الوصف"en=" description"> </th>
<th scope="col"  class="list-lang" ar="عدد النقاط"en=" number of points"></th>
<th scope="col"  class="list-lang" ar="التفعيل"en=" activation"></th>
<th scope="col"></th>
</tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td  class="list-lang" ar='{{Str::words($record->descriptionAr,5,"..")}}'en='{{Str::words($record->descriptionEn,5,"..")}}' ></td>
        <td>{{$record->numberOfPoints}}</td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isActive) checked @endif data-type="isActive">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
