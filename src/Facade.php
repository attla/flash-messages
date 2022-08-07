<?php

namespace Attla\Flash;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method static string getName()
 * @method static void sync(\Attla\Flash\Message $message)
 * @method static void destroy(\Attla\Flash\Message $message)
 *
 * @see \Attla\Flash\Factory
 */
class Facade extends BaseFacade
{
    /**
     * Get the registered name of the component
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'flash';
    }
}
