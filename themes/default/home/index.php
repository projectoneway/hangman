<section>
  <div class="container">
    <?php if (!empty($error)) { ?>
      <div class="bg-danger">
        <?php echo $error; ?>
      </div>
    <?php } ?>
    <form class="form-signin" method="post" action="">
      <h2 class="form-signin-heading">Enter email to play game</h2>
      <label for="email" class="sr-only">Email</label>
      <input type="email" id="email" name="email" class="form-control" placeholder="Email" required="" autofocus="" value="<?php echo $email; ?>" />
      <button class="btn btn-lg btn-primary btn-block" type="submit">Start</button>
    </form>
  </div>
</section>