<div class="modal fade view-modal" id="view-modal" tabindex="-1" role="dialog"
aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
<div class="loading-container"  >
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
<div class="modal-dialog modal-lg" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalScrollableTitle"> التفاصيل </h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active bg-primary"></li>
        </ol>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img style="width:75%"
              src="https://images.unsplash.com/photo-1479231233972-e184fe70398e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=600&q=60"
              class="d-block w-100 image">
          </div>
          <a class="carousel-control-prev " href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon bg-primary" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next " href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon bg-primary" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
      </div>
      <h5 class="text-muted mt-3 mb-2">التفاصيل</h5>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
            
            <span class="list-lang" ar="الوصف باللغة العربية" en="The description is in arabic"></span>
          <span class="descriptionAr"></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="list-lang" ar="الوصف باللغة الانجليزية" en="The description is in english"></span>
            <span class="descriptionEn"></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center">
           <span class="list-lang" ar="عدد النقاط" en="number of points"></span>
          <span class="numberOfPoints"></span>
        </li>
      </ul>

    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>