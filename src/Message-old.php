<?php

namespace Attla\Flash;

class Message
{
    public $message;
    public $class;
    public $level;

    public function __construct(string $message, $class = null, $level = null)
    {
        if (is_array($class)) {
            $class = implode(' ', $class);
        }

        $this->message = $message;
        $this->class = $class;
        $this->level = $level;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'class' => $this->class,
            'level' => $this->level,
        ];
    }
}
