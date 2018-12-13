<?php

namespace App;

use React\Filesystem\FilesystemInterface;

class PinInit
{
    public $exportPath = '/sys/class/gpio/export';
    public $pinPath = '/sys/class/gpio/gpio';
    public $pinDirectionPath = '';
    public $pinNumber = '';
    public $pinValuePath = '';
    protected $filesystem;

    /**
     * PinInit constructor.
     *
     * @param FilesystemInterface $filesystem
     * @param $pinNumber
     * @return string
     *   Path to pin value resource.
     */
    public function __construct(FilesystemInterface $filesystem, $pinNumber, $direction)
    {
        $this->filesystem = $filesystem;
        $this->pinNumber = $pinNumber;
        $this->pinDirectionPath = $this->pinPath . $this->pinNumber . '/direction';
        $this->pinValuePath = $this->pinPath . $this->pinNumber . '/value';

        $this->init($pinNumber);
        return $this->direction($direction);
    }

    /**
     * Set pin direction.
     *   'out', 'in' only possible options.
     *
     * @param string $direction
     * @return string
     */
    private function direction($direction)
    {
        if (!is_string($direction) || !in_array($direction, ['in', 'out'])) {
            die("Wrong direction supplied");
        }
        $this->filesystem->file($this->pinDirectionPath)->putContents($direction);

        return $this->pinValuePath;
    }

    /**
     * Registered pin in the system.
     *
     * @param $pinNumber
     * @return void
     */
    private function init($pinNumber)
    {
        $this->filesystem->file($this->exportPath)->putContents($pinNumber);
    }
}