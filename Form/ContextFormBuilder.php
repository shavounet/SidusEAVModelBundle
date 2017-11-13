<?php

namespace Sidus\EAVModelBundle\Form;


use Sidus\EAVModelBundle\Context\ContextManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ContextFormBuilder implements ContextFormBuilderInterface
{

    /** @var string */
    protected $contextSelectorType;

    /** @var FormInterface */
    protected $contextSelectorForm;

    /** @var Request */
    protected $request;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var ContextManagerInterface */
    protected $contextManager;

    /**
     * ContextFormBuilder constructor.
     *
     * @param string                  $contextSelectorType
     * @param RequestStack            $requestStack
     * @param FormFactoryInterface    $formFactory
     * @param ContextManagerInterface $contextManager
     */
    public function __construct($contextSelectorType, RequestStack $requestStack, FormFactoryInterface $formFactory, ContextManagerInterface $contextManager)
    {
        $this->contextSelectorType = $contextSelectorType;
        $this->request = $requestStack->getCurrentRequest();
        $this->formFactory = $formFactory;
        $this->contextManager = $contextManager;
    }


    /**
     * {@inheritdoc}
     */
    public function getContextSelectorForm()
    {
        if (!$this->contextSelectorForm) {
            if (!$this->contextSelectorType) {
                return null;
            }

            $formOptions = [
                'action' => $this->request->getRequestUri(),
                'attr'   => [
                    'novalidate' => 'novalidate',
                    'class'      => 'form-inline',
                ],
            ];
            $this->contextSelectorForm = $this->formFactory->createNamed(
                ContextManagerInterface::SESSION_KEY,
                $this->contextSelectorType,
                $this->contextManager->getContext(),
                $formOptions
            );
        }

        return $this->contextSelectorForm;
    }

}
