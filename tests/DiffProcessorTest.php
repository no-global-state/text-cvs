<?php

use TextCvs\DiffProcessor;

class DiffProcessorTest extends \PHPUnit_Framework_TestCase
{
    public function testCanAddNewSentence()
    {
        $old = 'The first.';
        $new = 'The first. The new one.';

        $processor = new DiffProcessor($old, $new);
        $this->assertTrue($processor->isNew(' The new one.'));
    }
}
