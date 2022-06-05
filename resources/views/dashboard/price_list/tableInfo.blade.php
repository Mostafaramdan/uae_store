<thead class="thead-dark">
    <tr>
        <th scope="col" class="list-lang" ar="بداية المسافة ؟" en="start distance"> </th>
        <th scope="col" class="list-lang" ar="نهاية المسافة ؟" en="end distance"> </th>
        <th scope="col" class="list-lang" ar="السعر" en="end distance"> </th>
        <th scope="col"  class="list-lang" ar="وقت الإنشاء"en=" creation time"></th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->startKm}}</td>
        <td>{{$record->endKm}}</td>
        <td>{{$record->price}}</td>
        <td>{{Carbon\Carbon::parse($record->createdAt)->toDayDateTimeString()}}</td>
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <!-- <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button> -->
        </td>
    </tr>
@endforeach
</tbody>
