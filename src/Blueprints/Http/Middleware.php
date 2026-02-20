<?php
namespace PatrykNamyslak\Pouter\Blueprints\Http;

use Closure;

interface Middleware{
    public function handle(Request $request) :mixed;
    public function failure(Request $request): void;
}