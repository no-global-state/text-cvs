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

class DiffProcessor
{
    /**
     * First collection of sentences
     * 
     * @var array
     */
    private $first;

    /**
     * Second collection of sentences
     * 
     * @var array
     */
    private $second;

    /**
     * State initialization
     * 
     * @param string $first First text version
     * @param string $second Second text version
     * @return void
     */
    public function __construct($first, $second)
    {
        $this->first = Utils::explodeText($first);
        $this->second = Utils::explodeText($second);
    }

    /**
     * Returns prepared array for rendering
     * 
     * @return array
     */
    private function getResult()
    {
        $result = array();

        foreach (Utils::arrayCombine($this->first, $this->second) as $old => $new) {
            $result[] = $old;
            // Don't add newly modified sentences
            if ($this->isModified($new)) {
                $new = null;
            }

            $result[] = $new;
        }

        return array_filter(array_unique($result));
    }

    /**
     * Checks whether sentence is modified
     * 
     * @param string $sentence
     * @return string|boolean False on failure, the previous string version on success
     */
    private function getModified($sentence)
    {
        $all = array_unique(array_merge($this->first, $this->second));

        foreach ($all as $old) {
            similar_text($old, $sentence, $percentage);
            $percentage = (int) $percentage;

            if ($percentage !== 100 && $percentage > 80) {
                return $old;
            }
        }

        return false;
    }

    /**
     * Determines whether a sentence has been modified
     * 
     * @param string $sentence
     * @return boolean
     */
    private function isModified($sentence)
    {
        return $this->getModified($sentence) !== false;
    }

    /**
     * Determines whether a sentence exist in old stack, but doesn't in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    private function isRemoved($sentence)
    {
        return in_array($sentence, $this->first) && !in_array($sentence, $this->second);
    }

    /**
     * Checks whether a sentence doesn't exist in old stack, but exist in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    private function isNew($sentence)
    {
        return !in_array($sentence, $this->first) && in_array($sentence, $this->second);
    }

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
     * Wraps changed tag
     * 
     * @param string $original
     * @param string $modified
     * @return string
     */
    private function wrapChanged($original, $modified)
    {
        return sprintf('<em data-original="%s">%s</em>', $original, $modified);
    }
    
    /**
     * Renders result
     * 
     * @return string
     */
    public function render()
    {
        $text = '';

        foreach ($this->getResult() as $sentence) {
            // Save a copy
            $target = $sentence;

            if ($this->isRemoved($sentence)) {
                $sentence = $this->wrap('del', $sentence);
            }

            if ($this->isNew($sentence)) {
                $sentence = $this->wrap('ins', $sentence);
            }

            $modified = $this->getModified($target);

            // If not false, then it exists
            if ($modified !== false) {
                $sentence = $this->wrapChanged($target, $modified);
            }

            $text .= $sentence;
        }

        return $text;
    }
}
