<thead class="thead-dark">
    <tr>
        <th scope="col " class="name">الاسم</th>
        <th scope="col " class="phone">التليفون</th>
        <th scope="col " class="email">البريد الالكتروني </th>
        <th scope="col " class="list-lang" ar="الرصيد الحالي" en='current balance'>الرصيد الحالي  </th>
        <th scope="col " class="balance-details">تفاصيل الرصيد </th>

        <th scope="col " class="created_at">وقت الإنشاء</th>
        <th scope="col " class="activation">التفعيل</th>
        <th scope="col " class="acceptable">الموافقة</th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{$record->name}}</td>
        <td>{{$record->phone}}</td>
        <td>{{$record->email}}</td>
        <td>{{$record->balance}}</td>
        <td>
            <button class="btn-sm btn btn-success balanceInfo mb-1" data-toggle="modal" data-target="#balaneInfo-modal"><i class="fas fa-dollar-sign"></i></button>
        </td> 
        <td>{{Carbon\Carbon::parse($record->createdAt)->toDayDateTimeString()}}</td>
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
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isApproved) checked @endif data-type="isApproved">
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
