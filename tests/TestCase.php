<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    /**
     * Set the URL of the previous request.
     * Helpful when testing redirects.
     * Based on: https://www.dwightwatson.com/posts/testing-the-redirect-url-in-laravel
     *
     * @param  string  $url
     * @return $this
     */
    public function from(string $url) {
        $this->app['session']->setPreviousUrl($url);

        return $this;
    }
}
