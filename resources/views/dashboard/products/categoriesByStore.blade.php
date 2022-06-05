@foreach($records as $category)
  <option value="{{$category->id}}">{{$category->nameAr}}</option>
@endforeach
