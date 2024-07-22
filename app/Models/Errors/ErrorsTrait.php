<?php

namespace App\Models\Errors;

/**
 * This is the model class for errors.
 *
 * @property array|null errors
 * @property string|null $message
 */
trait ErrorsTrait
{
    public string $message = '';
    private mixed $debug;
    private ?Errors $error = null;

    public static function sendErrors(array $error = null): static
    {
        return (new static())->setError(Errors::error($error, new self()));
    }

    public function getErrorsString(): ?string
    {
        return $this->error ? json_encode($this->error->getErrors(), JSON_UNESCAPED_UNICODE) : null;
    }

    public function getError(): ?Errors
    {
        return $this->error;
    }

    public function setError(Errors $error): static
    {
        $this->error = $error;
        $this->error->setContext($this);
        return $this;
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebug(): mixed
    {
        return $this->debug;
    }

    /**
     * @param mixed $debug
     * @return ErrorsTrait
     */
    public function setDebug(mixed $debug): static
    {
        $this->debug = $debug;
        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->error);
    }

}
