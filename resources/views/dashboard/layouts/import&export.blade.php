<div class="modal fade" id="importRecords" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">استيراد البيانات </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.'.Request::segment(2).'.import')}}" id="importProductForm" method="POST"  enctype="multipart/form-data"> 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label >اختر ملف الاكسيل </label>
                        <input type="file" class="form-control" name='file'  accept=".doc,.docx,.xlsx" required>
                    </div>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" onclick="$('#importProductForm').submit();$(this).prop('disabled',true)">حفظ</button>
            </div>
        </div>
    </div>
</div>
