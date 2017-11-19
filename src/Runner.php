<?php

namespace Yaoi\Twbs;

use Yaoi\BaseClass;
use Yaoi\Command;
use Yaoi\Database\Exception;
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
        $response->setLayout($layout);

        try {
            $io = new Command\Io($definition, $requestMapper, $response);
            $io->getCommand()->performAction();
        }
        catch (Exception $exception) {
            $response->error($exception->getMessage());
            $response->error($exception->query);
            $response->error('<pre>' . $exception->getTraceAsString() . '</pre>');
        }
        catch (\Exception $exception) {
            $response->error($exception->getMessage());
            $response->error('<pre>' . $exception->getTraceAsString() . '</pre>');
        }

        $layout->render();
    }




}


