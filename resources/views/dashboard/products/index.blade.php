@extends ('dashboard.layouts.master')
@section('title', 'المنتجات ')
@section ('content')
  @push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  @endpush
    <div class="content" >
    <div  id="alert">
    </div>
        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#المنتجات </h2>
          <p id="base64imagestest"></p>
        </div>
        <form class="mb-4" id="getOptions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-row">
            <div class="m-2">
              <input type="search" class="form-control" placeholder="بحث" name="search">
            </div>
            <div class="m-2">
              <select class="custom-select" name="sortBy">
                <option selected disabled>الترتيب علي حسب </option>
                <option value="nameAr">الاسم</option>
                <option value="hasOfferAr">داخل عرض حالي</option>
                <option value="hasOfferLast"> اي عروض مسبقة</option>
                <option value="points"> النقاط  </option>
                <option value="createdAt"> تاريخ الانشاء</option>
              </select>
            </div>
            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled>  نوع الترتيب </option>
                <option value="sortBy">تصاعدي</option>
                <option value="sortByDesc">تنازلي</option>
              </select>
            </div>
            <div class="m-2">
              <select data-live-search="true" class="selectpicker"  id="categories_id" name="categories_id" onChange="getRecords(1);">
                <option selected disabled class='list-lang' ar='اختر قسم' en='choose category' >  
                </option>
                @foreach($categories as $category)
                  <option class='list-lang' ar='{{$category->nameAr}}' ar='{{$category->nameEn}}'value="{{$category->id}}"></option>
                @endforeach
              </select>
            </div>
            <div class="m-2 {{ $records->count() < config('helperDashboard.itemPerPage')?'d-none':''}}">
              <select class="custom-select"  name="pages" onChange='getRecords(1)'>
                <option selected disabled>عدد البيانات في كل صفحة</option>
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
              </select>
            </div>
            <div class="m-2">
              <div class="custom-control custom-checkbox mb-4">
                <input type="checkbox" class="custom-control-input" id="customCheck4" name="isFreeDelivered">
                <label class="custom-control-label" for="customCheck4" > توصيل مجاني  </label>
              </div>
            </div>
        </form>
        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
                <a class="btn btn-success list-lang" onClick="location.href='{{route("dashboard.products.export")}}?categories_id='+$('#categories_id').val()"  ar='تصدير البيانات'  >   <i class="ml-2 fas fa-download"></i></a>
                <a class="btn btn-dark list-lang"  style="color:white" en='import data' ar='استيراد البيانات' data-toggle="modal"  data-target="#importRecords"  en='export data'>  </a>
                <a class="btn btn-info list-lang" style="color:white"  data-toggle="modal" data-target="#uploadImagesModal" ar='رفع مجموعة صور' en='upload images'> </a>
              </div>
              @include('dashboard.layouts.import&export')
              
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.products.tableInfo')
          </table>
        </div>
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
      @include('dashboard.products.viewModal')
      @include('dashboard.products.addEditModal')
      @include('dashboard.products.addEditPointsModal')
      @include('dashboard.products.uploadsImageModal')

