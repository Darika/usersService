<?php

namespace App\Models\Errors;

use Exception;
use ReflectionClass;
use Throwable;

class Errors
{
    private array $currentError = [];
    private array $errorsArray = [];
    private static array $instance = [];
    private string $message = '';

    private function __construct(array $_attributes = []) {}

    public static function model(array $_attributes = []): static
    {
        if(empty(static::$instance[static::class])) {
            static::$instance[static::class] = new static($_attributes);
        }
        return static::$instance[static::class];
    }

    public static function error(array|string $error = null): static
    {
        if(empty($error)) {
            $error = ['unknown' => 'Oops something went wrong'];
        }
        if(!is_array($error)) {
            $error = (array)$error;
        }
        return self::model()->setErrors($error);
    }

    public static function exception(Throwable $exception): static
    {
        return self::model()->setErrors(['exception' => $exception->getMessage()]);
    }

    public function setContext($model): static
    {
        $classname = 'Undefined';
        try {
            $classname = (new ReflectionClass($model))->getShortName();
        } catch(Exception $exception) {
        }
        return $this->writeError($classname);
    }

    private function writeError(string $classname): self
    {
        # write log|bd
        return $this;
    }

    public function getMessage(): string
    {
        return self::arrayToString($this->getErrors());
    }

    public function setMessage(?string $message): static
    {
        $this->message .= '|' . $message;
        $this->message = trim($this->message, '| ');

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errorsArray;
    }

    private function writeException(string $classname, array $data): self
    {
        return $this;
    }

    private function setErrors(array $errors): static
    {
        $this->currentError = $errors;
        $this->errorsArray = array_merge($this->errorsArray, $errors);
        return $this;
    }

    public static function arrayToString($array): string
    {
        $string = '';
        if(is_object($array) || is_array($array)) {
            $ret = (array)$array;
            foreach($ret as &$item) {
                $string .= '|' . self::arrayToString($item);
            }

            return trim($string, '| ');
        }
        $string .= $array;

        return trim($string, '| ');
    }
}
