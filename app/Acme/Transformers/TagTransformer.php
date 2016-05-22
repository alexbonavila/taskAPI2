<?php

namespace Acme\Transformers;

class TagTransformer extends Transformer
{
    public function transform($tag)
    {
        return [
            'title' => $tag['title']
            //'some_bool' => (boolean) $tag['prova'],
        ];
    }
}