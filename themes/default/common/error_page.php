<section class="thank-you-section">
  <div class="container">
    <div class="row">
      <div class="main-content text-center">
        <div class="content-wrapper">
          <h1>Error !</h1>
          <p><?php
            if ($this->session->flashdata('error_message')) {
              echo $this->session->flashdata('error_message');
            } else {
              echo __d('label.requested_page_not_found');
            }
            ?></p>
        </div>
      </div>
    </div>
  </div>
</section>