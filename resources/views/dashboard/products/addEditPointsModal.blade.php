<div class="modal fade addEdit-points-modal" id="points-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> إضافة نقاط</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form   id="add-points-form" action="{{route('dashboard.points.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="products_id" value="">
                    <div class="form-group">
                        <label for="numberOfPoints" class="col-form-label"> عدد النقاط :</label>
                        <input type="number" class="form-control" name="numberOfPoints">
                    </div>
                    <div class="form-group">
                        <label for="descriptionAr" class="col-form-label"> الوصف بالعربي:</label>
                        <input type="text" class="form-control" name="descriptionAr">
                    </div>
                    <div class="form-group">
                        <label for="descriptionEn" class="col-form-label"> الوصف بالانجليزي:</label>
                        <input type="text" class="form-control" name="descriptionEn">
                    </div>
                </form>
                <div class="alert " >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  class="btn btn-success submit" id="submit">save</button>
            </div>

        </div>
    </div>
</div>
</div>