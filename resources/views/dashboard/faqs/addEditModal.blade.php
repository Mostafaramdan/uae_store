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
                        <label for="questionAr" class="col-form-label list-lang" ar="السؤال بالعربي "en="The question is in arabic">السؤال بالعربي:</label>
                        <input type="textarea" class="form-control" name="questionAr">
                    </div>
                    <div class="form-group">
                        <label for="questionEn" class="col-form-label list-lang" ar="السؤال بالإنجليزي "en="The question is in english">السؤال بالإنجليزية:</label>
                        <input type="textarea" class="form-control" name="questionEn">
                    </div>
                    <div class="form-group">
                        <label for="answerAr" class="col-form-label list-lang" ar="الجواب بالعربي "en="The answer is in arabic">الجواب بالعربي:</label>
                        <input type="textarea" class="form-control" name="answerAr">
                    </div>
                    <div class="form-group">
                        <label for="answerEn" class="col-form-label list-lang" ar="الجواب بالإنجليزي "en="The answer is in english">الجواب بالإنجليزية:</label>
                        <input type="textarea" class="form-control" name="answerEn">
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