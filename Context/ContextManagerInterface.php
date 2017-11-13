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

/**
 * Manager for setting, saving and getting the current context when using ContextualData & ContextualValue
 *
 * @author Valentin Clavreul <vclavreul@clever-age.com>
 */
interface ContextManagerInterface
{
    const SESSION_KEY = 'sidus_data_context';

    /**
     * Get the current context
     *
     * @return array
     */
    public function getContext();

    /**
     * Set the current context
     * Note that the context values are not validated (except using the standard form)
     *
     * @param array $context
     */
    public function setContext(array $context);

    /**
     * Get the default context
     *
     * @return array
     */
    public function getDefaultContext();
}
