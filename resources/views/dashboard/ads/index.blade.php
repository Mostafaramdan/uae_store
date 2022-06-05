@extends ('dashboard.layouts.master')
@section('title', 'الإعلانات')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#الإعلانات</h2>
        </div>

        <form class="mb-4" id="getOptions">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-row">
            
              <div class="m-2">
                <input type="search" class="form-control" placeholder="بحث" name="search">
              </div>

            <div class="m-2">
              <select class="custom-select" name="sortBy">
                <option selected disabled>الترتيب علي حسب</option>
                <option value="description">الوصف</option>
                <option value="link">الرابط</option>
                <option value="end_date">تاريخ الانتهاء</option>
                <option value="viewers">عدد المشاهدات</option>
              </select>
            </div>

            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled>نوع الترتيب</option>
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

        </form>
      
        <div class="flex-grow-1"></div>
              <div class="m-2">
                  <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>
          <div class="table-responsive">
            <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
              @include('dashboard.ads.tableInfo')
            </table>
        </div>
        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.ads.viewModal')
      @include('dashboard.ads.addEditModal')
</div>
@push('script')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            $(".carousel-item ."+k).attr("src","{{url('/')}}"+record[k]);
          }else{
            $(".list-group-item ."+k).html(record[k])
          }
        }
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل");
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
    });
  });
  $("body").on("change","select[name='screen']",function(){
      $(".screen").find(".form-group").addClass("d-none").parents(".screen").find("."+$(this).val()).removeClass("d-none").siblings().find("select option:first").prop('selected', true);
  });
  $("body").on("change","select[name='action']",function(){
      $(".action").find(".form-group").addClass("d-none").parents(".action").find("."+$(this).val()).removeClass("d-none").siblings().find("select option:first").prop('selected', true);
  });
</script> 
@endpush
@endsection
        