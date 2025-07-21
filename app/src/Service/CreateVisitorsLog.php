<?php

namespace App\Service;

class CreateVisitorsLog
{
    public function create_log(string $name): string
    {
        return "Hello, " . $name;
    }
}
