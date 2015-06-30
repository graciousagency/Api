<?php


namespace Robin\Api\Traits;


use Illuminate\Support\Str;

trait ViewFormatter
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
        $out = [];
        foreach ($this as $key => $value) {
            $out[ucfirst(Str::snake($key))] = $value;
        }
        return $out;
    }

    public function __toString()
    {
        return $this->toJson();
    }


}