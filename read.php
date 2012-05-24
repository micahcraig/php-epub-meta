<?php
    // modify this to point to your book directory
    #$bookdir = '/home/micah/Dropbox-DandT/Dropbox/BOOKS/PG';
    $bookdir = '/home/micah/view/domandtom/php-epub-meta/books/';


    error_reporting(E_ALL ^ E_NOTICE);

    require('util.php');

    // load epub data
    require('epub.php');
    if(isset($_REQUEST['book'])){
        try{
            $book = $_REQUEST['book'];
            $book = str_replace('..','',$book); // no upper dirs, lowers might be supported later
            $epub = new EPub($bookdir.$book.'.epub');
        }catch (Exception $e){
            $error = $e->getMessage();
        }
    }

    header('Content-Type: text/html; charset=utf-8');
?>
<html>
<head>
    <title>EPub Manager</title>

    <!-- MONOCLE CORE -->
    <script type="text/javascript" src="monocle/src/core/monocle.js"></script>
    <script type="text/javascript" src="monocle/src/compat/env.js"></script>
    <script type="text/javascript" src="monocle/src/compat/css.js"></script>
    <script type="text/javascript" src="monocle/src/compat/stubs.js"></script>
    <script type="text/javascript" src="monocle/src/compat/browser.js"></script>
    <script type="text/javascript" src="monocle/src/core/events.js"></script>
    <script type="text/javascript" src="monocle/src/core/factory.js"></script>
    <script type="text/javascript" src="monocle/src/core/styles.js"></script>
    <script type="text/javascript" src="monocle/src/core/reader.js"></script>
    <script type="text/javascript" src="monocle/src/core/book.js"></script>
    <script type="text/javascript" src="monocle/src/core/component.js"></script>
    <script type="text/javascript" src="monocle/src/core/place.js"></script>

    <!-- MONOCLE FLIPPERS -->
    <script type="text/javascript" src="monocle/src/controls/panel.js"></script>
    <script type="text/javascript" src="monocle/src/panels/marginal.js"></script>
    <script type="text/javascript" src="monocle/src/dimensions/columns.js"></script>
    <script type="text/javascript" src="monocle/src/flippers/slider.js"></script>
    <script type="text/javascript" src="monocle/src/dimensions/vert.js"></script>
    <script type="text/javascript" src="monocle/src/flippers/legacy.js"></script>

    <!-- MONOCLE STANDARD CONTROLS -->
    <script type="text/javascript" src="monocle/src/controls/spinner.js"></script>
    <script type="text/javascript" src="monocle/src/controls/magnifier.js"></script>
    <script type="text/javascript" src="monocle/src/controls/scrubber.js"></script>
    <script type="text/javascript" src="monocle/src/controls/placesaver.js"></script>
    <script type="text/javascript" src="monocle/src/controls/contents.js"></script>

    <link rel="stylesheet" type="text/css" href="monocle/styles/monocore.css" />
    <link rel="stylesheet" type="text/css" href="monocle/styles/monoctrl.css" />

    <link rel="stylesheet" type="text/css" href="monocle/test/showcase/03-conrad/test.css" />

<script type="text/javascript">
        <?php 
          if($error) {
            echo "alert('".htmlspecialchars($error)."');";
          } elseif($epub) { ?>
var bookData = {
  getComponents: function () {
    return [ <?php foreach($epub->Components() as $comp) {
      echo("'$comp', ");
    }?> ];
  },
  getContents: function () {
    return [ <?php foreach($epub->Contents() as $cont) {
      echo("{title: \"" . htmlspecialchars($cont['title']) . "\", src: '" . htmlspecialchars($cont['src']) . "'},");
    }?> ];
  },
  getComponent: function (componentId) {
    return {url:'component.php?book=<?php echo($book); ?>&componentId='+componentId};
    //return {url:'dark/'+componentId};
  },
  getMetaData: function(key) {
    return {
      title: "<?php echo($epub->Title()); ?>",
      creator: "<?php echo htmlspecialchars(join(', ',$epub->Authors()))?>"
      }[key];
  }
};
        <?php 
          }
        ?>
    </script>
    <script type="text/javascript" src="mono_test.js"></script>
</head>
<body>
  <div id="readerBg">
    <div class="board"></div>
    <div class="jacket"></div>
    <div class="dummyPage"></div>
    <div class="dummyPage"></div>
    <div class="dummyPage"></div>
    <div class="dummyPage"></div>
    <div class="dummyPage"></div>
  </div>

  <div id="readerCntr">
    <div id="reader"></div>
  </div>
</body>
</html>
