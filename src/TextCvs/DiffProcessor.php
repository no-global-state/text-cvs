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

use Krystal\Text\TextUtils;
use Krystal\Stdlib\ArrayUtils;

final class DiffProcessor implements DiffProcessorInterface
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
        $this->first = TextUtils::explodeText($first);
        $this->second = TextUtils::explodeText($second);
    }

    /**
     * Returns prepared array for rendering
     * 
     * @return array
     */
    private function createResult()
    {
        $result = array();

        foreach (ArrayUtils::arrayCombine($this->first, $this->second) as $old => $new) {
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
    public function isModified($sentence)
    {
        return $this->getModified($sentence) !== false;
    }

    /**
     * Determines whether a sentence exist in old stack, but doesn't in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    public function isRemoved($sentence)
    {
        return in_array($sentence, $this->first) && !in_array($sentence, $this->second);
    }

    /**
     * Checks whether a sentence doesn't exist in old stack, but exist in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    public function isNew($sentence)
    {
        return !in_array($sentence, $this->first) && in_array($sentence, $this->second);
    }

    /**
     * Renders result
     * 
     * @param \TextCvs\TagRendererInterface $render
     * @return string
     */
    public function render(TagRendererInterface $render)
    {
        $text = null;

        foreach ($this->createResult() as $sentence) {
            // Save a copy
            $target = $sentence;

            if ($this->isRemoved($sentence)) {
                $sentence = $render->wrapRemoved($sentence);
            }

            if ($this->isNew($sentence)) {
                $sentence = $render->wrapInserted($sentence);
            }

            $modified = $this->getModified($target);

            // If not false, then it exists
            if ($modified !== false) {
                $sentence = $render->wrapChanged($target, $modified);
            }

            $text .= $sentence;
        }

        return $text;
    }
}
