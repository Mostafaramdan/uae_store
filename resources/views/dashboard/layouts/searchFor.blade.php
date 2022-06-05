@if(count($records))
      <option value > -  {{\App::isLocale("Ar")?"إختر":"choose"}} - </option>
      @foreach($records as $record)
        <option value="{{$record->id}}">
              @if($record->getTable()=="categories") {{$record['name'.\Session()->get('local')]}}  - ({{$record->store->name??""}}) 
              @elseif($record->getTable()=="stores") {{$record->$col}}  - ({{$record->category['name'.\Session()->get('local')]}}) 
              @elseif($record->getTable()=="products") {{$record['name'.\Session()->get('local')]}}  - ({{$record->store->name??''}}) 
              @elseif(in_array($record->getTable(),['users','drivers','stores'] )) {{$record->name .' - '. $record->phone}}) 
              @else {{$record->$col}}   @endif</option>
      @endforeach
@else 
      <option value > - {{\App::isLocale("Ar")?"لاتوجد اي بيانات":"there are not any data."}} - </option>
@endif