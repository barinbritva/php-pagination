<?php

namespace BarinBritva\Pagination;

interface PageCounter
{
    /**
     * @return int
     */
    public function countTotalRecords();
}