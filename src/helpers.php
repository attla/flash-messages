<?php

use Attla\Flash\Factory;

/**
 * Arrange for a flash message
 *
 * @param string $text
 * @param string|array $type
 * @return Attla\Flash\Factory
 */
function flash(string $message = null, $type = null): Factory
{
    $notifier = app(Factory::class);

    if (is_null($message)) {
        return $notifier;
    }

    $notifier->message(compact(
        'message',
        'type',
    ));

    return $notifier;
}
