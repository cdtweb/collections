<?php declare(strict_types=1);

namespace Cdtweb\Collection;

class CollectionException extends \Exception
{
    protected $collection;

    public function __construct($message = "", $collection = null)
    {
        parent::__construct($message, 0, null);
        $this->collection = $collection;
    }

    public function getCollection()
    {
        return $this->collection;
    }
}
