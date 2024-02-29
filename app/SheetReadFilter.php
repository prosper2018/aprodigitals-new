<?php 

use Maatwebsite\Excel\Concerns\WithReadFilter;

class SheetReadFilter implements WithReadFilter
{
    protected $sheetName;

    public function __construct($sheetName)
    {
        $this->sheetName = $sheetName;
    }

    public function apply($reader, $sheetIndex): bool
    {
        // Return true only if the current sheet matches the specified sheet name
        return $sheetIndex === $this->getSheetIndex($reader, $this->sheetName);
    }

    protected function getSheetIndex($reader, $sheetName)
    {
        // Get the index of the sheet with the specified name
        $sheetIndex = $reader->getSheetByName($sheetName)->getIndex();

        return $sheetIndex;
    }
}
