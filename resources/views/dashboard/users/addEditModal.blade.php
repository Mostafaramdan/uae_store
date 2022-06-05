<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">أضافة مستخدم جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="name" class="col-form-label">الإسم:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label">البريد الإلكتروني :</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label">رقم التليفون:</label>
                        <input  class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">password:</label>
                        <input type="text" class="form-control" name="password">
                    </div>
                    <div class="form-group d-none">
                        <label for="balance" class="col-form-label list-lang " ar='إضافة رصيد ' en='balance'> الرصيد :</label>
                        <input type="text" class="form-control" name="balance">
                    </div>
                    <div class="form-group ">
                        <label for="cashback" class="col-form-label list-lang " ar='إضافة كاش باك ' en='cashback'> الرصيد :</label>
                        <input type="text" class="form-control" name="cashback">
                    </div>

                    <!-- <div class="form-group" >
                        <label for="regionId" class="col-form-label" ar='اختر المدينة'en=''>:</label>
                        <select  class="form-control" name="vehicleId">
                            @foreach(\App\Models\vehicles::where('isActive',1)->get() as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->nameAr}}</option>
                            @endforeach
                        </select>
                    </div> -->
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                            <input type="file" id="img" accept="image/*" hidden data-image="imag">
                            <input type="hidden"  name="imag"  hidden >
                            <img id="imag" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                            <hr/>
                        </div>
                    </div>
                    <!-- <div class="custom-control custom-checkbox mb-4">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="checkType">
                        <label class="custom-control-label" for="customCheck1" >إضافة دور</label>
                    </div>
                    <div class="row role d-none" >
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="type" class="col-form-label"> الدور :</label>
                                <select  class="form-control" name="type">
                                    <option value="redAdmin">أدمن أحمر</option>
                                    <option value="silverAdmin">أدمن فضي</option>
                                    <option value="goldenAdmin">أدمن ذهبي</option>
                                    <option value="superMaster">سوبر ماستر</option>
                                    <option value="chatMaster">شات ماستر</option>
                                    <option value="superAdmin">سوبر أدمن</option>
                                </select>     
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_at" class="col-form-label">تاريخ البداية :</label>
                                <input type="date" class="form-control" name="start_at">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_at" class="col-form-label">تاريخ النهاية :</label>
                                <input type="date" class="form-control" name="end_at">
                            </div>
                        </div>
                    </div> -->
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">إلغاء</button>
                <button type="button"  class="btn btn-success submit" id="submit">حفظ</button>
            </div>

        </div>
    </div>
</div>
</div>