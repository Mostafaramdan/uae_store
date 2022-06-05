<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="nameAr" class="col-form-label">الاسم بالعربي :</label>
                        <input type="text" class="form-control" name="nameAr">
                    </div>
                    <div class="form-group">
                        <label for="nameEn" class="col-form-label">الاسم بالانجليزي :</label>
                        <input type="text" class="form-control" name="nameEn">
                    </div>
                    <div class="form-group" onClick="$('.select_id').addClass('d-none')">
                        <div class="custom-control custom-checkbox">
                            <input type="radio" class="custom-control-input" value="emirate" id='emirate' name="type">
                            <label class="custom-control-label list-lang" for="emirate" ar="إمارة"  en="emirate"></label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="radio" class="custom-control-input" data-select='emirate_id_select' value="city"   id='city' name="type">
                            <label class="custom-control-label list-lang" for="city" ar="مدينة"  en="city"></label>
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="radio" class="custom-control-input" data-select='city_id_select' value="district" id='district' name="type">
                            <label class="custom-control-label list-lang" for="district" ar="منطقة"  en="district"></label>
                        </div>
                    </div>
                    <div class="form-group emirate_id_select d-none select_id"  >
                        <label for="regions_id" class="col-form-label list-lang" ar="اختر الامارة" en="choose a emirate">:</label>
                        <select  class="form-control" name="regions_id">
                            <option value="" selected disabled></option>
                            @foreach(\App\Models\regions::where('type','emirate')->get() as $emirate)
                                <option value="{{$emirate->id}}" class="list-lang" ar="{{$emirate->nameAr}}" en="{{$emirate->nameEn}}"></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group city_id_select d-none select_id"  >
                        <label for="city_id" class="col-form-label list-lang" ar="اختر المدينة" en="choose a city">:</label>
                        <select  class="form-control" name="regions_id">
                            <option value="" selected disabled></option>
                            @foreach(\App\Models\regions::where('type','city')->get() as $city)
                                <option value="{{$city->id}}" class="list-lang" ar="{{$city->nameAr}}" en="{{$city->nameEn}}"></option>
                            @endforeach
                        </select>
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