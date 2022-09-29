<?php

namespace Telepath\Middleware\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Middleware
{

    public function __construct(
        public \Telepath\Middleware\Middleware|string $middleware
    ) {}

}