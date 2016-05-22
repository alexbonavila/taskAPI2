<?php

namespace Acme\Transformers;

class TagTransformer extends Transformer
{
    public function transform($tag)
    {
        return [
            'name' => $tag['name'],
            'some_bool' => (boolean) $tag['prova'],
        ];
    }
}