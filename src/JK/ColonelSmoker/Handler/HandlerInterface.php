<?php

namespace JK\ColonelSmoker\Handler;

use JK\ColonelSmoker\Url\Url;

interface HandlerInterface
{
    public function handle(Url $url);
}
