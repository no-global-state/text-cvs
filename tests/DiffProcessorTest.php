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

    public function testCanRemoveSentence()
    {
        $old = 'The first. The second.';
        $new = 'The first.';

        $processor = new DiffProcessor($old, $new);
        $this->assertTrue($processor->isRemoved(' The second.'));
    }

    public function testCanDetectChanges()
    {
        $old = 'The first. The second.';
        $new = 'The first. The second one.';

        $processor = new DiffProcessor($old, $new);
        $this->assertTrue($processor->isModified(' The second one.'));
    }
}
