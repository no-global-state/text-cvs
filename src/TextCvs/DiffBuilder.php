<?php

/**
 * This file is part of the TextCvs Tool
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace TextCvs;

class DiffBuilder
{
    /**
     * Makes a string
     * 
     * @param string $first
     * @param string $second
     * @return string
     */
    public static function make($first, $second)
    {
        // Make sure there are no tags
        $first = strip_tags($first);
        $second = strip_tags($second);

        $processor = new DiffProcessor($first, $second);
        return $processor->render(new TagRenderer());
    }
}
