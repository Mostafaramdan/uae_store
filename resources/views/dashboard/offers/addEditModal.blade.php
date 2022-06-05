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
                        <label for="discount" class="col-form-label list-lang" ar="نسبة الخصم" en="discount percentage">  :</label>
                        <input type="number" class="form-control" name="discount">
                    </div>
                    <div class="form-group ">
                        <label for="action" class="col-form-label list-lang" ar="أدخل نوع العرض" en="Enter Offer type">  :</label>
                        <select  class="form-control" name="action">
                            <option value class="list-lang" ar="إختر اختر النوع" en="Choose the offer type">  </option>
                            <option class="list-lang" ar="منتج" en="product"  value="products"></option>
                            <!-- <option class="list-lang" ar=" قسم " en=" category" value="categories"></option>
                            <option  class="list-lang" ar="منطقة" en="district" value="regions">   </option> -->
                        </select>
                    </div>
                    <div class="action">
                        <div class="form-group  products" >
                            <label for="products_id" class="col-form-label list-lang" ar="أدخل المنتج" en="enter a product">  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="products" data-col="nameAr" placeholder="إبحث عن منتج">
                            <select  class="form-control" name="products_id">
                                @foreach($products as $product)
                                    <option class="list-lang" ar="{{$product->nameAr}}" en="{{$product->nameEr}}" value="{{$product->id}}">{{$product->nameAr}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none regions" >
                            <label for="regions_id" class="col-form-label list-lang" ar="أدخل المنطقة" en="enter the region" >  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="regions" data-col="name"  placeholder="search">
                            <select  class="form-control" name="regions_id">
                                @foreach($regions as $region)
                                    <option value="{{$region->id}}">{{$region->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none categories" >
                            <label for="categories_id" class="col-form-label list-lang" ar="أدخل القسم" en="enter the category">  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="categories" data-col="nameAr" placeholder="search">
                            <select  class="form-control" name="categories_id">
                                @foreach($categories as $category)
                                    <option class="list-lang" ar="{{$category->nameAr}}" en="{{$category->nameEr}}" value="{{$category->id}}">{{$category->nameAr}} </option>
                                @endforeach
                            </select>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <label for="startAt" class="col-form-label list-lang" ar="تاريخ بداية العرض" en="offer start date" >  :</label>
                        <input type="date" class="form-control" name="startAt">
                    </div>
                    <div class="form-group">
                        <label for="endAt" class="col-form-label list-lang"  ar="تاريخ إنتهاء العرض" en="offer expiry date">  :</label>
                        <input type="date" class="form-control" name="endAt">
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