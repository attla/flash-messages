<?php

namespace Attla\Flash;

use Attla\Support\{
    AbstractData,
    Arr as AttlaArr
};
use Illuminate\Contracts\Support\{
    Arrayable,
    Jsonable
};

class Message extends \ArrayObject implements
    Arrayable,
    Jsonable,
    \JsonSerializable
{
    use AbstractData;

    public $message = '';
    public $icon = '';
    public $type = 'info';
    public $class = '';
    public $dismissible = false;
    public $timeout;

    /**
     * Internal identifier for message
     *
     * @var string
     */
    private $id = null;

    /**
     * Set message identifier
     *
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (string) $id;
        return $this;
    }

    /**
     * Set message type
     *
     * @param mixed $type
     * @return mixed
     */
    public function setType($type = null)
    {
        return $type ?: 'info';
    }

    /**
     * Set message type
     *
     * @param mixed $type
     * @return string
     */
    public function setClass($value = null)
    {
        return (string) implode(' ', AttlaArr::toArray($value));
    }

    /**
     * Store an flash message in the session
     *
     * @param mixed $icon
     * @return $this
     */
    public function icon($icon = null): self
    {
        if (!empty($icon)) {
            $this->set(
                'icon',
                $icon != strip_tags($icon) ? $icon : '<i class="' . $this->setClass($icon) . '"></i>',
            );
        }

        Facade::sync($this);
        return $this;
    }

    public function class($class = ''): self
    {
        $this->set('class', $class);
        Facade::sync($this);
        return $this;
    }

    public function timeout(int $seconds): self
    {
        $this->set('timeout', $seconds);
        Facade::sync($this);
        return $this;
    }

    public function dismissible(): self
    {
        $this->set('dismissible', true);
        Facade::sync($this);
        return $this;
    }

    public function destroy(): bool
    {
        return Facade::destroy($this);
    }

    public function delete(): bool
    {
        return $this->destroy();
    }

    public function forget(): bool
    {
        return $this->destroy();
    }

    public function unset(): bool
    {
        return $this->destroy();
    }

    public function unqueue(): bool
    {
        return $this->destroy();
    }
}
