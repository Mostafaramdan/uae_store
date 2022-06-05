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
                    <label for="nameAr" class="col-form-label">الاسم بالعربي :</label>
                    <input type="text" class="form-control" name="nameAr">
                </div>
                <div class="form-group">
                    <label for="nameEn" class="col-form-label">الاسم بالانجليزية :</label>
                    <input type="text" class="form-control" name="nameEn">
                </div>
                <div class="form-group">
                    <label for="orderNum" class="col-form-label">ترتيب القسم في التطبيق  :</label>
                    <input type="number" min="0" class="form-control" name="orderNum">
                </div>
                <div class="row mr-10" >
                    <div class="form-group col-md-12">
                        <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                    </div>
                    <div class="col-md-12">
                        <input type="file" id="img"   accept="image/*" hidden data-image="image">
                        <input type="hidden"  name="image"  hidden >

                        <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                        <hr/>
                    </div>
                </div>
                <div class="form-group" >
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="customCheck2" name ="offer" checked>
                        <label class="custom-control-label list-lang" ar='عرض ؟ ' en='offer ?' for="customCheck2" ></label>
                    </div>
                </div>
                <div class="offer_Info  d-none">
                    <div class="form-group ">
                        <label for="discount" class="col-form-label list-lang"ar='ادخال نسبة الخصم  %' en='enter the discount percentage %'>:</label>
                        <input type="number" class="form-control " name="discount">
                    </div>
                    <div class="form-group ">
                        <label for="start_at" class="col-form-label list-lang" ar='ادخال تاريخ البداية' en='enter the start date'> :</label>
                        <input type="date" class="form-control" name="start_at_offer">
                    </div>
                    <div class="form-group ">
                        <label for="end_at" class="col-form-label list-lang" ar='ادخال تاريخ النهاية' en='Enter the end date'> :</label>
                        <input type="date" class="form-control" name="end_at_offer">
                    </div>
                </div>
                <div class="form-group" >
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input "  id="customCheck1" name ="store">
                        <label class="custom-control-label  list-lang" ar="قسم فرعي "  en='sub category' for="customCheck1" ></label>
                    </div>
                </div>
                @if(Auth::guard("dashboard")->check())
                    <div class="store-category  d-none">
                        <div class="form-group" >
                            <label for="categories_id" class="col-form-label list-lang" ar='اختر القسم:' en='choose category'></label>
                            <select  class="form-control" name="categories_id">
                                @foreach($sub_categories as $sub_category)
                                    <option class="list-lang" ar='{{$sub_category->nameAr}}' en='{{$sub_category->nameEn}}' value="{{$sub_category->id}}"></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
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