<?php

namespace Yaoi\Twbs\Io\Content;

use Yaoi\Command\Definition;
use Yaoi\Command\Io;
use Yaoi\Io\Content\Renderer;

class Form implements Renderer
{
    /** @var Definition */
    protected $definition;
    /** @var Io */
    protected $io;

    public function __construct(Definition $definition, Io $io)
    {
        $this->definition = $definition;
    }


    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    protected static $surrogateId;

    public function render()
    {
        echo '<form method="post">';
        foreach ($this->definition->optionsArray() as $option) {
            $labelCaption = $option->description ? $option->description : $option->name;
            $id = 'formItem' . ++self::$surrogateId;
            $name = $this->io->getRequestMapper()->getExportName($option);
            $this->io;
            echo <<<HTML
 <div class="form-group">
    <label for="$id">$labelCaption</label>
    <input class="form-control" id="$id" name="$name" placeholder="$labelCaption">
 </div>
  
HTML;

        }
        echo '</form>';
    }

    public function __toString()
    {
        return '';
    }


}