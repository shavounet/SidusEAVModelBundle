<?php
namespace Sidus\EAVModelBundle\Event;


use Sidus\EAVModelBundle\Context\ContextManagerInterface;
use Sidus\EAVModelBundle\Form\ContextFormBuilderInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class ContextListener
{

    /** @var ContextFormBuilderInterface */
    protected $contextFormBuilder;

    /** @var ContextManagerInterface */
    protected $contextManager;

    /**
     * ContextListener constructor.
     *
     * @param ContextFormBuilderInterface $contextFormBuilder
     * @param ContextManagerInterface     $contextManager
     */
    public function __construct(ContextFormBuilderInterface $contextFormBuilder, ContextManagerInterface $contextManager)
    {
        $this->contextFormBuilder = $contextFormBuilder;
        $this->contextManager = $contextManager;
    }

    /**
     * Global hook checking if context form was submitted because the context form can appear on any page
     *
     * @param GetResponseEvent $event
     *
     * @throws \InvalidArgumentException
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $form = $this->contextFormBuilder->getContextSelectorForm();
        if (!$form) {
            return;
        }
        $form->handleRequest($request);

        // Check if form is submitted and redirect to same url in POST
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contextManager->setContext($form->getData());

            if ($request->isMethod('POST')) {
                $redirectResponse = new RedirectResponse($event->getRequest()->getRequestUri());
                $event->setResponse($redirectResponse);
            }
        }
    }

}
