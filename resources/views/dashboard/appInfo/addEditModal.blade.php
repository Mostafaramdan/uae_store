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
                        <label for="phones" class="col-form-label list-lang" ar="ارقام التليفونات"  en ="phones"> أرقام التليفونات :</label>
                        <input type="text"  class="form-control" data-role="tagsinput" name="phones">
                    </div>
                    <div class="form-group">
                    <label for="emails" class="col-form-label list-lang" ar="الايميلات"  en ="emails">الإيميلات :</label>
                        <input type="text"  class="form-control" data-role="tagsinput" name="emails">
                    </div>
                    <div class="form-group">
                        <label for="welcomeAr" class="col-form-label list-lang" ar="رسالة الترحيب"  en ="welcome message in arabic" > رسالة الترحيب بالعربي :</label>
                        <textarea type="text" class="form-control" name="welcomeAr"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="welcomeEn" class="col-form-label list-lang" ar="رسالة الترحيب بالانجليزي  "  en ="welcome message in english"> رسالة الترحيب بالإنجليزي :</label>
                        <textarea type="text" class="form-control" name="welcomeEn"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="aboutAr" class="col-form-label list-lang" ar="عن التطبيق بالعربي"  en ="about application in arabic">عن التطبيق بالعربي :</label>
                        <textarea type="text" class="form-control" name="aboutAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="aboutEn" class="col-form-label list-lang" ar="   عن التطبيق بالانجليزي"  en ="about application in english">عن التطبيق بالإنجليزي:</label>
                        <textarea type="text" class="form-control" name="aboutEn"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policyAr" class="col-form-label list-lang" ar="   سياسة الاستخدام  بالعربي"  en =" policy terms in arabic">سياسة الإستخدام بالعربي:</label>
                        <textarea  type="text" class="form-control" name="policyAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policyEn" class="col-form-label list-lang" ar="   سياسة الاستخدام  بالانجليزي"  en =" policy terms in english">سياسة الإستخدام بالإنجليزي:</label>
                        <textarea  type="text" class="form-control" name="policyEn"></textarea>
                    </div>
                    <!-- <div class="form-group">
                        <label for="privacyAr" class="col-form-label">سياسة الأمان بالعربي:</label>
                        <textarea  type="text" class="form-control" name="privacyAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="privacyEn" class="col-form-label">سياسة الأمان بالإنجليزي:</label>
                        <textarea  type="text" class="form-control" name="privacyEn"></textarea>
                    </div> -->
                    <!--<div class="form-group">-->
                    <!--    <label for="userFees" class="col-form-label"> رسوم المستخدمين :</label>-->
                    <!--    <input  type="number" class="form-control" name="userFees">-->
                    <!--</div>-->
                    <div class="form-group">
                        <label for="driverFees" class="col-form-label list-lang" ar=" رسوم السائقين "  en =" driver fees" >%  رسوم السائقين :</label>
                        <input  type="number" class="form-control" name="driverFees">
                    </div>
                    <div class="form-group">
                        <label for="storeFees" class="col-form-label list-lang" ar=" رسوم المتاجر "  en =" store fees">%  رسوم المتاجر :</label>
                        <input  type="number" class="form-control" name="storeFees">
                    </div>
                    <div class="form-group">
                        <label for="radius" class="col-form-label list-lang" ar=" النطاق بالكيلو ميتر  "  en ="   the range in Km">  النطاق بالكيلومتر  :</label>
                        <input  type="number" class="form-control" name="radius">
                    </div>
                    <div class="form-group">
                        <label for="pricePer20Km" class="col-form-label list-lang" ar="  سعر التوصيل لكل 20 كليومتر ؟ "  en =" Delivery price per 20 km?"> سعر التوصيل لكل 20 كليومتر ؟  :</label>
                        <input  type="number" class="form-control" name="pricePer20Km">
                    </div>
                    <div class="form-group">
                        <label for="priceOfPoint" class="col-form-label list-lang" ar=" سعر النقطة "  en =" Point price">   إدخل سعر النقطة الواحدة    ؟  :</label>
                        <input  type="number" class="form-control" name="priceOfPoint">
                    </div>
                    <div class="form-group">
                        <label for="maxStorePoints" class="col-form-label list-lang" ar=" أقل عدد نقاط يمكن إستبدالها "  en =" Minimum number of points that can be redeemed">    :</label>
                        <input  type="number" class="form-control" name="maxStorePoints">
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