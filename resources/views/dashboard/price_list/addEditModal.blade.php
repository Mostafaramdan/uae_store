<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="startKm" class="col-form-label">من كم ؟ :</label>
                        <input type="number" class="form-control" name="startKm">
                    </div>
                    <div class="form-group">
                        <label for="endKm" class="col-form-label">الي كم ؟ :</label>
                        <input type="number" class="form-control" name="endKm">
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-form-label"> سعر :</label>
                        <input type="number" class="form-control" name="price">
                    </div>
                    <div class="form-group" >
                        <label for="regionId" class="col-form-label">اختر الشاحنة:</label>
                        <select  class="form-control" name="regionId">
                            @foreach(\App\Models\vehicles::where('isActive',1)->get() as $vehicle)
                                <option value="{{$vehicle->id}}">{{$vehicle->nameAr}}</option>
                            @endforeach
                        </select>
                    </div>
                   
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div> 
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