<thead class="thead-dark">
    <tr>
        <th scope="col" class="list-lang" ar="الإمارة" en="Emirate"></th>
        <th scope="col" class="list-lang" ar="مدينة" en="city"></th>
        <th scope="col" class="list-lang" ar="منطقة" en="distric"></th>
        <th scope="col" class="list-lang" ar="النوع" en="type"></th>
        <th scope="col"  class="list-lang" ar="وقت الإنشاء"en=" creation time"></th>
        <th scope="col"  class="list-lang" ar="التفعيل"en=" activation"></th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td ><span class="list-lang" ar='{{$record->region->region->nameAr?? $record->region->nameAr?? $record->nameAr}}' en='{{$record->region->region->nameEn?? $record->region->nameEn?? $record->nameEn}}'></span></td>
        <td > @if($record->type == 'city' || $record->region ) <span class="list-lang" ar='{{$record->region->nameAr?? $record->nameAr}}' en='{{$record->region->En?? $record->En}}'></span>@endif</td>
        <td >@if($record->type == 'district')<span class="list-lang" ar='{{ $record->nameAr}}' en='{{$record->nameEn}}'></span>@endif</td>
        <td>{{$record->type}}</td>
        <td>{{Carbon\Carbon::parse($record->created_at)->toDayDateTimeString()}}</td>
        <td>
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isActive) checked @endif data-type="isActive">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
        </td>
        <td>
            <button class="btn-sm btn btn-danger mb-1 delete"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
            <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
