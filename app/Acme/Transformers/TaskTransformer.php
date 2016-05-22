<?php


namespace Acme\Transformers;

class TaskTransformer extends Transformer

{
    public function transform($task)
    {
        return [
            'name' => $task['name'],
            'some_bool' => $task['done'],
            'priority' => (boolean) $task['priority'],
        ];
    }
}