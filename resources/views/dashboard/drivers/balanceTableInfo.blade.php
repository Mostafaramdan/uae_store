<thead class="thead-dark">
      <tr>
      <th scope="col" >{{\session()->get('local')=="Ar" ? 'الرصيد الحالي' : 'current balance'}} </th>
      <th scope="col" >{{\session()->get('local')=="Ar" ?'كمية' : 'quantity'}} </th>
      <th scope="col" >{{\session()->get('local')=="Ar" ? 'تاريخ' : 'date'}} </th>

      </tr>
</thead>
<tbody>
      <tr>
            <td class="text-primary" style="font-weight:bold;font-size:50px">{{$currentBalance}}</td>
            <td></td>
            <td></td>
      <tr >
      @foreach($records as $record)
            <tr >
                  <td></td>
                  <td>{{$record->balance}}</td>
                  <td>{{$record->createdAt}}</td>
            <tr >
      @endforeach
</tbody>