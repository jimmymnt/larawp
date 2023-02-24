<?php

namespace LaraWP\Wordpress\Contracts;

interface Shortcode
{
    public function getTag();

    public function render();
}