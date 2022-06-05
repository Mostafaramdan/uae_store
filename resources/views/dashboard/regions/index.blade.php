@extends ('dashboard.layouts.master')
@section('title', 'المناطق')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

    <div class="d-flex align-items-center mb-4">
      <h2 class="m-0">#المحافظات و الولايات  </h2>
    </div>

    <form class="mb-4" id="getOptions">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="form-row">
        <div class="m-2">
          <input type="search" class="form-control" placeholder="بحث" name="search">
        </div>
        <div class="m-2">
          <select class="custom-select" name="sortBy">
            <option selected disabled>ترتيب علي حسب</option>
            <option value="created_at">تاريخ الإنشاء</option>
            <option value="name">الاسم</option>
            <option value="country_name">البلد</option>
          </select>
        </div>
        <div class="m-2">
          <select class="custom-select"  name="sortType">
            <option selected disabled>نوع الترتيب</option>
            <option value="sortBy">تصاعدياََ</option>
            <option value="sortByDesc">تنازلياََ</option>
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
    </form>
    <div class="flex-grow-1"></div>
        <div class="m-2">
            <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
        </div>
    </div>
    <div class="table-responsive">
      <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
        @include('dashboard.regions.tableInfo')
      </table>
    </div>
      <div class="paging">  
        @include('dashboard.layouts.paging')
      </div>
    </div>

      <!-- Large modal -->
      @include('dashboard.regions.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.regions.addEditModal')
      <!-- end add user modal -->

      <!-- end main content -->
</div>
@push('script')

<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            $(".carousel-item ."+k).attr("src",record[k]);
          }else{
            $(".list-group-item ."+k).html(record[k])
          }
        }
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل ");
    $(".addEdit-new-modal input[name='id']").val($(this).parents("tr").data("id"));
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
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
            $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
          }
        }
      }
      if(record.country_name){
        $("#customCheck1").attr('checked',false);
        $(".regions_id_select").removeClass("d-none");        
      }else{
        $(".regions_id_select").addClass("d-none");
        $("#customCheck1").attr('checked',true);

    }
    });
  });
  $("body").on("click","input[name='type']",function(){
    $('.select_id').addClass('d-none')
    let select= $(this).data('select')
    $("."+select).removeClass("d-none");

  });
  $("body").on("click",".add",function(){
    $(".emirate_id_select").addClass("d-none");
    $(".city_id_select").addClass("d-none");
    $('#emirate').prop('checked','checked');
  });

</script> 
@endpush
@endsection
        