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

    /**
     * Flash message
     *
     * @var string
     */
    public $message = '';

    /**
     * Flash icon
     *
     * @var string
     */
    public $icon = '';

    /**
     * Flash type class
     *
     * @var string
     */
    public $type = 'info';

    /**
     * Flash custom classes
     *
     * @var string
     */
    public $class = '';

    /**
     * Indicate if is dismissible
     *
     * @var bool
     */
    public $dismissible = false;

    /**
     * Flash timeout in seconds
     *
     * @var int
     */
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

    /**
     * Set classes for the flash message
     *
     * @param mixed $class
     * @return $this
     */
    public function class($class = ''): self
    {
        $this->set('class', $class);
        Facade::sync($this);
        return $this;
    }

    /**
     * Set timeout for the flash message
     *
     * @param int $seconds
     * @return $this
     */
    public function timeout(int $seconds): self
    {
        $this->set('timeout', $seconds);
        $this->set('dismissible', false);
        Facade::sync($this);
        return $this;
    }

    /**
     * Make the flash message dismissible
     *
     * @return $this
     */
    public function dismissible(): self
    {
        $this->set('dismissible', true);
        $this->set('timeout', null);
        Facade::sync($this);
        return $this;
    }

    /**
     * Destroy the flash message
     *
     * @return bool
     */
    public function destroy(): bool
    {
        return Facade::destroy($this);
    }

    /**
     * Alias for destroy()
     *
     * @return bool
     */
    public function delete(): bool
    {
        return $this->destroy();
    }

    /**
     * Alias for destroy()
     *
     * @return bool
     */
    public function forget(): bool
    {
        return $this->destroy();
    }

    /**
     * Alias for destroy()
     *
     * @return bool
     */
    public function unset(): bool
    {
        return $this->destroy();
    }

    /**
     * Alias for destroy()
     *
     * @return bool
     */
    public function unqueue(): bool
    {
        return $this->destroy();
    }
}
