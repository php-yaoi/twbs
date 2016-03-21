<?php

namespace Yaoi\Twbs;


use Yaoi\View\Hardcoded;
use Yaoi\View\Renderer;
use Yaoi\View\Stack;

class Layout extends Hardcoded
{
    public function isEmpty()
    {
        return false;
    }

    public $title = 'ACME labs';

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function __construct()
    {
        $this->main = new Stack();
    }

    /** @var Stack  */
    private $main;

    public function pushMain(Renderer $block) {
        $this->main->push($block);
        return $this;
    }

    public function render()
    {
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$this->title?></title>

    <!-- Bootstrap -->
      <link rel="stylesheet" href="/css/bootstrap.min.css">

      <!-- Optional theme -->
      <link rel="stylesheet" href="/css/bootstrap-theme.min.css">


      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="/js/html5shiv.min.js"></script>
      <script src="/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">
      <h1><a href="/"><?=$this->title?></a></h1>
      <?php echo $this->main ?>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
<?php
    }

}