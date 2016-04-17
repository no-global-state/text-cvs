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

use Krystal\Form\NodeElement;

final class TagRenderer implements TagRendererInterface
{
    /**
     * Creates a tag
     * 
     * @param string $name Tag name
     * @param string $text Inner text
     * @param array $attrs Optional attributes
     * @return string
     */
    private function createTag($name, $text, array $attrs = array())
    {
        $tag = new NodeElement();
        $tag->openTag($name);

        if (!empty($attrs)) {
            $tag->addAttributes($attrs);
        }

        return $tag->finalize()
                   ->setText($text)
                   ->closeTag()
                   ->render();
    }

    /**
     * Wraps inserted text
     * 
     * @param string $text
     * @return string
     */
    public function wrapInserted($text)
    {
        return $this->createTag('ins', $text);
    }

    /**
     * Wraps removed text
     * 
     * @param string $text
     * @return string
     */
    public function wrapRemoved($text)
    {
        return $this->createTag('del', $text);
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
        return $this->createTag('em', $modified, array('data-original' => $original));
    }
}
