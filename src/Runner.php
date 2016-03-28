<?php

namespace Yaoi\Twbs;

use Yaoi\Twbs\Response;
use Yaoi\Twbs\Layout;
use Yaoi\BaseClass;
use Yaoi\Command;
use Yaoi\Io\Request;

class Runner extends BaseClass
{
    public static function run(Command\Definition $definition, Request $request = null)
    {
        if (null === $request) {
            $request = Request::createAuto();
        }

        $requestMapper = new Command\Web\RequestMapper($request);
        $response = new Response();

        $layout = new Layout();
        $layout->pushMain($response);

        try {
            $io = new Command\Io($definition, $requestMapper, $response);
            $io->getCommand()->performAction();
        }
        catch (\Exception $exception) {
            $response->error($exception->getMessage());
        }

        $layout->render();
    }




}


