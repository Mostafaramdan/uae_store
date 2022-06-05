<option  value="" disabled selected>اختر </option>
@foreach($users as $user)
    <option  value="{{$user->id}}">{{$user->name . ' - ' . $user->phone}}</option>
@endforeach