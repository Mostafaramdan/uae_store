@extends ('dashboard.layouts.master')
@section('title', 'السائقين')
@section ('content')
    <div class="content" >
    <div  id="alert">
    </div>
        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># السائقين</h2>
        </div>
        <form class="mb-4" id="getOptions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-row">
            <div class="m-2">
              <input type="search" class="form-control" placeholder="بحث" name="search">
            </div>
            <div class="m-2">
              <select class="custom-select" name="sortBy">
                <option selected disabled> الترتيب علي حسب</option>
                <option value="name"> الاسم </option>
                <option value="isApproved"> في انتظار الموافقة </option>
                <option value="createdAt">تاريخ الانشاء </option>
              </select>
            </div>
            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled> نوع الترتيب</option>
                <option value="sortBy">تصاعدي</option>
                <option value="sortByDesc">تنازلي</option>
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
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="isApproved" name ="isApproved" >
                    <label class="custom-control-label list-lang" ar='في انتظار الموافقة' en='Waiting for approval' for="isApproved" ></label>
                </div>
            </div>
        </form>
        <div class="flex-grow-1"></div>
              <div class="m-2">
                  <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.drivers.tableInfo')
          </table>
        </div>

        <!-- pagination -->
        <div class="paging">   
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.drivers.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.drivers.addEditModal')
      <!-- end add user modal -->
      @include('dashboard.drivers.balanceInfoModal')

      <!-- end main content -->
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
            if(k.includes('image') || k.includes('Image') || k.includes('Photo')){
              $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
            }else{
              $(".view-modal ."+k).html(record[k])
            }
          }
        }

        $(".view-modal .vehicleName").html(record.vehicle?record.vehicle['name'+localStorage.getItem("lang")]:'');
        $(".view-modal .deliveryMethodsName").html(record.delivery_method?record.delivery_method['name'+localStorage.getItem("lang")]:'');

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
            if(k.includes('image') || k.includes('Image') || k.includes('Photo')){
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
              $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
            }
          }
        }
      }
    });
  });
  $("body").on("click",".balanceInfo",function(){
        let id = $(this).parents('tr').data("id");
        $.ajax({
        url: "drivers/getLogs/"+id,
        type: 'GET',
        processData: false,
        contentType: false,
        beforeSend: function(){
          $(".balaneInfo-modal .loading-container").toggleClass("d-none d-flix");
        },
        success: function(response) {
          $(".balaneInfo-modal .loading-container").toggleClass("d-none d-flix");
          $("table.balanceTableInfo").html(response);
        }
      });
  });

</script> 
@endpush
@endsection
        