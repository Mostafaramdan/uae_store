<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
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
                        <label for="name" class="col-form-label">الاسم:</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-form-label"> الوصف :</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                    <div class="form-group" >
                        <label for="regionId" class="col-form-label">اختر المدينة:</label>
                        <select  class="form-control" name="regions_id">
                            @foreach(\App\Models\regions::where('regions_id','!=',null)->get() as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" >
                        <label for="searchForUsers" class="col-form-label">اختر المسؤولين عن هذه الغرفة:</label>
                        <input type="text" class="form-control" name="searchForUsers" placeholder="بحث">
                        <select  class="form-control" name="general_rooms_admins_select">
                        </select>
                    </div>
                    <div class="form-group">
                    <input type="text"  class="form-control" data-role="tagsinput" >
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                            <input type="file"  name="room_image" accept="image/*" hidden data-image="room_image">
                            <img id="room_image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                            <hr/>
                        </div>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر الخلفية <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                            <input type="file"  name="background_image" accept="image/*" hidden data-image="background_image">
                            <img id="background_image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                            <hr/>
                        </div>
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