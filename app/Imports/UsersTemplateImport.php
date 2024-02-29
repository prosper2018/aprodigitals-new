<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\SkipsUnknownSheets;
use App\Imports\UsersImport;
use Illuminate\Validation\ValidationException;

class UsersTemplateImport implements WithMultipleSheets, SkipsUnknownSheets
{
    protected $startRow = 5; // Specify the row number from which the data starts

    protected $sheetName;

    protected $ipAddress;

    public function __construct($ipAddress, $sheetName)
    {
        $this->ipAddress = $ipAddress;
        $this->sheetName = $sheetName; 
    }


    public function sheets(): array
    {
        return [
            // 0 => new UsersImport($this->ipAddress, $this->sheetName),
            $this->sheetName => new UsersImport($this->ipAddress, $this->sheetName),
        ];
    }

    public function onUnknownSheet($sheetName)
    {
        info("Sheet {$sheetName} was not found and skipped. No user was imported.");
        $errors[] = "Sheet '{$sheetName}' was not found and skipped. No user was imported.";

        if (!empty($errors)) {
            throw ValidationException::withMessages($errors);
        }
    }
}
