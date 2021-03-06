<?php namespace Maatwebsite\Clerk\Excel\Adapters\PHPExcel\Writers;

use PHPExcel_Worksheet;
use Maatwebsite\Clerk\Excel\Cell;

class CellWriter {

    /**
     * @var PHPExcel_Worksheet
     */
    protected $sheet;

    /**
     * @param PHPExcel_Worksheet $sheet
     */
    public function __construct(PHPExcel_Worksheet $sheet)
    {
        $this->sheet = $sheet;
    }

    /**
     * @param Cell $cell
     */
    public function write(Cell $cell)
    {
        $coordinate = $cell->getCoordinate()->get();

        /**
         * CELL VALUE
         */
        $this->sheet->getCell($coordinate)->setValueExplicit(
            $cell->getValue(),
            (string) $cell->getDataType()
        );

        /**
         * NUMBER FORMAT
         */
        $this->sheet->getStyle($coordinate)
                    ->getNumberFormat()
                    ->setFormatCode((string) $cell->getFormat());

        /**
         * CELL STYLES
         */
        if ( $cell->hasStyles() )
        {
            $styles = (new StyleWriter())->convert(
                $cell->getStyles()
            );

            $this->sheet->getStyle($coordinate)->applyFromArray($styles);
        }
    }
}