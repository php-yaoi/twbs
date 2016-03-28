<?php

namespace Yaoi\Twbs\Io\Content;

use Yaoi\Command;
use Yaoi\Command\Definition;
use Yaoi\Command\Io;
use Yaoi\Io\Content\Renderer;

class Form implements Renderer
{
    /** @var Command|\stdClass */
    protected $commandState;
    /** @var Io */
    protected $io;


    public function __construct($commandState, Io $io)
    {
        $this->commandState = $commandState;
        $this->io = $io;
    }


    public function isEmpty()
    {
        // TODO: Implement isEmpty() method.
    }

    protected static $surrogateId;

    public function render()
    {
        /** @var Command $class */
        $class = $this->commandState->commandClass;
        $action = $this->io->makeAnchor($class::createState());

        echo '<form method="post" action="' . $action . '">';
        foreach ($class::definition()->optionsArray() as $option) {

            $value = '';
            if (isset($this->commandState->{$option->name})) {
                $value = $this->commandState->{$option->name};
                if ($value instanceof Definition) {
                    $value = '';
                }
            }

            $labelCaption = $option->description ? $option->description : $option->name;
            $id = 'formItem' . ++self::$surrogateId;
            $name = $this->io->getRequestMapper()->getExportName($option);
            $this->io;
            echo <<<HTML
 <div class="form-group">
    <label for="$id">$labelCaption</label>
    <input class="form-control" id="$id" name="$name" placeholder="$labelCaption" value="$value">
 </div>
  
HTML;

        }
        echo '<button type="submit">piu piu</button></form>';
    }

    public function __toString()
    {
        ob_start();
        try {
            $this->render();
        }
        catch (\Exception $e) {
            var_dump($e);
        }
        return ob_get_clean();
    }


}