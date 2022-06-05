@foreach($users as $user)
    <option  value="{{$user->id}}">{{$user->name . ' - ' . $user->phone}}</option>
@endforeach