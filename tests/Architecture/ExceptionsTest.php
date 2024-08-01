<?php

arch('exceptions extend the base exception')
    ->expect('Tallboy\Exceptions')
    ->toExtend('\Exception');

arch('exceptions have the correct suffix')
    ->expect('Tallboy\Exceptions')
    ->toHaveSuffix('Exception');

arch('exceptions are make-able')
    ->expect('Tallboy\Exceptions')
    ->toHaveMethod('make');
