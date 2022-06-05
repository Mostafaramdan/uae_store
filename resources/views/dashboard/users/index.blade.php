@extends ('dashboard.layouts.master')
@section('title', "المستخدمين")
@section ('content')
  <div class="content" >
    <div  id="alert">
  </div>
  <div class="d-flex align-items-center mb-4">
    <h2 class="m-0"># المستخدمين </h2>
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
          <option value="name">الإسم</option>
          <option value="createdAt">تاريخ الإنشاء</option>
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
  <div class="flex-grow-1"></div>
    <div class="m-2">
        <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table bg-light tableInfo" id="tableInfo" dir="rtl">
       @include('dashboard.users.tableInfo')
    </table>
  </div>
  <div class="paging">  
    @include('dashboard.layouts.paging')
  </div>
</div>
@include('dashboard.users.viewModal')
@include('dashboard.users.addEditModal')
@include('dashboard.users.balanceInfoModal')
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
            if(k == 'image'){
              $(".carousel-item img").attr("src",record.image);
            }else{
              $(".list-group-item ."+k).html(record[k])
            }
          }
        }
      }
    });
  });
  $("body").on("click",".edit",function(){
    $(".addEdit-new-modal .modal-title").html("تعديل مستخدم ");
     $(".addEdit-new-modal input[name='balance']").parent(".form-group").removeClass("d-none");
    $(".addEdit-new-modal input[name='id']").val($(this).parents('tr').data("id"));
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
        $("#customCheck1").attr("checked",false);
        $(".addEdit-new-modal .role").addClass("d-none");
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
      }
    });
  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".role").removeClass("d-none");
    }else{
      $(".role").addClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $(".addEdit-new-modal input[name='checkType'").attr("checked",false);
    $(".addEdit-new-modal .role").addClass("d-none");
    $(".addEdit-new-modal input[name='balance']").parent(".form-group").addClass("d-none");

  });
  $("body").on("click",".balanceInfo",function(){
        let id = $(this).parents('tr').data("id");
        $.ajax({
        url: "users/getLogs/"+id,
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