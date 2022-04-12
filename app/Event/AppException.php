<?php

declare(strict_types=1);

namespace App\Event;

class AppException
{
    /**
     * @var \Exception | \Throwable | null
     */
    public $exception;

    /**
     * @var array
     */
    public $data = [];

    /**
     * AppException constructor.
     *
     * @param \Exception | \Throwable $exception
     * @param array                   $data
     */
    public function __construct($exception, array $data)
    {
        $this->exception = $exception;
        $this->data      = $data;

    }
}
