<?php

namespace App\Support\Transformers;

use League\Fractal\Serializer\ArraySerializer;

class CustomArraySerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        // return $resourceKey ? [$resourceKey => $data] : $data;
        if ($resourceKey === FALSE) {
            return $data;
        }

        return $data;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        // return $resourceKey ? [$resourceKey => $data] : $data;
        if ($resourceKey === FALSE) {
            return $data;
        }

        return $data;
    }
}
