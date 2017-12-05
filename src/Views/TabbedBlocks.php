<?php
namespace Yaoi\Twbs\Views;

use Yaoi\View\Hardcoded;

class TabbedBlocks extends Hardcoded
{
    private $active = null;

    private static $seq = 0;
    private $id;

    public function __construct($id = null)
    {
        if ($id === null) {
            $id = 'tabs-' . ++self::$seq;
        }
        $this->id = $id;
    }

    /** @var string[] */
    private $blocks = [];

    public function addBlock($title, $content, $isActive = false)
    {
        if ($this->active === null) {
            $isActive = true;
        }

        if ($isActive) {
            $this->active = $title;
        }

        $this->blocks[$title] = $content;
        return $this;
    }


    public function render()
    {
        ?>
        <div>

            <ul class="nav nav-tabs" role="tablist">
                <?php
                $i = 0;
                foreach ($this->blocks as $title => $content) {
                    ++$i;
                    $tabId = $this->id . '-' . $i;
                    ?>
                    <li role="presentation"<?= $this->active === $title ? ' class="active"' : '' ?>>
                        <a href="#<?=$tabId?>" role="tab" data-toggle="tab"><?= $title ?></a>
                    </li>
                <?php } ?>
            </ul>
            <div class="tab-content">
                <?php
                $i = 0;
                foreach ($this->blocks as $title => $content) {
                    ++$i;
                    $tabId = $this->id . '-' . $i;
                    ?>
                    <div role="tabpanel" class="tab-pane<?= $this->active === $title ? ' active' : '' ?>" id="<?=$tabId?>">
                        <?= $content ?>
                    </div>
                <?php } ?>

            </div>
        </div>

        <?php
    }
}