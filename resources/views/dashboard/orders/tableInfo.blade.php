<thead class="thead-dark">
      <tr>
            <th scope="col " class="list-lang" ar="كود الطلب" en=" order code"></th>
            <th scope="col"  class="list-lang" ar="السائق" en=" driver"> </th>
            <th scope="col"  class="list-lang" ar="الحالة" en=" status"> </th>
            <th scope="col" class="list-lang" ar="وقت الإنشاء" en=" creation time"> </th>
            <th scope="col" class="list-lang" ar="تفاصيل الطلب" en=" details"> </th>
            <th scope="col"></th>
      </tr>
</thead>
<tbody>
      @foreach($records as $record)
          <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
            <td>{{$record->code}}</td>
            <td>{{$record->driver->name??""}}</td>
            <td class="list-lang" ar="{{$record->statusAr}}" en="{{$record->status}}"></td>
            <td>{{Carbon\Carbon::parse($record->createdAt)->toDayDateTimeString()}}</td>
            <td>   
                 <button class="btn-sm btn btn-success orderInfo mb-1" data-toggle="modal" data-target="#orderInfo-modal"><i class="fas fa-shopping-cart"></i></button>
            </td> 
            <td>
                  <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
                  <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
                  <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
            </td>
          </tr>
      @endforeach
</tbody>