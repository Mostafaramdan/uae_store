<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="document">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" class="col-form-label">الاسم:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">البريد الالكتروني :</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">رقم التليفون:</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                   
                    <div class="form-group">
                        <label for="password" class="col-form-label">الرقم السري:</label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div class="form-group d-none">
                        <label for="balance" class="col-form-label">الرصيد :</label>
                        <input type="number" class="form-control" name="balance">
                    </div>
                    <div class="form-group">
                        <label for="regions_id" class="col-form-label">مناطق الخدمة  :</label>
                        <select multiple class="selectpicker form-control" id="number-multiple" data-container="body" data-live-search="true" title="اختر مناطق الخدمة" data-hide-disabled="true" data-actions-box="true" data-virtual-scroll="false" name='regions_ids'>
                            @foreach($regions as $region)
                                <optgroup label="{{$region->nameAr}}" >
                                    @foreach($region->regions as $reg)
                                        <option  value="{{$reg->nameAr}}">{{$reg->nameAr}}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                  

                    <div class="row">
                        <div class="col ">                        
                            <div class="form-group ">
                                <label for="deliveryTime" class="col-form-label">وقت التوصيل :</label>
                                <input type="number" class="form-control" name="deliveryTime">
                            </div>
                        </div>
                        <div class="col ">                        
                            <div class="form-group ">
                                <label for="timeType" class="col-form-label">نوع الوقت  :</label>
                                <select  class="form-control" name="timeUnit">
                                    <option value="دقائق"> دقائق</option>
                                    <option value="ساعات"> ساعات</option>
                                    <option value="ايام"> أيام</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fees" class="col-form-label">الرسوم %  :</label>
                        <input type="number" class="form-control" name="fees">
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2" name ="isDiscounted">
                            <label class="custom-control-label add-discount-code" for="customCheck2" > إضافة كود الخصم </label>
                        </div>
                    </div>
                    <div class="discount  d-none">
                        <div class="form-group ">
                            <label for="discount-percentage" class="col-form-label">ادخال نسبة الخصم  %:</label>
                            <input type="number" class="form-control" name="discount" min="1" max="99">
                        </div>
                        <div class="form-group ">
                            <label for="start_at" class="col-form-label">ادخال تاريخ البداية :</label>
                            <input type="date" class="form-control" name="start_at_offer">
                        </div>
                        <div class="form-group ">
                            <label for="end_at" class="col-form-label">ادخال تاريخ النهاية :</label>
                            <input type="date" class="form-control" name="end_at_offer">
                        </div>
                        <div class="form-group ">
                            <label for="discountCode" class="col-form-label">ادخال الكود  :</label>
                            <input type="text" class="form-control" name="discountCode">
                        </div>
                    </div>
                  
                    <hr>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                            <input type="file" id="img"  accept="image/*" hidden data-image="image" >
                            <input type="hidden"  name="image"  hidden >
                            <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                            <hr/>
                        </div>
                    </div>
                    <!-- <div class="form-group" >
                        <label for="categories_id" class="col-form-label">اختر القسم:</label>
                        <select  class="form-control" name="categories_id">
                            <option value={{null}}  > --   ---</option>
                            @foreach(\App\Models\categories::where("stores_id",null)->where("isActive",1)->get() as $category)
                                <option value="{{$category->id}}">{{$category->nameAr}}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="form-group">
                        <label for="mapUrl"> ادخل عنوان الخريطة</label>
                        <a  class="locate-the-store"href="https://www.google.com.eg/maps/search/" target="_blank">حدد مكان المتجر من هنا ثم انسخ الرابط</a>
                        <input type="text"  class="form-control" id='latitude' name="mapUrl">
                        <!--<label for="content">خطوط الطول</label>-->
                        <!--<input type="text"  class="form-control" id='logitude' name="longitude">-->
                        <label for="address"> ادخل العنوان</label>
                        <input type="text"  class="form-control" id='address' name="address">
                    </div>
                    <div class="col-md-12 d-none">
                        <div class="page-header">
                            <h5><i class="menu-icon fa fa-map-marker"></i> احداثيات خرائط جوجل</h5>
                        </div>
                        <div id="mapCanvas" style="width: 100%;height: 100%;float: left;"></div>
                        <div id="infoPanel">
                            <b>اقرب عنوان متطابق:</b>
                            <div id="address"></div>
                        </div>          
                    </div>
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div> 
                    </div>
                </form>
                <div class="alert " >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  class="btn btn-success submit" id="submit">save</button>
            </div>

        </div>
    </div>
</div>
</div>