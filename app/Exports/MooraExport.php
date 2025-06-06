<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MooraExport implements FromView
{
    protected $competition;
    protected $decisionMatrix;
    protected $normalizedMatrix;
    protected $results;

    public function __construct($competition, $decisionMatrix, $normalizedMatrix, $results)
    {
        $this->competition = $competition;
        $this->decisionMatrix = $decisionMatrix;
        $this->normalizedMatrix = $normalizedMatrix;
        $this->results = $results;
    }

    public function view(): View
    {
        return view('exports.moora', [
            'competition' => $this->competition,
            'decisionMatrix' => $this->decisionMatrix,
            'normalizedMatrix' => $this->normalizedMatrix,
            'results' => $this->results,
        ]);
    }

}
