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
                        <label for="ID_" class="col-form-label"> الباركود:</label>
                        <input type="text" class="form-control" name="ID_">
                    </div>
                    <div class="form-group">
                        <label for="nameAr" class="col-form-label"> الاسم بالعربي:</label>
                        <input type="text" class="form-control" name="nameAr">
                    </div>
                    <div class="form-group">
                        <label for="nameEn" class="col-form-label"> الاسم بالانجليزي:</label>
                        <input type="text" class="form-control" name="nameEn">
                    </div>
                    <div class="form-group">
                        <label for="descriptionAr" class="col-form-label"> الوصف بالعربي:</label>
                        <input type="text" class="form-control" name="descriptionAr">
                    </div>
                    <div class="form-group">
                        <label for="descriptionEn" class="col-form-label"> الوصف بالانجليزي:</label>
                        <input type="text" class="form-control" name="descriptionEn">
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-form-label">  الكمية:</label>
                        <input type="number" class="form-control" name="quantity">
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-form-label list-lang" ar='سعر البيع :' en='selling price :'></label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-form-label list-lang" ar="سعر التكلفة المنتج" en="product cost price">  :</label>
                        <input type="number" class="form-control " name="product_price">
                    </div>
                    <div class="form-group p-1 border border-primary prices-records">
                        <div class="row mr-8 price-record" >
                            <div class="col-md-3 ">
                                <label for="quantity" class="col-form-label list-lang" ar='الكمية:' en='selling quantity :'></label>
                                <input type="number" class="form-control" name="quantities[]">
                            </div>
                            <div class="col-md-3 ">
                                <label for="price" class="col-form-label list-lang" ar='سعر:' en='selling price :'></label>
                                <input type="number" class="form-control" name="prices[]">
                            </div>
                            <div class="col-md-3 ">
                                <label for="images_prices" class="col-form-label list-lang" ar='الصورة:' en='image :'></label>
                                <input type="file" class="form-control" name="images_prices[]">
                            </div>
                            <div class="col-md-1 m-1">
                                <label for="plus" class="col-form-label list-lang" ar="إضافة" en="add"></label>
                                <a class="btn btn-primary add-new-price"><i class="ml-2 fas fa-plus-circle"></i></a>
                            </div>
                            <div class="col-md-1 m-1">
                                <label for="plus" class="col-form-label list-lang" ar="مسح" en="delete"></label>
                                <a style="color:white" class="btn btn-danger delete-price"><i class="ml-2 fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                    @if(Auth::guard("dashboard")->check())
                        <div class="form-group" >
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck2" name ="isFreeDelivered"  value="true">
                                <label class="custom-control-label list-lang" ar='توصيل مجانا' en='Free delivery' for="customCheck2" ></label>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="points" class="col-form-label list-lang" ar='النقاط المستحقة مقابل شراء هذا المنتج' en='Points accrued for purchasing this product'> </label>
                        <input type="number" class="form-control " name="points">
                    </div>
                    @if(Auth::guard("dashboard")->check())
                        <div class="form-group" >
                            <label for="stores_id" class="col-form-label list-lang" ar='اختر المتجر' en='choose a store'>:</label>
                            <select  class="form-control" name="stores_id">
                                <option value="" class='list-lang' ar='اختر المتجر' en='choose a store'> </option>
                                @foreach(\App\Models\stores::where("isActive",1)->where("isVerified",1)->get() as $store)
                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif    
                    <div class="form-group" >
                        <label for="categories_id" class="col-form-label list-lang" ar="اختر القسم" en="choose a category">:</label>
                        <select data-live-search="true" class="selectpicker form-control"  id="categories_id_create" name="categories_id" >
                            <option selected disabled class='list-lang' ar='اختر قسم ' en='choose category' >  
                            </option>
                            @foreach($categories as $category)
                            <option class='list-lang' ar='{{$category->nameAr}}' ar='{{$category->nameEn}}'value="{{$category->id}}"></option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name ="offer" checked>
                            <label class="custom-control-label list-lang" ar='عرض ؟ ' en='offer ?' for="customCheck1" ></label>
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
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="image" class='list-lang' ar='اختر الصور' en='choose photos'> </label>
                            <input type="file" id="image" name="image[]" accept="image/*" multiple max="15">
                        </div>
                    </div>
                    <div class="form-group d-none" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3" name ="haveFeatures" >
                            <label class="custom-control-label list-lang" for="customCheck3" ar='إضافات' en='additions' ></label>
                        </div>
                    </div>
                    <div class="row mr-8 features" >
                        <div class="col-md-12 feature">
                              <label for="nameAr" class="col-form-label list-lang" ar=' الاسم بالعربي' en='name in arabic '> :</label>
                              <input type="test" class="form-control" name="nameArFeat[]">
                              
                              <label for="nameAr" class="col-form-label list-lang" ar=' الاسم بالانجليزية' en='name in english'> </label>
                              <input type="test" class="form-control" name="nameEnFeat[]">
                              
                              <label for="nameAr" class="col-form-label list-lang" ar=' السعر' en='price'>  :</label>
                              <input type="number" class="form-control" name="priceFeat[]">
                            
                              <label for="imageFeat" class="col-form-label list-lang" ar='ادخال صورة' en=' insert photo'>  :</label>
                              <input type="file" class="form-control" name="imageFeat[]">
                              <br>
                              <a class="btn btn-danger btn-block mr-auto deleteFeature"> <i class="fas fa-trash"></i></a> 
                             <br>
                            <hr/>
                        </div>
                        <div class="form-group col-md-12 beforeFeature">
                            <a class="btn btn-success addNewFeatures list-lang" ar='إضافة ميزات جديدة' en='adding new features'>  <i class="fas fa-plus"></i></a>
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
@push('script')
    <script>
        $("body").on("click",".add-new-price",function(e){
            e.preventDefault();
            let price = $('.price-record:first').clone();
            price.find('.add-new-price').remove();
            price.find('label').remove();
            
            $('.prices-records').append(price);
        });
        $("body").on("click", '.delete-price', function(e) {
            e.preventDefault();
            if($('.price-record').length > 1)
                $(this).closest('.price-record').remove();
        });
    </script>
@endpush