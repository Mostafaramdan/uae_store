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
                        <label for="titleAr" class="col-form-label list-lang" ar="العنوان بالعربي" en="arabic title">  :</label>
                        <input type="text" class="form-control" name="titleAr">
                    </div>
                    <div class="form-group">
                        <label for="titleEn" class="col-form-label list-lang"  ar="العنوان بالإنجليزية" en="english title"> :</label>
                        <input type="text" class="form-control" name="titleEn">
                    </div>
                    <div class="form-group ">
                        <label for="screen" class="col-form-label list-lang" ar="أدخل مكان ظهور الاعلانات في التطبيق" en="Enter where ads appear in the app">  :</label>
                        <select  class="form-control" name="screen">
                            <option value="welcome" class="list-lang" ar="الشاشة الرئيسية" en="main screen"></option>
                            <option value="offer" class=" list-lang" ar="شاشة العروض " en="screen offers"> </option>
                            <option value="categories" class=" list-lang" ar="شاشة الاقسام الرئيسية" en="Home screen"> </option>
                            <option value="stores"class=" list-lang" ar="شاشة المتجر" en="store screen">  </option>
                        </select>
                    </div>
                    <div class="screen">
                        <div class="form-group d-none stores" >
                            <label for="stores_id" class="col-form-label list-lang" ar="أدخل المتجر" en="enter the store">  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="stores" data-col="name" placeholder="search">
                            <select  class="form-control" name="stores_id">
                                @foreach($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none categories" >
                            <label for="categories_id" class="col-form-label list-lang">أدخل القسم  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="categories" data-col="nameAr"  placeholder="search">
                            <select  class="form-control" name="categories_id">
                                @foreach($categories as $category)
                                    <option class="list-lang" ar="{{$category->nameAr}}" en="{{$category->nameEr}}" value="{{$category->id}}">{{$category->nameAr}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label for="action" class="col-form-label list-lang" ar="أدخل مكان توجيه الاعلانات في التطبيق" en="Enter where ads are directed in the app">  :</label>
                        <select  class="form-control" name="action">
                            <option value class="list-lang" ar="إختر مكان التوجيه لهذا الإعلان" en="Choose a redirect location for this ad">  </option>
                            <option class="list-lang" ar="توجيه إلي مصدر خارجي" en="Directed to an external source" value="link"></option>
                            <option class="list-lang" ar="توجيه إلي قسم فرعي" en="Direct to a sub category" value="categories"></option>
                            <option  class="list-lang" ar="توجيه إلي متجر" en="Direct me to a store" value="stores">   </option>
                            <option class="list-lang" ar="توجيه إلي منتج" en="Direct me to a product"  value="products"></option>
                        </select>
                    </div>
                    <div class="action">
                        <div class="form-group d-none link" >
                            <label for="link" class="col-form-label list-lang" ar="أدخل الرابط الاإلكتروني" en="enter the URL">  :</label>
                            <input type="text" class="form-control" name="link"  >
                        </div>
                        <div class="form-group d-none stores" >
                            <label for="stores_id" class="col-form-label list-lang" ar="أدخل المتجر" en="enter the store" >  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="stores" data-col="name"  placeholder="search">
                            <select  class="form-control" name="action_stores_id">
                                @foreach($stores as $store)
                                    <option value="{{$store->id}}">{{$store->name}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none categories" >
                            <label for="categories_id" class="col-form-label list-lang" ar="أدخل القسم" en="enter the category">  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="categories" data-col="nameAr" placeholder="search">
                            <select  class="form-control" name="action_categories_id">
                                @foreach($categories as $category)
                                    <option class="list-lang" ar="{{$category->nameAr}}" en="{{$category->nameEr}}" value="{{$category->id}}">{{$category->nameAr}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group d-none products" >
                            <label for="products_id" class="col-form-label list-lang" ar="أدخل المنتج" en="enter a product">  :</label>
                            <input type="search" class="form-control" name="searchFor" data-model="products" data-col="nameAr" placeholder="إبحث عن منتج">
                            <select  class="form-control" name="action_products_id">
                                @foreach($products as $product)
                                    <option class="list-lang" ar="{{$product->nameAr}}" en="{{$product->nameEr}}" value="{{$product->id}}">{{$product->nameAr}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="startAt" class="col-form-label list-lang" ar="تاريخ بداية الإعلان" en="ad start date" >تاريخ بداية الإعلان  :</label>
                        <input type="date" class="form-control" name="startAt">
                    </div>
                    <div class="form-group">
                        <label for="endAt" class="col-form-label list-lang"  ar="تاريخ إنتهاء الإعلان" en="Ad expiry date">  :</label>
                        <input type="date" class="form-control" name="endAt">
                    </div>
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