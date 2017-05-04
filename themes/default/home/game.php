<section>
  <?php
  $alphaStr = '';
  $alphaRange = range('A', 'Z');

  $alphaClass = array('btn btn-primary', 'btn btn-success', 'btn btn-info', 'btn btn-warning', 'btn btn-danger');

  $cls = 0;
  $alphaStr .= '<table cellpadding=3 cellspacing=10 class=table width=100% border=0>';
  $alphaStr .= '<tr>';
  foreach ($alphaRange as $ap) {

    if (!empty($alreadyUsed) && in_array((strtolower($ap)), $alreadyUsed)) {
      $alphaStr .= '<td><a href="javascript:void(0)"  class="btn btn-default" role="button">' . $ap . '</a></td>';
    } else {

      $alphaStr .= '<td><a href="' . site_url('home/playgame/' . $gameId . '?char=' . $ap) . '" onclick=guessMe(this.href) class="' . $alphaClass[$cls] . '" role="button">' . $ap . '</a></td>';
    }
    $cls++;
    if ($cls == 5) {
      $cls = 0;
      $alphaStr .= '</tr><tr>';
    }
  }
  $alphaStr .= '</tr>';
  $alphaStr .= '</table>';
  ?>
  <div class="container">
    <?php if (!empty($error)) { ?>
      <div class="bg-danger">
        <?php echo $error; ?> <?php if ($status == 'inactive') { ?>  <a href=" <?php echo site_url(); ?>" class="btn btn-primary" role="button">Play again</a> <?php } ?>
      </div>
    <?php } ?>
    <?php if (!empty($msg)) { ?>
      <div class="bg-info">
        <?php echo $msg; ?>  <?php if ($status == 'inactive') { ?>  <a href=" <?php echo site_url(); ?>" class="btn btn-primary" role="button">Play again</a> <?php } ?>
      </div>
    <?php } ?>
    <form class="" method="post" action="">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-8">

            <?php $wordCnt = str_split($word); ?>

            <div class="borderd">
              <?php foreach ($wordCnt as $wKey) { ?>
                <span><?php echo $wKey; ?></span>
              <?php } ?>
            </div>
            <div>
              <p>Turn Left: <?php echo $guessesLeft; ?></p>
            </div>
          </div>
          <div class="col-sm-4"><?php echo $alphaStr; ?></div>
        </div>

      </div>
    </form>
  </div>
</section>