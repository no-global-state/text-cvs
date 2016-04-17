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

final class TagRenderer implements TagRendererInterface
{
    /**
     * Wraps into a tag
     * 
     * @param string $tag
     * @param string $text
     * @return string
     */
    private function wrap($tag, $text)
    {
        return sprintf('<%s>%s</%s>', $tag, $text, $tag);
    }

    /**
     * Wraps inserted text
     * 
     * @param string $text
     * @return string
     */
    public function wrapInserted($text)
    {
        return $this->wrap('ins', $text);
    }

    /**
     * Wraps removed text
     * 
     * @param string $text
     * @return string
     */
    public function wrapRemoved($text)
    {
        return $this->wrap('del', $text);
    }

    /**
     * Wraps changed tag
     * 
     * @param string $original
     * @param string $modified
     * @return string
     */
    public function wrapChanged($original, $modified)
    {
        return sprintf('<em data-original="%s">%s</em>', $original, $modified);
    }
}
