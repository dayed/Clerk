<?php namespace Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Attributes;

use DOMAttr;
use Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\ReferenceTable;
use Maatwebsite\Clerk\Excel\Cell;

class AlignAttribute extends Attribute {

    /**
     * @param DOMAttr        $attribute
     * @param ReferenceTable $table
     * @return mixed
     */
    public function parse(DOMAttr $attribute, ReferenceTable &$table)
    {
        $this->sheet->cell($table->getCoordinate(), function (Cell $cell) use ($attribute)
        {
            $cell->align($attribute->value);
        });
    }
}