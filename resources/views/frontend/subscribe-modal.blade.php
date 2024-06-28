<div class="modal fade" id="mailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subscribe via Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Name:</label>
                        <input type="text" name = "recipient-name" class="form-control" id="recipient-name" required>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-email" class="col-form-label">Email:</label>
                        <input type="email" name ="recipient-email" class="form-control" id="recipient-email" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="subscribe()">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered musicModal">
    <div class="modal-content">    
      <div class="modal-body">      
        <div class="artist-modal">
          <button type="button" class="btn-close modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div class="row">
            <div class="col-md-6 text-center">
              <img src="img/artist-1.png" id ="imgText" class="img-fluid"/>
            </div>
            <div class="col-md-6">
              <div class="artist-details">
                <h4 class="text-left" id="titleText"></h4>
                <h5 class="text-left mt-2" id="roleText"></h5>
              </div>
              <p id ="quoteText" class="mt-3"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>