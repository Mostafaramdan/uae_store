@extends ('dashboard.layouts.master')
@section('title', 'الأقسام')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0"># الأقسام</h2>
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
              <select class="custom-select"  name="categoryType" onChange="getRecords(1);">>
                <option selected disabled>  نوع القسم </option>
                <option value="mainCategory">رئيسي</option>
                <option value="sortByDesc">فرعي</option>
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

          </div>
        </form>
        <div class="flex-grow-1"></div>
        <div class="m-2">
          <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة جديد   <i class="ml-2 fas fa-plus-circle"></i></button>
          <a class="btn btn-success" href="{{route('dashboard.categories.export')}}"> استيراد البيانات <i class="ml-2 fas fa-download"></i></a>
          <a class="btn btn-dark" style='color:white' data-toggle="modal" data-target="#importRecords"> تصدير البيانات <i class="ml-2 fas fa-file-upload"></i> </a>
        </div>

        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.categories.tableInfo')
          </table>
        </div>
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
    </div>
</div>
@include('dashboard.categories.viewModal')
@include('dashboard.categories.addEditModal')
@include('dashboard.layouts.import&export')

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
              $(".addEdit-new-modal select[name='"+k+"'] option[value='"+record[k]+"']").prop('selected', true);
            }
          }
        }
        if(record.categories_id){
          $(".store-category").removeClass("d-none");
          $("#customCheck1").attr('checked',true);
        }else{
          $(".store-category").addClass("d-none");
          $("#customCheck1").attr('checked',false);
        }
      }
    });
  });
  $("body").on("click","#customCheck1",function(){
    if(this.checked) {
      $(".store-category").removeClass("d-none");
    }else{
      $(".store-category").addClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $(".offer_Info").addClass("d-none");
    $("#customCheck2").attr('checked',false);

    $(".features").addClass("d-none");
    $("input[name='haveFeatures']").attr('checked',false);
  });
  $("body").on("click","#customCheck2",function(){
    if(this.checked) {
      $(".offer_Info").removeClass("d-none");
    }else{
      $(".offer_Info").addClass("d-none");
    }
  });
  $("body").on("click",".add",function(){
    $(".store-category").addClass("d-none");
    $("#customCheck1").attr('checked',false);
  });

</script> 
@endpush
@endsection
        