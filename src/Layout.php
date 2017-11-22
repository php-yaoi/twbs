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
    public $description = '';
    public $author = '';
    public $faviconUrl = '/favicon.ico';

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

    public $footerScriptUrls = array();
    public $headScriptUrls = array();
    public $footerScripts = array();
    public $headScripts = array();
    public $styleUrls = array();

    public function pushMain(Renderer $block) {
        $this->main->push($block);
        return $this;
    }

    protected function renderHeader()
    {
        return;
    }

    protected function renderFooter()
    {
        return;
    }

    protected function renderTail()
    {
        ?>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/twbs/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="/twbs/js/ie10-viewport-bug-workaround.js"></script>
        <?php
        if ($this->footerScriptUrls) {
            foreach ($this->footerScriptUrls as $url) {
                echo '<script src="' . $url . '"></script>', "\r\n";
            }
        }
        if ($this->footerScripts) {
            foreach ($this->footerScripts as $code) {
                echo '<script>' . $code . '</script>', "\r\n";
            }
        }

    }

    protected function renderHead()
    {
        ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="<?=$this->description?>">
    <meta name="author" content="<?=$this->author?>">
    <link rel="icon" href="<?=$this->faviconUrl?>">

    <title><?= $this->title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="/twbs/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/twbs/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/twbs/js/html5shiv.min.js"></script>
    <script src="/twbs/js/respond.min.js"></script>
    <![endif]-->
    <script src="/twbs/js/jquery.min.js"></script>
    <?php
    if ($this->styleUrls) {
        foreach ($this->styleUrls as $url) {
            echo '<link href="' . $url . '" rel="stylesheet">', "\r\n";
        }
    }
    if ($this->headScriptUrls) {
        foreach ($this->headScriptUrls as $url) {
            echo '<script src="' . $url . '"></script>', "\r\n";
        }
    }
    if ($this->headScripts) {
        foreach ($this->headScripts as $code) {
            echo '<script>' . $code . '</script>', "\r\n";
        }
    }
    ?>
</head>

        <?php
    }

    public function render()
    {
        ?>
<!DOCTYPE html>
<html lang="en">
<?php $this->renderHead() ?>
<body>

<?php $this->renderHeader() ?>

<div class="container">
    <h1><a href="/"><?= $this->title ?></a></h1>
    <?php echo $this->main ?>
</div>

<?php $this->renderFooter() ?>
<?php $this->renderTail() ?>

</body>
</html>
        <?php
    }

}