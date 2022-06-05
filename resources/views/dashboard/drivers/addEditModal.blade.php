<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
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
                        <label for="name" class="col-form-label ">الاسم:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label ">البريد الالكتروني :</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-form-label ">رقم التليفون:</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="balance" class="col-form-label list-lang" ar='الرصيد' en='balance'> :</label>
                        <input type="number" class="form-control" name="balance" >
                    </div>
                    <div class="form-group ">
                        <label for="cashback" class="col-form-label list-lang " ar='إضافة كاش باك ' en='cashback'> الرصيد :</label>
                        <input type="text" class="form-control" name="cashback">
                    </div>

                    <!-- <div class="form-group">
                        <label for="commision" class="col-form-label list-lang" ar='العمولة %' en='commision'> :</label>
                        <input type="number" class="form-control" name="commision" min='0'>
                    </div> -->
                    <div class="form-group">
                        <label for="fess" class="col-form-label list-lang" ar='الرسوم % ' en='fees %'>:</label>
                        <input type="number" class="form-control" name="fees" min='0'>
                    </div>
                    <div class="form-group">
                        <label for="model" class="col-form-label list-lang" ar='طراز السيارة' en='model'> :</label>
                        <input type="text" class="form-control" name="model">
                    </div>
                    <div class="form-group">
                        <label for="licenseNumber" class="col-form-label list-lang" ar='رقم الرخصة' en='license number'>  :</label>
                        <input type="text" class="form-control" name="licenseNumber">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label ">الرقم السري:</label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group" >
                        <label for="vehicles_id" class="col-form-label list-lang" ar=' اختر الشاحنة' en='choose a vegicle'>:</label>
                        <select  class="form-control" name="vehicles_id">
                            @foreach(\App\Models\vehicles::where('isActive',1)->get() as $vehicle)
                                <option value="{{$vehicle->id}}"class='list-lang' ar='{{$vehicle->nameAr}}' en='{{$vehicle->nameEn}}'></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="delivery_methods_id" class="col-form-label list-lang" ar='اختر طريقة التوصيل ' en='choose delivery method'>اختر طريقة التوصيل:</label>
                        <select  class="form-control" name="delivery_methods_id">
                            @foreach(\App\Models\delivery_methods::all() as $delivery_method)
                                <option  class='list-lang'value="{{$delivery_method->id}}" ar='{{$delivery_method->nameAr}}' en='{{$delivery_method->nameEn}}'></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary list-lang" onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();" 
                                ar=' اختر صورة السائق الشخصية  <i class="fas fa-image"></i>' en="Choose the driver's profile picture  <i class='fas fa-image'></i>"
                            ></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file"  name="image" accept="image/*" hidden data-image="image" >
                          <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary list-lang" onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();" 
                                ar=' اختر صورة البطاقة الشخصية  <i class="fas fa-image"></i>' en="Choose an ID picture  <i class='fas fa-image'></i>"
                            ></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file"  name="IdPhoto" accept="image/*" hidden data-image="IdPhoto" >
                          <img id="IdPhoto" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary list-lang" onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();" 
                                ar=' اختر صورة السيارة  <i class="fas fa-image"></i>' en="Choose the car image  <i class='fas fa-image'></i>"
                            ></button>

                        </div>
                        <div class="col-md-12">
                          <input type="file"   name="carImage" accept="image/*" hidden data-image="carImage" >
                          <img id="carImage" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary list-lang" onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();" 
                                ar=' اختر صورة رخصة السائق  <i class="fas fa-image"></i>' en="Choose the driver license image  <i class='fas fa-image'></i>"
                            ></button>

                        </div>
                        <div class="col-md-12">
                          <input type="file"  name="driverLicenseImage" accept="image/*" hidden data-image="driverLicenseImage" >
                          <img id="driverLicenseImage" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
                        </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary list-lang" onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();" 
                                ar=' اختر صورة رخصة السيارة  <i class="fas fa-image"></i>' en="choose a vehicle license image  <i class='fas fa-image'></i>"
                            ></button>

                        </div>
                        <div class="col-md-12">
                          <input type="file"  name="carLicenseImage" accept="image/*" hidden data-image="carLicenseImage" >
                          <img id="carLicenseImage" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
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