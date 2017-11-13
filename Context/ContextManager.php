<?php
/*
 *  Sidus/EAVModelBundle : EAV Data management in Symfony 3
 *  Copyright (C) 2015-2017 Vincent Chalnot
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Sidus\EAVModelBundle\Context;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Manager for setting, saving and getting the current context when using ContextualData & ContextualValue
 *
 * @author Vincent Chalnot <vincent@sidus.fr>
 */
class ContextManager implements ContextManagerInterface
{

    /** @var array */
    protected $defaultContext;

    /** @var array */
    protected $context;

    /** @var SessionInterface */
    protected $session;

    /**
     * ContextManager constructor.
     *
     * @param array            $defaultContext
     * @param SessionInterface $session
     */
    public function __construct(array $defaultContext, SessionInterface $session)
    {
        $this->defaultContext = $defaultContext;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        // If context exists in the session, use this information
        if ($this->getSession() && $this->getSession()->has(self::SESSION_KEY)) {
            return $this->getSession()->get(self::SESSION_KEY);
        }

        // If context was saved in the service, this means we are probably in command-line
        if ($this->context) {
            return $this->context;
        }

        return $this->getDefaultContext();
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(array $context)
    {
        // Try to save the context in session, fallback to property in service otherwise
        if ($this->getSession()) {
            $this->getSession()->set(self::SESSION_KEY, $context);
            $this->getSession()->save();
        } else {
            $this->context = $context;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultContext()
    {
        return $this->defaultContext;
    }

    /**
     * @return null|SessionInterface
     */
    protected function getSession()
    {
        if ($this->session) {
            return $this->session;
        }

        return null;
    }
}
