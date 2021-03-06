<?php namespace Maatwebsite\Clerk\Excel\Adapters\LeagueCsv;

use Closure;
use SplTempFileObject;
use League\Csv\Writer as LeagueWriter;
use Maatwebsite\Clerk\Excel\Workbook as WorkbookInterface;
use Maatwebsite\Clerk\Excel\Workbooks\Workbook as AbstractWorkbook;

/**
 * Class Workbook
 * @package Maatwebsite\Clerk\Adapters\LeagueCsv
 */
class Workbook extends AbstractWorkbook implements WorkbookInterface {

    /**
     * @var
     */
    protected $title;

    /**
     * @var LeagueWriter
     */
    protected $driver;

    /**
     * @param              $title
     * @param Closure      $callback
     * @param LeagueWriter $driver
     */
    public function __construct($title, Closure $callback = null, LeagueWriter $driver = null)
    {
        // Set PHPExcel instance
        $this->driver = $driver ?: new LeagueWriter(new SplTempFileObject);

        parent::__construct($title, $callback);
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param $description
     * @return WorkbookInterface
     */
    public function setDescription($description)
    {
        //
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        //
    }

    /**
     * @param $company
     * @return WorkbookInterface
     */
    public function setCompany($company)
    {
        //
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        //
    }

    /**
     * @param $subject
     * @return WorkbookInterface
     */
    public function setSubject($subject)
    {
        //
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        //
    }

    /**
     * Set the delimiter
     * @param $delimiter
     * @return $this
     */
    public function setDelimiter($delimiter)
    {
        $this->getDriver()->setDelimiter($delimiter);

        return $this;
    }

    /**
     * Set line ending
     * @param $lineEnding
     * @return $this
     */
    public function setLineEnding($lineEnding)
    {
        $this->getDriver()->setNewLine($lineEnding);

        return $this;
    }

    /**
     * Set enclosure
     * @param $enclosure
     * @return $this
     */
    public function setEnclosure($enclosure)
    {
        $this->getDriver()->setEnclosure($enclosure);

        return $this;
    }

    /**
     * Set encoding
     * @param $encoding
     * @return $this
     */
    public function setEncoding($encoding)
    {
        $this->getDriver()->setEncodingFrom($encoding);

        return $this;
    }

    /**
     * Init a new sheet
     * @param          $title
     * @param Closure  $callback
     * @return Sheet
     */
    public function sheet($title, Closure $callback = null)
    {
        // Init a new sheet
        $sheet = new Sheet(
            $this,
            $title,
            null,
            $this->driver
        );

        // Preform callback on the sheet
        $sheet->call($callback);

        // Add the sheet to the collection
        $this->addSheet($sheet);

        return $sheet;
    }

    /**
     * Get delimiter
     * @return string
     */
    public function getDelimiter()
    {
        // TODO: Implement getDelimiter() method.
    }

    /**
     * Get enclosure
     * @return string
     */
    public function getEnclosure()
    {
        // TODO: Implement getEnclosure() method.
    }

    /**
     * Get line ending
     * @return string
     */
    public function getLineEnding()
    {
        // TODO: Implement getLineEnding() method.
    }
}