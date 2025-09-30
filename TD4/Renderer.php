<?php

interface Renderer{
    const COMPACT="COMPACT";
    const LONG="LONG";
    public function render(int $selector):string;
}