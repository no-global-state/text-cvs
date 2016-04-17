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

interface DiffProcessorInterface
{
    /**
     * Determines whether a sentence has been modified
     * 
     * @param string $sentence
     * @return boolean
     */
    public function isModified($sentence);

    /**
     * Determines whether a sentence exist in old stack, but doesn't in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    public function isRemoved($sentence);

    /**
     * Checks whether a sentence doesn't exist in old stack, but exist in new one
     * 
     * @param string $sentence
     * @return boolean
     */
    public function isNew($sentence);

    /**
     * Renders result
     * 
     * @param \TextCvs\TagRendererInterface $render
     * @return string
     */
    public function render(TagRendererInterface $render);
}
