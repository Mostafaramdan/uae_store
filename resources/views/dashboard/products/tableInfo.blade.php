<thead class="thead-dark">
    <tr>
        <th scope="col" class='list-lang' ar='الباركود' en='bar code'></th>
        <th scope="col" class='list-lang' ar='الاسم' en='name'></th>
        <th scope="col" class='list-lang' ar='الوصف' en='description'>الوصف</th>
        <th scope="col" class='list-lang' ar='سعر التكلفة' en='product_price'></th>
        <th scope="col" class='list-lang' ar='سعر البيع' en='product price'></th>
        <th scope="col" class='list-lang' ar='الصورة' en='image'></th>
            <!-- <th scope="col"class='list-lang' ar='اسم المتجر' en='store name ' ></th>  -->
        <th scope="col"class='list-lang' ar='اسم القسم' en='category name ' ></th> 

        <!-- <th scope="col" class='list-lang' ar='النقاط' en='points'></th>
        <th scope="col" class='list-lang' ar='داخل عرض حالي' en='inside an existing offer'></th>
        <th scope="col" class='list-lang' ar='عرض مسبق' en='preset offer'> </th> -->
        <th scope="col" class='list-lang' ar='التفعيل' en='activation'></th>
    <th scope="col"></th>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td >{{$record->ID_}}</td>
        <td class='list-lang' ar="{{Str::words($record->nameAr,4,'..')}}" en="{{Str::words($record->nameEn,4,'..')}}"></td>
        <td class='list-lang' ar="{{Str::words($record->descriptionAr,4,'..')}}" en="{{Str::words($record->descriptionEn,4,'..')}}"></td>
        <td >{{$record->product_price}}</td>
        <td >{{$record->price}}</td>
        <td ><a href="{{asset($record->images->first()->image??'/uploads/products/'.$record->ID_.'.jpeg')}}" target='_blank'><img style="height:100px;width:100px" src="{{asset($record->images->first()->image??'/uploads/products/'.$record->ID_.'.jpeg')}}"></a></td>
         <!-- <td >{{$record->storeName}} </td> -->
        <td class='list-lang' ar="{{$record->category->nameAr??''}}" en="{{$record->category->nameEn??''}}"></td>

        <!-- <td>{{$record->points}}</td>
        <td>{{$record->hasOfferAr}}</td>
        <td>{{$record->hasOfferLast}}</td> -->
        <td>
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isActive) checked @endif data-type="isActive">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
        </td>
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
