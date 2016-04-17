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

interface TagRendererInterface
{
    /**
     * Wraps inserted text
     * 
     * @param string $text
     * @return string
     */
    public function wrapInserted($text);

    /**
     * Wraps removed text
     * 
     * @param string $text
     * @return string
     */
    public function wrapRemoved($text);

    /**
     * Wraps changed tag
     * 
     * @param string $original
     * @param string $modified
     * @return string
     */
    public function wrapChanged($original, $modified);
}
