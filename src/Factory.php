<?php

namespace Attla\Flash;

use Attla\Support\Arr as AttlaArr;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

class Factory
{
    /**
     * Store the session instance
     *
     * @var \Illuminate\Contracts\Session\Session
     */
    protected $session;

    /**
     * The event dispatcher instance
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Store the config instance
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Flash name on session storage
     *
     * @var string
     */
    protected $flashName = '__flash';

    /**
     * Last hash of stored flash message
     *
     * @var string
     */
    protected $lastMessage;

    /**
     * Stored flash session
     *
     * @var \Illuminate\Support\Collection
     */
    protected $flashs;

    /**
     * Create a new factory instance
     *
     * @param \Illuminate\Contracts\Session\Session $session
     * @param \Illuminate\Config\Repository $config
     * @return void
     */
    public function __construct(
        Session $session = null,
        Repository $config = null
    ) {
        $this->session = $session;
        $this->config = $config;
    }

    /**
     * Create new message identifier
     *
     * @return string
     */
    protected function createMessageId(): string
    {
        $time = microtime(true) . mt_rand(-999999, 9999999);
        return str_shuffle(base_convert(preg_replace('/[^0-9]/', '', $time), 10, 36));
    }

    /**
     * Get stored flash messages
     *
     * @return \Illuminate\Support\Collection
     *
     * @throws \InvalidArgumentException
     */
    protected function getSession()
    {
        if (!$this->session) {
            throw new \InvalidArgumentException('The session instance is needed to fire a flash message.');
        }

        if ($this->flashs instanceof Collection) {
            return $this->flashs;
        }

        return $this->flashs = $this->session->get($this->flashName, collect());
    }

    /**
     * Sync message on session storage
     *
     * @param \Attla\Flash\Message $message
     * @return void
     */
    public function sync(Message $message)
    {
        $this->session->flash(
            $this->flashName,
            $this->flashs = $this->getSession()->put($message->getId(), $message)
        );
    }

    /**
     * Destroy an message on session storage
     *
     * @param \Attla\Flash\Message $message
     * @return void
     */
    public function destroy(Message $message)
    {
        $this->session->flash(
            $this->flashName,
            $this->flashs = $this->getSession()->forget($message->getId())
        );
    }

    /**
     * Create a new flash message
     *
     * @param mixed $data
     * @return \Attla\Flash\Message
     *
     * @throws \InvalidArgumentException
     */
    public function message($data)
    {
        if (is_string($data)) {
            $data = ['message' => $data];
        } elseif (!is_array($data)) {
            $data = AttlaArr::toArray($data);
        }

        if (empty($data['message'])) {
            throw new \InvalidArgumentException('The "message" parameter must be provide.');
        }

        $this->sync(
            $message = (new Message([
                'message' => $data['message'] ?? '',
                'type' => $data['type'] ?? '',
                'icon' => $data['icon'] ?? '',
                'id' => $this->createMessageId(),
            ]))
        );

        return $message;
    }

    /**
     * Retrieve flash config
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getConfig($key = null, $default = null)
    {
        return $this->config->get('flash-messages.' . $key, $default);
    }

    /**
     * Retrieve flash session name
     *
     * @return string
     */
    public function getName()
    {
        return $this->flashName;
    }

    /**
     * Dynamically create a flash message
     *
     * @param string $name
     * @param array $arguments
     * @return \Attla\Flash\Message
     */
    public function __call($name, $arguments)
    {
        if (!$this->config) {
            throw new \InvalidArgumentException('The config instance is needed to fire a flash message.');
        }

        if (count($arguments) != 1) {
            throw new \InvalidArgumentException(
                'For set "' . $name . '" flash message you must provide the message parameter.'
            );
        }

        return $this->message([
            'message' => $arguments[0],
            'type' => $this->getConfig('types.' . $name),
            'icon' => $this->getConfig('icons.' . $name, ''),
        ]);
    }
}
