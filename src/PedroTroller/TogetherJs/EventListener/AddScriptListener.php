<?php

namespace PedroTroller\TogetherJs\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Templating\EngineInterface;

class AddScriptListener
{
    private $templating;
    private $configuration;

    public function __construct(EngineInterface $templating, array $configuration)
    {
        $this->templating    = $templating;
        $this->configuration = $configuration;
    }

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
        $configuration = $this->configuration;
        $pos = strripos($content, '</body>');

        $script = $this->templating->render($configuration['template'], [ 'configuration' => $configuration ]);

        if (false !== $pos) {
            $content = substr($content, 0, $pos).$script.substr($content, $pos);
            $response->setContent($content);
        }
    }
}