</div>
@push('script')
<script>
  // function export(){
  //   location.href = "{{route('dashboard.products.export')}}?categories_id="+$('#categories_id').val()
  // }
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".view-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".view-modal ."+k).html(record[k])
            }
          }
            $("#customCheck2").attr('checked',record.isFreeDelivered==1?true: false);

        }
          $(".view-modal .isFreeDeliveredAr").html(record.isFreeDelivered? 'نعم':'لا');

        $(".carousel-indicators li").remove();
        $(".carousel-inner img").remove("");
        for (var i=0; i<record.images.length; i++){
          $(".carousel-indicators ").append(`
            <li data-target="#carouselExampleIndicators" data-slide-to="${i}" class="active bg-primary"></li>
          `);
          $(".carousel-inner").append(`
            <div class="carousel-item ${i==0?'active':''}">
            <img style="width:75%"
              src="${record.images[i].image}"
              class="d-block w-100">
          </div>
          `);
        }
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل ");
    $(".addEdit-new-modal input[name='id']").val($(this).parents("tr").data("id"));
    let id = $(this).parents('tr').data("id");
    $.ajax({
      url: "{{Request::segment(2)}}/getRecord/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
      },
      success: function(record) {
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
        for (var k in record) {
          if (record.hasOwnProperty(k)) {
            if(k.includes('image')  ){
              if(record[k]){  
                $('#'+k).attr('src', record[k]).attr("hidden",false);
              }else{
                $('#'+k).attr("hidden",true);
              }
            }else if(k == 'password'){
              $(".addEdit-new-modal input[name='"+k+"']").val(null);
              continue;
            }else{
              $(".addEdit-new-modal input[name='"+k+"']").val(record[k]);
              // console.log(k);
              if(k== "categories_id" || k== "stores_id"){
                $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
              }
            }
          }

        }
        if(record.prices && record.prices.length > 0){
          $(".price-record:not(:eq(0))").remove()
          for(x=0;x<record.prices.length;x++){
            let price = $('.price-record:first').clone();
            if(x>0){
              price.find('.add-new-price').closest('div').html("");
            }
            price.find("input[name='prices[]']").val(record.prices[x].price)
            price.find("input[name='quantities[]']").val(record.prices[x].quantity)
            $('.prices-records').append(price);
            console.log(record.prices[x])
          }
          $('.price-record:first').remove();

        }else{
          $('.price-record:first').find("input[name='prices[]']").val("0");
          $('.price-record:first').find("input[name='quantities[]']").val("0");
          $(".price-record:not(:eq(0))").remove()
        }
        $(".addEdit-new-modal .feature").remove();
        if( record.features &&  record.features.length > 0){
          $(".features").removeClass("d-none");
          $("input[name='haveFeatures']").attr('checked',true);
        }else{
          $(".features").addClass("d-none");
          $("input[name='haveFeatures']").attr('checked',false);
        }
        for (var i =0 ; i < record.features.length; i++) {
         
           var feature=`
              <div class="col-md-12 feature">
                  <input type="hidden" name="FeatId[]" value="${record.features[i].id}" class="FeatId">
                  
                  <label for="nameAr" class="col-form-label">ادخال الاسم بالعربي :</label>
                  <input type="test" class="form-control" name="nameArFeat[]" value="${record.features[i].nameAr}">
    
                  <label for="nameAr" class="col-form-label">ادخال الاسم بالانجليزية :</label>
                  <input type="test" class="form-control" name="nameEnFeat[]"  value="${record.features[i].nameEn}">
    
                  <label for="nameAr" class="col-form-label">ادخال السعر  :</label>
                  <input type="number" class="form-control" name="priceFeat[]"  value="${record.features[i].price}">
    
                  <label for="imageFeat" class="col-form-label">ادخال صورة  :</label>
                  <input type="file" class="form-control" name="imageFeat[]">
    
                  <br>
                  <a class="btn btn-danger btn-block mr-auto deleteFeature"> <i class="fas fa-trash"></i></a> 
                   <br>
                  <hr/>
              </div>
    
          `;
          $(".addEdit-new-modal .beforeFeature").before(feature);
 
        }
        $("#customCheck2").attr('checked',record.isFreeDelivered? true:false);
        if(record.hasOffer == true){
          $(".offer_Info").removeClass("d-none");
          $("#customCheck1").attr('checked',true);
          
        }else{
          $(".offer_Info").addClass("d-none");
          $("#customCheck1").attr('checked',false);
        }
      }
    });
  });
 
  $("body").on("click","#customCheck4",function(){
    getRecords(1);
  });
  
  
  $("body").on("click","input[name='haveFeatures']",function(){
    if(this.checked) {
      $(".features").removeClass("d-none");
    }else{
      $(".features").addClass("d-none");
    }
  });
  $("body").on("click",".addNewFeatures",function(){
    var feature=`
          <div class="col-md-12 feature">
              <input type="hidden" name="FeatId[]" value class="FeatId"> 
          
              <label for="nameAr" class="col-form-label">ادخال الاسم بالعربي :</label>
              <input type="test" class="form-control" name="nameArFeat[]" >

              <label for="nameAr" class="col-form-label">ادخال الاسم بالانجليزية :</label>
              <input type="test" class="form-control" name="nameEnFeat[]">

              <label for="nameAr" class="col-form-label">ادخال السعر  :</label>
              <input type="number" class="form-control" name="priceFeat[]">

              <label for="imageFeat" class="col-form-label">ادخال صورة  :</label>
              <input type="file" class="form-control" name="imageFeat[]">

              <br>
              <a class="btn btn-danger btn-block mr-auto deleteFeature"> <i class="fas fa-trash"></i></a> 
               <br>
              <hr/>
        </div>

      `;
    $(".addEdit-new-modal .beforeFeature").before(feature);
    
  });
  $("body").on("click",".deleteFeature",function(){
    var FeatId = $(this).parents(".feature").find(".FeatId").val();
    $(this).parent(".feature").remove();
    $.get( "products/delete/"+FeatId+"/feature", function(  ) {
    });

    
  });  
  $("body").on("click",".add",function(){
    $(".offer_Info").addClass("d-none");
    $("#customCheck1").attr('checked',false);

    $(".features").addClass("d-none");
    $("input[name='haveFeatures']").attr('checked',false);


    $('.price-record:first').find("input[name='prices[]']").val("0");
    $('.price-record:first').find("input[name='quantities[]']").val("0");
    $(".price-record:not(:eq(0))").remove()

  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".offer_Info").removeClass("d-none");
    }else{
      $(".offer_Info").addClass("d-none");
    }
  });
  $("body").on("change","select[name='stores_id']",function(){
    var id = $(this).val();
    $.ajax({
      url: "categoriesByStore/"+id,
      type: 'GET',
      processData: false,
      contentType: false,
      beforeSend: function(){
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
      },success: function(response) {
        $(".addEdit-new-modal .loading-container").toggleClass("d-none d-flix");
        $("select[name='categories_id']").html(response);
      }
    });
  });
 
  $("body").on("click",".add-points",function(){
    let id = $(this).parents('tr').data("id");;
    $("#points-modal input[name='products_id']").val(id);
  });
  
  $('#points-modal #submit').on('click', function(e) {
    e.preventDefault();
    $("#points-modal .loading-container").toggleClass("d-none d-flix");
    let form = $("#add-points-form");
    let url  = form.attr('action');
    let data = new FormData(form[0]);
    $.ajax({
      url: url,
      type: 'POST',
      data: data,
      processData: false,
      contentType: false,
      beforeSend: function(){
        $("#points-modal .loading-container").toggleClass("d-none d-flix");
        $("#points-modal  .submit").attr("disabled",true).append(` <i class="fas fa-cog fa-spin"></i>`);
      },
      success: function(response) {
            $("#points-modal  .submit").attr("disabled",false).find("i").remove();
            if(response.status!= 200 ){
                $(".modal .alert").attr("hidden",false);
                $(".alert").html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"  >
                        <p >${response.message}</p>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>  
                    </div>
                `);

            }else {
                $(".toast .toast-body").html(`
                    <i  class="fas fa-check-circle fa-2x"></i> 
                    <span style="margin-right:100px;font-size:20px;font-weight:bold">
                        ${response.message} 
                    </span>
                `);
                $(".toast").toast("show");
                setTimeout(function(){  $(".toast .toast-body").html(""); },  $(".toast ").data("delay"));


                $(".modal .alert").attr("hidden",true).find("p").html("");
                $('.progress-bar').text(0 + '%');
                $('.progress-bar').css('width', 0 + '%');
                getRecords($(".pagination .active").find("a").attr("href"));
                form[0].reset();
                $('#openImage').attr('src', "");
                $("#addEdit-new-modal").modal("toggle")
            }
           
        },
    });

  });

</script> 
<script>

  async function prepareFiles() {
    var files = Array.from($("#allImagesUpload").get(0).files);
    startUploadImage(files)
  }
  
  function startUploadImage(imagesBase64){
    $("#uploadbutton").attr("disabled",true).append(` <i class="fas fa-cog fa-spin"></i>`);
    const forLoop = async _ => {
      const sleep = (ms,imagesBase64,index) => {
        return new Promise(resolve => setTimeout(resolve, ms))
      }

      for (let index = 0; index < imagesBase64.length; index++) {
        await sleep(1000,imagesBase64,index)
              .then(()=>{
                uploadImage(imagesBase64[index])
              }).then(()=>{
                reachAt= (index+1)/imagesBase64.length*100;
                $('.progress-bar').text((Math.round(reachAt)) + '%');
                $('.progress-bar').css('width', reachAt + '%');
                $("#complete").text( 'جاري التحميل '+'('+
                  (Math.round(reachAt)) + '%' +
                    ')'
                  );
              }).then(()=>{
                if(index== (imagesBase64.length - 1 )){
                  $("#complete").html('اكتمل التحميل ' + "(100%)")
                  console.log('done')
                  setTimeout(() => {
                    $("#uploadImagesModal").modal("toggle");
                  }, 5000);
                  swal({
                      title: languagesWords[localStorage.getItem("lang")].uploading,
                      icon: "success",
                      button: "Ok",
                  });
                  $('#uploadImagesForm')[0].reset()
                  $("#uploadbutton").prop('disabled',false).find('i').remove()  
                }
              });
      }
    }
    forLoop();
  }
  function uploadImage (imgBase64){
    let imageData = new FormData();
    imageData.append('_token', $('input[name=_token]').val());
    imageData.append('image',imgBase64)

    $.ajax({
      url: "{{route('dashboard.products.uploadImages')}}",
      type: 'POST',
      cache: false,
      data:imageData ,
      contentType: false,
      processData: false,
      success: function(){

      }      
    });
  }
</script>
@endpush
@endsection
        