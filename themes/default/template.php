<?php
$siteName = 'Hangman';
$lang_iso3 = 'en_US';
$lang_iso2 = 'en';
$lang_dir = 'ltr';
$sess_set = 0;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $lang_dir; ?>" lang="<?php echo $lang_iso3; ?>"
      xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1.0, user-scalable=no">
      <meta name="theme-color" content="#ffffff">
        <?php echo $_styles; ?>

        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css?v=<?php echo getFileModifiedDateTime('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/main.css?v=<?php echo getFileModifiedDateTime('assets/css/main.css'); ?>" rel="stylesheet" type="text/css" />
        <script type="text/javascript">
          var baseUrl = '<?php echo site_url(); ?>';
          var site_language = '<?php echo $lang_iso2; ?>';
        </script>
        <title><?php echo ($metaTitle != "") ? strip_tags(str_replace(array('&nbsp;'), '', $metaTitle)) : $siteName; ?></title>
        <meta name="description" content="<?php echo ($metaDescription != "") ? strip_tags(str_replace(array('&nbsp;'), '', $metaDescription)) : $siteName; ?>"/>
        <!--<link rel="icon" sizes="32x32" href="<?php echo base_url(); ?>assets/images/favicon-32x32.png">-->
        </head>
        <body class="<?php
        if (isset($bodyClass)) {
          echo $bodyClass;
        }
        ?>">
                <?php echo $header; ?>
                <?php echo $content; ?>
                <?php echo $footer; ?>

          <script src="<?php echo base_url(); ?>assets/scripts/jquery-1.11.3.min.js" type="text/javascript"></script>
          <script src="<?php echo base_url(); ?>assets/scripts/bootstrap.min.js" type="text/javascript"></script>
          <script src="<?php echo base_url() . THEME_ASSETS_LOCATION; ?>js/custom.js?v=<?php echo getFileModifiedDateTime(THEME_ASSETS_LOCATION . 'js/custom.js'); ?>" type="text/javascript"></script>
          <?php echo $_scripts; ?>

        </body>
        </html>