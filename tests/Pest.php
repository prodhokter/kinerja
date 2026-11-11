<?php

declare(strict_types=1);

use Tests\TestCase;

pest()->extend(TestCase::class)->in('Unit');

pest()->extend(TestCase::class)
    ->beforeEach(function () {
        $this->withSession(['is_guest' => true]);
    })
    ->in('Feature');
