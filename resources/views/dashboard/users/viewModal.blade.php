<div class="modal fade view-modal" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="loading-container"  >
        <div class="spinner-border text-primary" role="status">
        </div>
  </div>
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">تفاصيل المستخدم</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          </ol>
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img
                src="https://images.unsplash.com/photo-1479231233972-e184fe70398e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=60"
                class="d-block w-100">
            </div>
          </div>
        </div>
        <h5 class="text-muted mt-3 mb-2">التفاصيل</h5>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar='الإسم' en='name'></span>
            <span class="name"></span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar='التليفون' en='phone'></span>
            <span class="phone">2</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar='البريد الالكتروني' en='email'></span>
            <span class="email">2</span>
          </li>
          <!-- <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar='المنطقة' en='region name'></span>
            <span class="region_name"></span>
          </li> -->
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar='الرصيد' en='balance '></span>
            <span class="balance"></span>
          </li>
        </ul>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
