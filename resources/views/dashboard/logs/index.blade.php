@extends ('dashboard.layouts.master')
@section('title', 'logs')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#logs</h2>
        </div>

        <form class="mb-4" id="getOptions">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-row">
            
            <div class="m-2">
              <input type="search" class="form-control" placeholder="Search" name="search">
            </div>

            <div class="m-2">
              <select class="custom-select" name="sortBy">
                <option selected disabled>order by</option>
                <option value="name">name</option>
                <option value="created_at">created at</option>
              </select>
            </div>

            <div class="m-2">
              <select class="custom-select"  name="sortType">
                <option selected disabled>order type</option>
                <option value="asc">Aescending</option>
                <option value="desc">Descending</option>
              </select>
            </div>
        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> ADD New log <i
                    class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>

        <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
          @include('dashboard.logs.tableInfo')
        </table>

        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>
      <!-- Large modal -->
      @include('dashboard.logs.viewModal')
      <!-- end Large modal -->

      <!-- addEdit new modal -->
        @include('dashboard.logs.addEditModal')
      <!-- end add user modal -->

      <!-- end main content -->
</div>
@push('script')
<script>
$(".get-record").on("click",function(){
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
           if(k == 'image'){
            $(".carousel-item img").attr("src",record.image);
           }else{
            $(".list-group-item ."+k).html(record[k])
           }
        }
    }
  });
  })
   
</script> 
@endpush
@endsection
        