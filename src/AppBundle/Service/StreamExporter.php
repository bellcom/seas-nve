<?php

namespace AppBundle\Service;

use Box\Spout\Writer\WriterInterface;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Box\Spout\Writer\WriterFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;

class StreamExporter
{

    private $data = [''];
    private $row = 1;
    private $col = 0;

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }

    public function setConfig(array $config)
    {
        $this->columns = isset($config['columns']) ? $config['columns'] : [];
    }

    /**
     * @var WriterInterface
     */
    private $writer;

    public function start($filepath, $format)
    {
        $this->writer = WriterFactory::create($format);
        if ($format == 'csv') {
            $this->writer->setShouldAddBOM(FALSE);
        }
        $this->writer->openToFile($filepath);

    }

    public function header()
    {
        $this->writeHeader();
    }

    public function item($row)
    {
        $this->writeEntity($row);
    }

    public function end()
    {
        $this->writer->close();
    }

    private function writeHeader()
    {
        foreach ($this->columns as $column) {
            $this->addCell($column);
        }
        $this->addRow();
    }

    private function writeEntity($entity)
    {
        foreach ($this->columns as $column) {
            $value = '';
            if ($this->accessor->isReadable($entity, $column)) {
                $value = $this->accessor->getValue($entity, $column);
            }
            $this->addCell($value);
        }
        $this->addRow();
    }

    private function addCell($value)
    {
        if ($value instanceof \DateTime) {
            $value = $value->format('Y-m-d H:i:s');
        } elseif (is_object($value)) {
            $value = (string) $value;
        } elseif (gettype($value) == 'string' && is_numeric($value)) {
            if((int)$value == $value) {
                $value = (int)$value;
            } else {
                $value = floatval($value);
            }
        }

        $this->data[$this->col] = $value;
        $this->col++;
    }

    private function addRow()
    {
        $row = array_slice($this->data, 0, $this->col);
        $this->writer->addRow($row);
        $this->row += 1;
        $this->col = 0;
    }

}
