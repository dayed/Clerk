<?php namespace Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Styles;

use Maatwebsite\Clerk\Excel\Cell;
use Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\ReferenceTable;

class BackgroundStyle extends Style {

    /**
     * @param Cell           $cell
     * @param                $value
     * @param ReferenceTable $table
     * @return mixed
     */
    public function parse(Cell $cell, $value, ReferenceTable &$table)
    {
        $cell->fill($value);
    }
}