<?php
declare(strict_types=1);

namespace iutnc\deefy\render;

interface Renderer {
    public function render(int $selector): string;
}