<?php

namespace BarinBritva\Pagination;

use LogicException;

class Page
{
    const IS_FIRST = 1;
    const IS_PREVIOUS_GROUP = 2;
    const IS_PREVIOUS = 3;
    const IS_NUMERIC = 4;
    const IS_CURRENT = 5;
    const IS_NEXT = 6;
    const IS_NEXT_GROUP = 7;
    const IS_LAST = 8;

    const ALLOWED_FLAGS = [
        self::IS_FIRST,
        self::IS_PREVIOUS_GROUP,
        self::IS_PREVIOUS,
        self::IS_NUMERIC,
        self::IS_CURRENT,
        self::IS_NEXT,
        self::IS_NEXT_GROUP,
        self::IS_LAST,
    ];

    private $label;
    private $number;
    private $href;
    private $isFirst = false;
    private $isPreviousGroup = false;
    private $isPrevious = false;
    private $isNumeric = false;
    private $isCurrent = false;
    private $isNext = false;
    private $isNextGroup = false;
    private $isLast = false;

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @return int
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return boolean
     */
    public function isFirst()
    {
        return $this->isFirst;
    }

    /**
     * @return boolean
     */
    public function isPreviousGroup()
    {
        return $this->isPreviousGroup;
    }

    /**
     * @return boolean
     */
    public function isPrevious()
    {
        return $this->isPrevious;
    }

    /**
     * @return boolean
     */
    public function isNumeric()
    {
        return $this->isNumeric;
    }

    /**
     * @return boolean
     */
    public function isCurrent()
    {
        return $this->isCurrent;
    }

    /**
     * @return boolean
     */
    public function isNext()
    {
        return $this->isNext;
    }

    /**
     * @return boolean
     */
    public function isNextGroup()
    {
        return $this->isNextGroup;
    }

    /**
     * @return boolean
     */
    public function isLast()
    {
        return $this->isLast;
    }

    /**
     * @param string    $label
     * @param int       $number
     * @param string    $href
     * @param int|int[] $flags
     *
     * @throw LogicException
     */
    public function __construct($label, $number, $href, $flags = null)
    {
        $this->label  = (string)$label;
        $this->number = (int)$number;
        $this->href   = (string)$href;

        if ($flags !== null) {
            $flags = (array)$flags;

            foreach ($flags as $flag) {
                switch ($flag) {
                    case self::IS_FIRST:
                        $this->isFirst = true;
                        break;
                    case self::IS_PREVIOUS_GROUP:
                        $this->isPreviousGroup = true;
                        break;
                    case self::IS_PREVIOUS:
                        $this->isPrevious = true;
                        break;
                    case self::IS_NUMERIC:
                        $this->isNumeric = true;
                        break;
                    case self::IS_CURRENT:
                        $this->isCurrent = true;
                        break;
                    case self::IS_NEXT:
                        $this->isNext = true;
                        break;
                    case self::IS_NEXT_GROUP:
                        $this->isNextGroup = true;
                        break;
                    case self::IS_LAST:
                        $this->isLast = true;
                        break;
                    default:
                        throw new LogicException(sprintf(
                            'Flag value must be an one value from: "%s". Given: "%s".',
                            implode('", "', self::ALLOWED_FLAGS),
                            $flag
                        ));
                        break;
                }
            }
        }
    }
}
