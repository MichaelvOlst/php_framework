<?php


namespace Core\Helper;

class Collection implements \ArrayAccess, \IteratorAggregate
{

    protected $item;

    public function __construct(array $item = [])
    {
        $this->item = $item;
    }

    public function make(array $item = [])
    {
        return new static($item);
    }


    public function has($key, $return = false)
    {
        if ($this->offsetExists($key)) {
            return true;
        }

        return false;
    }


    public function get($key)
    {
        if ($this->has($key)) {
            return $this->offsetGet($key);
        }

        $array = null;
        foreach (explode('.', $key) as $value) {
            if ((is_array($array) && array_key_exists($value, $array)) || ($array instanceof \ArrayAccess && $array->offsetExists($value))) {
                $array = $array [$value];
            }
            else{
                return $array ;
            }
        }
        return null;
    }

    
    public function offsetExists($offset)
    {
        return isset($this->item[ $offset ]);
    }

    
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->item [ $offset ];
        }

        return null;
    }

    
    public function offsetSet($offset, $value)
    {
        $this->item [ $offset ] = $value;
    }

    
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->item[ $offset ]);
        }
    }

    
    public function getIterator()
    {
        return new \ArrayIterator($this->item);
    }

    public function __toArray()
    {
        return $this->item;
    }

}