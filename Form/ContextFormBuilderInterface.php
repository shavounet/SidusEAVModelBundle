<?php
namespace Sidus\EAVModelBundle\Form;


use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

interface ContextFormBuilderInterface
{

    /**
     * @throws InvalidOptionsException
     *
     * @return FormInterface
     */
    public function getContextSelectorForm();
}
