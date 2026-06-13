<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\File;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $compiledViews = sys_get_temp_dir().DIRECTORY_SEPARATOR.'cydcactivitiesdb-test-views';

        File::ensureDirectoryExists($compiledViews);
        config()->set('view.compiled', $compiledViews);
    }
}
