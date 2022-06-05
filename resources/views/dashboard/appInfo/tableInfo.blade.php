<thead class="thead-dark">
<tr>
<th scope="col"> </th>
<th scope="col"># </th>
</tr>
</thead>
<tbody>
    <tr >
        <td class="list-lang" ar="ارقام التليفونات"  en ="phones">أرقام التليفون</td>
        <td>@foreach($record->phones as $phone ) {{ $phone->phone}} <br> @endforeach</td>
    </tr>
    <tr >
        <td  class="list-lang" ar="الايميلات"  en ="emails" > الإيميلات</td>
        <td>@foreach($record->emails as $email ) {{ $email->email}} <br> @endforeach</td>
    </tr>
    <tr >
        <td  class="list-lang" ar="رسالة الترحيب"  en ="welcome message in arabic" >رسالة الترحيب بالعربي </td>
        <td>{{$record->welcomeAr}}</td>
    </tr>
    <tr >
        <td  class="list-lang" ar="رسالة الترحيب بالانجليزي  "  en ="welcome message in english" > رسالة الترحيب بالإنجليزية </td>
        <td>{{$record->welcomeEn}}</td>
    </tr>
    <tr >
        <td  class="list-lang" ar="عن التطبيق بالعربي"  en ="about application in arabic" >  عن التطبيق بالعربي</td>
        <td>{{$record->aboutAr}}</td>
    </tr>
    <tr >
        <td  class="list-lang" ar="   عن التطبيق بالانجليزي"  en ="about application in english"> عن التطبيق بالإنجليزية</td>
        <td>{{$record->aboutEn}}</td>
    </tr>
    <tr >
        <td class="list-lang" ar="   سياسة الاستخدام  بالعربي"  en =" policy terms in arabic" >  سياسة الإستخدام بالعربي</td>
        <td>{{$record->policyAr}}</td>
    </tr>
    <tr >
        <td class="list-lang" ar="   سياسة الاستخدام  بالانجليزي"  en =" policy terms in english">  سياسة الإستخدام بالإنجليزية</td>
        <td>{{$record->policyEn}}</td>
    </tr>
    <!-- <tr >
        <td>الأمان بالعربي</td>
        <td>{{$record->privacyAr}}</td>
    </tr> -->
    <!-- <tr >
        <td>الأمان بالإنجليزية</td>
        <td>{{$record->privacyEn}}</td>
    </tr>
    <tr >
        <td>رسوم السائقين</td>
        <td>{{$record->driverFees}} %</td>
    </tr> -->
    <tr >
        <td class="list-lang" ar=" رسوم المتاجر "  en =" store fees" >رسوم المتاجر</td>
        <td>{{$record->storeFees}} %</td>
    </tr>
    <tr >
        <td class="list-lang" ar=" النطاق بالكيلو ميتر  "  en ="   the range in Km" >النطاق </td>
        <td>{{$record->radius}}</td>
    </tr>
    <tr >
        <td class="list-lang" ar="  سعر التوصيل لكل 20 كليومتر ؟ "  en =" Delivery price per 20 km?" > سعر التوصيل لكل 20 كليومتر ؟   </td>
        <td>{{$record->pricePer20Km}}  ر.عُ</td>
    </tr>
    <tr >
        <td class="list-lang" ar=" سعر النقطة "  en =" Point price" > سعر النقطة </td>
        <td>{{$record->priceOfPoint}}  ر.عُ</td>
    </tr>
    <tr >
        <td class="list-lang" ar=" أقل عدد نقاط يمكن إستبدالها "  en =" Minimum number of points that can be redeemed"></td>
        <td>{{$record->maxStorePoints}} </td>
    </tr>
</tbody>
