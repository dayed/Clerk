<?php namespace Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\Attributes;

use DOMAttr;
use Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Html\ReferenceTable;

class WidthAttribute extends Attribute {

    /**
     * @param DOMAttr        $attribute
     * @param ReferenceTable $table
     * @return mixed
     */
    public function parse(DOMAttr $attribute, ReferenceTable &$table)
    {
        $this->sheet->setColumnWidth(
            $table->getColumn(),
            $attribute->value
        );
    }
}