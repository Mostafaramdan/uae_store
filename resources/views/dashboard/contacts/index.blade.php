@extends ('dashboard.layouts.master')
@section('title', 'الشكاوي والاقتراحات')
@section ('content')
  <div class="content" >
    <div  id="alert"</div>

    <div class="d-flex align-items-center mb-4">
      <h2 class="m-0"># الشكاوي والاقتراحات</h2>
    </div>
    <form class="mb-4 form-row" id="getOptions">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="m-2">
        <input type="search" class="form-control" placeholder="بحث" name="search">
      </div>
      <div class="m-2">
        <select class="custom-select" name="sortBy">
          <option selected disabled>ترتيب علي حسب</option>
          <option value="created_at">تاريخ الإنشاء</option>
        </select>
      </div>
      <div class="m-2">
        <select class="custom-select"  name="sortType">
          <option selected disabled>نوع الترتيب</option>
          <option value="asc">تصاعدياََ</option>
          <option value="desc">تنازلياََ</option>
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
    <div class="table-responsive">
      <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
        @include('dashboard.contacts.tableInfo')
      </table>
    </div>
    <!-- pagination -->
    <div class="paging">  
      @include('dashboard.layouts.paging')
    </div>
    <!-- end pagination -->
  </div>
      <!-- Large modal -->
      @include('dashboard.contacts.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.contacts.addEditModal')
      <!-- end add user modal -->

      <!-- end main content -->
      @include('dashboard.contacts.email')


</div>
@push('script')
<script>
  $("body").on("click",".get-record",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      if(record.sender){
        $(".list-group-item .name").html(record.sender.name);
        $(".list-group-item .email").html(record.sender.email);
        $(".list-group-item .phone").html(record.sender.phone);
        
      }else{
        $(".list-group-item .name").html(record.name);
        $(".list-group-item .email").html(record.email);
        $(".list-group-item .phone").html(record.phone);
        
      }
      $(".list-group-item .message").html(record['message'])
      $(".list-group-item .createdAt").html(record['createdAt'])
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل General Room ");
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
</script> 
@endpush
@endsection
        