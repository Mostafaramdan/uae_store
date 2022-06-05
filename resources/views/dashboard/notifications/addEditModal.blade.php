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
                        <label for="titleAr" class="col-form-label list-lang" ar=" العنوان بالعربي" en="arabic title"> العنوان بالعربي :</label>
                        <input type="text"  class="form-control" name="titleAr">
                    </div>
                    <div class="form-group">
                        <label for="titleEn" class="col-form-label list-lang" ar=" العنوان بالانجليزي" en="english title"> العنوان بالانجليزي :</label>
                        <input type="text"  class="form-control" name="titleEn">
                    </div>
                    <div class="form-group">
                        <label for="contentAr" class="col-form-label list-lang" ar=" المحتوي بالعربي" en="arabic content" > المحتوي بالعربي :</label>
                        <textarea  class="form-control" name="contentAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="contentEn" class="col-form-label list-lang" ar=" المحتوي بالانجليزي" en="english content" > المحتوي بالانجليزي :</label>
                        <textarea  class="form-control" name="contentEn"></textarea>
                    </div>
                    <div class="form-group" >
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1" name ="checkType"checked>
                            <label class="custom-control-label list-lang" ar=" جميع المستخدمين" en="all" for="customCheck1" >جميع المستخدمين</label>
                        </div>
                    </div>
                    <div class="form-group d-none usersTypeSelect" >
                        <label for="users_type" class="col-form-label list-lang"  ar="اختر النوع" en="choose type">اختر النوع:</label>
                        <select  class="form-control" name="users_type" >
                            <option value="user" class="list-lang" ar="العملاء"en ="users">العملاء  </option>
                            <option value="drivers" class="list-lang" ar="الكباتن"en ="drivers">الكباتن </option>
                            <option value="stores" class="list-lang" ar="المتاجر"en ="stores">المتاجر </option>
                        </select>
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group col-md-12">
                            <button class="btn btn-primary " onClick="event.preventDefault();$(this).parents('.row').find('input:file').click();">اختر صورة <i class="fas fa-image"></i></button>
                        </div>
                        <div class="col-md-12">
                          <input type="file" id="img"  accept="image/*" hidden data-image="image" >
                          <input type="hidden"  name="image"  hidden >
                          <img id="image" class="img-thumbnail" hidden style="border-radius: 50%;height: 50%;max-width: 50%;max-height: 200px;min-height: 200px;"/>
                          <hr/>
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