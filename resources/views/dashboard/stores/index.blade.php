@extends ('dashboard.layouts.master')
@section('title', ' المتاجر ')
@section ('content')
    <div class="content" >
      <div  id="alert">
    </div>
        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#المتاجر </h2>
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
                <option value="name">name</option>
                <option value="createdAt">تاريخ الانشاء</option>
              </select>
            </div>
            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled> نوع الترتيب</option>
                <option value="sortBy">تصاعدي</option>
                <option value="sortByDesc">تنازلي</option>
              </select>
            </div>
            <div class="m-2" onClick="getRecords(1);">
              <div class="custom-control custom-checkbox mb-4">
                <input type="checkbox" class="custom-control-input" id="customCheck4" name="has_offer">
                <label class="custom-control-label stores_has_offer" for="customCheck4" >متاجر لها خصومات</label>
              </div>
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

        </form>
        <div class="flex-grow-1"></div>
              <div class="m-2">
              <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
          <div class="col-md-12 d-none">
            <button class="closeMap btn btn-danger"> اغلاق الخريطة</button>
            <div class="page-header">
                <h5><i class="menu-icon fa fa-map-marker"></i> احداثيات خرائط جوجل</h5>
            </div>
            <div id="mapCanvas" style="width: 100%;height: 100%;float: left;"></div>
            <div id="infoPanel">
                <b>اقرب عنوان متطابق:</b>
                <div id="address"></div>
            </div>          
          </div>

        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            
            @include('dashboard.stores.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
    @include('dashboard.stores.viewModal')
    @include('dashboard.stores.addEditModal')
</div>
@push('script')
<script>
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
        }
        $(".view-modal .longitude").html(record.location.longitude);
        $(".view-modal .latitude").html(record.location.longitude);
        $(".view-modal .address").html(record.location.address);
        $(".view-modal .mapUrl").html(`<a target="_blank" href = "${record.location.mapUrl}">${localStorage.getItem("lang")=='Ar'?"الإنتقال إلي الخريطة":"move to the map"}</a> `);
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل ");
    $(".addEdit-new-modal input[name='balance']").parent(".form-group").removeClass("d-none");
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
              $(`.addEdit-new-modal select[name='${k}'] option[value='${record[k]}']`).prop('selected', true);
            }
          }
        }
        if(record.has_offer){
          $(".discount").removeClass("d-none");
          $("#customCheck2").attr('checked',true);
        }else{
          $(".discount").addClass("d-none");
          $("#customCheck2").attr('checked',false);
        }
        if(record.location){
          $(".addEdit-new-modal input[name='longitude']").val(record.location.longitude);
          $(".addEdit-new-modal input[name='latitude']").val(record.location.latitude);
          $(".addEdit-new-modal input[name='address']").val(record.location.address);
          $(".addEdit-new-modal input[name='mapUrl']").val(record.location.mapUrl);
        }
      }
    });
  });
   $("body").on("click",".add",function(){
         $(".addEdit-new-modal input[name='balance']").parent(".form-group").addClass("d-none");

   });
     $("body").on("click","#customCheck2",function(){
    if(this.checked) {
      $(".discount").removeClass("d-none");
    }else{
      $(".discount").addClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $(".discount").addClass("d-none");
    $("#customCheck2").attr('checked',false);
  });

</script> 
@endpush
@endsection
        