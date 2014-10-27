<?php

namespace PedroTroller\TogetherJs\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AddScriptListener
{
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();

        if (!$event->isMasterRequest()) {
            return;
        }

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $this->injectScript($response);
    }

    private function injectScript(Response $response)
    {
        $content = $response->getContent();
        $pos = strripos($content, '</body>');

        $script = sprintf('<script src="%s"></script>', 'https://togetherjs.com/togetherjs-min.js');

        if (false !== $pos) {
            $content = substr($content, 0, $pos).$script.substr($content, $pos);
            $response->setContent($content);
        }
    }
}
