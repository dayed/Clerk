<?php namespace Maatwebsite\Clerk\Adapters\PHPExcel;

use Closure;
use PHPExcel;
use PHPExcel_IOFactory;
use Maatwebsite\Clerk\Adapters\Adapter;
use Maatwebsite\Clerk\Traits\CallableTrait;
use Maatwebsite\Clerk\Adapters\ParserSettings;
use Maatwebsite\Clerk\Reader as ReaderInterface;
use Maatwebsite\Clerk\Collections\RowCollection;
use Maatwebsite\Clerk\Collections\SheetCollection;
use Maatwebsite\Clerk\Adapters\PHPExcel\Parsers\WorkbookParser;

class Reader extends Adapter implements ReaderInterface {

    /**
     * Traits
     */
    use CallableTrait;

    /**
     * @var \PHPExcel_Reader_IReader
     */
    protected $reader;

    /**
     * @var string
     */
    protected $file;

    /**
     * @var ParserSettings
     */
    protected $settings;

    /**
     * @param string  $type
     * @param string  $file
     * @param Closure $callback
     */
    public function __construct($type, $file, Closure $callback = null)
    {
        $this->reader = PHPExcel_IOFactory::createReader($type);
        $this->file = $file;

        $this->call($callback);
    }

    /**
     * Settings
     * @return ParserSettings
     */
    public function settings()
    {
        return $this->settings ?: $this->settings = new ParserSettings();
    }

    /**
     * Get all sheets/rows
     * @param array $columns
     * @return SheetCollection|RowCollection
     */
    public function get($columns = array())
    {
        // Load the file
        $this->driver = $this->reader->load($this->file);

        // Set selected columns
        $this->settings()->setColumns($columns);

        return (new WorkbookParser($this->settings()))->parse($this->getWorkbook());
    }

    /**
     * Take x rows
     * @param  integer $amount
     * @return $this
     */
    public function take($amount)
    {
        $this->settings()->setMaxRows($amount);

        return $this;
    }

    /**
     * Skip x rows
     * @param  integer $amount
     * @return $this
     */
    public function skip($amount)
    {
        $this->settings()->setStartRow($amount);

        return $this;
    }

    /**
     * Limit the results by x
     * @param  integer $take
     * @param  integer $skip
     * @return $this
     */
    public function limit($take, $skip = 0)
    {
        // Skip x records
        $this->skip($skip);

        // Take x records
        $this->take($take);

        return $this;
    }

    /**
     * Select certain columns
     * @param  array $columns
     * @return $this
     */
    public function select($columns = array())
    {
        $this->settings()->setColumns($columns);

        return $this;
    }

    /**
     * Return all sheets/rows
     * @param  array $columns
     * @return $this
     */
    public function all($columns = array())
    {
        return $this->get($columns);
    }

    /**
     * Get first row/sheet only
     * @param  array $columns
     * @return SheetCollection|RowCollection
     */
    public function first($columns = array())
    {
        return $this->take(1)->get($columns)->first();
    }

    /**
     * Parse the file in chunks
     * @param int $size
     * @param     $callback
     * @throws \Exception
     * @return void
     */
    public function chunk($size = 10, $callback = null)
    {
        //
    }

    /**
     * Each
     * @param  callback $callback
     * @return SheetCollection|RowCollection
     */
    public function each($callback)
    {
        return $this->get()->each($callback);
    }

    /**
     *  Parse the file to an array.
     * @param  array $columns
     * @return array
     */
    public function toArray($columns = array())
    {
        return (array) $this->get($columns)->toArray();
    }

    /**
     *  Parse the file to an object.
     * @param array $columns
     * @return SheetCollection|RowCollection
     */
    public function toObject($columns = array())
    {
        return $this->get($columns);
    }

    /**
     *  Dump the parsed file to a readable array
     * @param  array   $columns
     * @param  boolean $die
     * @return string
     */
    public function dump($columns = array(), $die = false)
    {
        echo '<pre class="container" style="background: #f5f5f5; border: 1px solid #e3e3e3; padding:15px;">';
        var_dump($this->get($columns));
        echo '</pre>';

        if ( $die )
            die();
    }

    /**
     * Die and dump
     * @param array $columns
     * @return string
     */
    public function dd($columns = array())
    {
        return $this->dump($columns, true);
    }

    /**
     * Select sheets by their indices
     * @param array $sheets
     * @return mixed
     */
    public function selectSheets($sheets = array())
    {
        $this->settings()->setSheetIndices($sheets);

        return $this;
    }

    /**
     * Ignore empty cells
     * @param $value
     * @return mixed
     */
    public function ignoreEmpty($value)
    {
        return $this->settings()->setIgnoreEmpty($value);
    }

    /**
     * Set the date format
     * @param $format
     * @return mixed
     */
    public function setDateFormat($format)
    {
        return $this->settings()->setDateFormat($format);
    }

    /**
     * Set date columns
     * @param array $columns
     * @return $this
     */
    public function setDateColumns($columns = array())
    {
        return $this->settings()->setDateColumns($columns);
    }

    /**
     * Workbook needs date formatting
     * @param $state
     * @return mixed
     */
    public function needsDateFormatting($state)
    {
        return $this->settings()->setNeedsDateFormatting($state);
    }

    /**
     * Set the heading row
     * @param $row
     * @return mixed
     */
    public function setHeadingRow($row)
    {
        return $this->settings()->setHeadingRow($row);
    }

    /**
     * Has heading row
     * @param $state
     * @return mixed
     */
    public function hasHeading($state)
    {
        return $this->settings()->setHasHeading($state);
    }

    /**
     * Set the heading type
     * @param $type
     * @return mixed
     */
    public function setHeadingType($type)
    {
        return $this->settings()->setHeadingType($type);
    }

    /**
     * Set separator
     * @param $separator
     * @return mixed
     */
    public function setSeparator($separator)
    {
        return $this->settings()->setSeparator($separator);
    }

    /**
     * Calculate cell values
     * @param $state
     * @return mixed
     */
    public function calculate($state)
    {
        return $this->settings()->setCalculatedCellValues($state);
    }

    /**
     * Set CSV delimiter
     * @param $delimiter
     * @return mixed
     */
    public function setDelimiter($delimiter)
    {
        $this->reader->setDelimiter($delimiter);

        return $this;
    }

    /**
     * Set CSV enclosure
     * @param $enclosure
     * @return mixed
     */
    public function setEnclosure($enclosure)
    {
        $this->reader->setEnclosure($enclosure);

        return $this;
    }

    /**
     * Set CSV the line endings
     * @param $lineEnding
     * @return mixed
     */
    public function setLineEnding($lineEnding)
    {
        $this->reader->setLineEnding($lineEnding);

        return $this;
    }

    /**
     * Get the current filename
     * @return mixed
     */
    public function getFileName()
    {
        $filename = $this->file;
        $segments = explode('/', $filename);
        $file = end($segments);
        list($name, $ext) = explode('.', $file);

        return $name;
    }

    /**
     * @return \PHPExcel_Reader_IReader
     */
    protected function getReader()
    {
        return $this->reader;
    }

    /**
     * @return PHPExcel
     */
    protected function getWorkbook()
    {
        return $this->getDriver();
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     */
    public function __call($method, $params)
    {
        if ( method_exists($this->settings(), $method) )
            return call_user_func_array([$this->settings(), $method], $params);

        if ( method_exists($this->getReader(), $method) )
            return call_user_func_array([$this->getReader(), $method], $params);

        parent::__call($method, $params);
    }
}