<div class="modal fade" id="uploadImagesModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >رفع مجموعة صور  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="uploadImagesForm" method="POST" enctype="multipart/form-data" > 
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="image" class='list-lang' ar='اختر الصور' en='choose photos'> </label>
                        <input type="file" class="form-control"  id="allImagesUpload" name='images[]'  accept=".jpg,.jpeg,.png"  max="10000" multiple> 
                    </div>
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;font-size:15px;font-weight:bold" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" >0%</div>
                        </div> 
                        <h6 id="complete"></h6>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary list-lang" ar='إلغاء' en='cancel' data-dismiss="modal"></button>
                <button type="button" class="btn btn-primary list-lang " onClick="prepareFiles(this)" id="uploadbutton"  ar='رفع الصور' en='upload images'> </button>
                
            </div>
        </div>
    </div>
</div>
