<?php

require(__DIR__.'/vendor/autoload.php');

use TextCvs\DiffProcessor;
use TextCvs\TagRenderer;

if (isset($_POST['old'], $_POST['new'])) {
    $parser = new DiffProcessor($_POST['old'], $_POST['new']);
    $text = $parser->render(new TagRenderer());
}

?>
<!DOCTYPE html>
<html>
 <head>
    <meta charset="UTF-8" />
    <title>Mini-CVS</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/assets/css/styles.css" rel="stylesheet" />
 </head>
<body>
  <div class="container">
   <h2 class="page-header">Text-CVS Tool</h2>

   <?php if (!isset($text)): ?>

   <form method="POST" charset="UTF-8">
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <textarea class="form-control" name="old" placeholder="Type the first version"></textarea>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <textarea class="form-control" name="new" placeholder="Type the second version"></textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-default">Compare</button>
   </form>
   <?php else: ?>
    <pre><?php echo $text; ?></pre>

   <?php endif; ?>
  </div>

  <script src="/assets/js/jquery.min.js"></script>
  <script src="/assets/js/app.js"></script>

</body>
</html>