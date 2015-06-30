<?php


namespace Robin\Api\Traits;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;

trait ModelFormatter
{

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function toArray()
    {
        $arr = [];
        foreach ($this as $key => $value) {
            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }
            $arr[Str::snake($key)] = $value;
        }

        return $arr;
    }

    public function __toString()
    {
        return $this->toJson();
    }

}