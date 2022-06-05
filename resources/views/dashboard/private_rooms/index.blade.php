@extends ('dashboard.layouts.master')
@section('title', 'الغرف الخاصة')
@section ('content')
    <div class="content" >
    <div  id="alert">

    </div>

        <div class="d-flex align-items-center mb-4">
          <h2 class="m-0">#الغرف الخاصة</h2>
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
        </form>

        <div class="flex-grow-1"></div>
              <div class="m-2">
                <button class="btn btn-primary px-5 add" onClick="event.preventDefault();" data-toggle="modal" data-target="#addEdit-new-modal"> إضافة غرفة خاصة <i class="ml-2 fas fa-plus-circle"></i></button>
              </div>
          </div>

        <div class="table-responsive">
          <table class="table bg-light mb-4 tableInfo" id="tableInfo" dir="rtl">
            @include('dashboard.private_rooms.tableInfo')
          </table>
        </div>
        <!-- pagination -->
        <div class="paging">  
          @include('dashboard.layouts.paging')
        </div>
        <!-- end pagination -->
    </div>

    @include('dashboard.private_rooms.viewModal')

    @include('dashboard.private_rooms.addEditModal')

    @include('dashboard.general_rooms.showMessage')

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
    $(".addEdit-new-modal .modal-title").html("تعديل");
    $(".addEdit-new-modal input[name='id']").val($(this).parents("tr").data("id"));
    let id = $(this).parents('tr').data("id");
    $.get( "{{Request::segment(2)}}/getRecord/"+id,function( record ) {
      for (var k in record) {
        if (record.hasOwnProperty(k)) {
          if(k.includes('image')  ){
            if(record[k]){  
              $(".carousel ").removeClass("d-none");
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
      $('input[name="searchForUsers"]').html(`<option  value="${record.owners.id}">${record.owners.name}  -  ${record.owners.phone}</option>`)
    });
  });

  var typingTimer;                //timer identifier
  var doneTypingInterval = 500;  //time in ms, 1 second for example
  var $input = $('input[name="searchForUsers"]');
  //on keyup, start the countdown
  $input.on('keyup', function () {
      clearTimeout(typingTimer);
      typingTimer = setTimeout(doneTyping, doneTypingInterval);
  });
  //on keydown, clear the countdown 
  $input.on('keydown', function () {
      clearTimeout(typingTimer);
  });
  //user is "finished typing," do something
  function doneTyping () {
    $.get( "{{Request::segment(2)}}/private_rooms_admins_select/"+$('input[name="searchForUsers"]').val(),function( reponse ) {
      $("select[name='owners_id']").html(reponse);
    });
  }
  var page=0;
function showMoreMessages(id,currentPage){ 
  var formData = new FormData();
  formData.append('id',id);
  formData.append('page',currentPage);
  formData.append('_token', $('input[name=_token]').val());
  $.ajax({
    type: 'POST',
    url:"{{route('dashboard.private_rooms.getMsssagesInPrivateRooms')}}",
    data:formData,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        $(".show-more-message").prop('disabled', true).html(`<div class="spinner-border text-primary  " role="status"><span class="sr-only">Loading...</span></div>`);
    },
    success: function(data){
      if(data.status == 200 ){
        page++;
          $(".show-more-message").prop('disabled', false).html("مشاهدة المزيد");
          for (i=0;i<data.messages.length;i++){
            $(".modal-body .messages").append(`  
              <div class="col-12 mr-2">
                <span class="badge badge-info">${data.messages[i].owner.name} - ${data.messages[i].owner.phone} </span>
                <div class="p-3 bg-dark text-white">${data.messages[i].message}  </div>
                <span class="badge badge-success mb-5 ">${data.messages[i].created_at} </span>

              </div>
            `);
          }
        }else if(data.status == 204){
          $(".show-more-message").hide();
        }
    },error:function(data){
      $(".show-more-message").prop('disabled', false).html("مشاهدة المزيد");
        console.log(data.responseText);
    }
  }); 
}
    var id = 0 ;
    $("body").on("click",".show-messages-modal",function(){
      $(".modal-body .messages").html(''); 
      $(".show-more-message").show();
 
      page=0;
       id = $(this).parents('tr').data("id");
      showMoreMessages(id,page);
    });
    $("body").on("click",".show-more-message",function(){
      showMoreMessages(id,page);
    });

</script> 
@endpush
@endsection
        