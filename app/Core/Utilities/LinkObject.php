<?php

namespace App\Core\Utilities;

class LinkObject
{
    public function __construct(public string $rel, public string $label, public string $url, public string $method, public string $icon = '') {}
}
