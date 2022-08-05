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
        // Dispatcher $events = null,
        Repository $config = null
    ) {
        $this->session = $session;
        // $this->events = $events;
        $this->config = $config;
    }

    /**
     * Create new message identifier
     *
     * @return string
     */
    protected function createMessageId(): string
    {
        $time = microtime(true) . mt_rand(99, 9999999);
        return base_convert(preg_replace('/[^0-9]/', '', $time), 10, 36);
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

        // $default =  collect();

        // $session = $this->flashs instanceof Collection
        //     ? $this->flashs
        //     : $this->session->get($this->flashName, $default);

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
            $this->flashs = $this->getSession()->get($message->getId())->update($message)
        );
        // $this->session->put(
        //     $this->flashName,
        //     $this->getSession()->put(
        //         $key = $message->getType(),
        //         $this->getSession($key)
        //             ->put($message->getId(), $message)
        //     )
        // );
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

        // $types = $this->getSession($message['type']);
        // $lastFlashId = $this->getFlashId();

        // tenta remover o ultimo objeto dai set o novo
        // verificar se ha possibilidade de o objeto antigo ser removido mesmo
        // se não for chamado por um metodo auxiliar como o class,icon,timeout e dimissable

        // if ($types->has($lastFlashId = $this->getFlashId())) {
        //     $msg = $types->get($lastFlashId);
        //     $types->forget($lastFlashId);
        // } else {
        //     $msg = new Message([
        //         'message' => $message['message'] ?? '',
        //         'type' => $message['type'],
        //     ]);
        // }
        // $types->has($lastFlashId = $this->getFlashId()) && $types->forget($lastFlashId);

        // $types->put($this->getFlashId($msg), $msg);

        $this->sync(
            $message = (new Message([
                'message' => $data['message'] ?? '',
                'type' => $type = $data['type'] ?? '',
            ]))->setId($this->createMessageId())
            ->icon($this->getConfig('icons.' . $type))
        );

        return $message;
    }

    /**
     * Retrieve flash config
     *
     * @param string $key
     * @return mixed
     */
    protected function getConfig($key = null)
    {
        return $this->config->get('flash-messages.' . $key);
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
            'type' => $this->getConfig('types.' . $name),
            'message' => $arguments[0],
        ]);
    }
}
