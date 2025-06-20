<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
// use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use Barryvdh\DomPDF\Facade\Pdf;

class MooraExport implements FromView, ShouldAutoSize
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

    public function downloadPdf()
    {
        $pdf = Pdf::loadView('exports.moora_pdf', [
            'competition' => $this->competition,
            'decisionMatrix' => $this->decisionMatrix,
            'normalizedMatrix' => $this->normalizedMatrix,
            'results' => $this->results,
            'weights' => $this->getWeights(),
        ]);

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultPaperSize' => 'A4',
            'marginTop' => 10,
            'marginBottom' => 10,
            'marginLeft' => 10,
            'marginRight' => 10,
        ]);

        $pdf->setOption('orientation', 'landscape');

        $competitionTitle = str_replace(' ', '_', $this->competition->competition_tittle);

        $filename = $competitionTitle . '_moora_step_by_step.pdf';

        return $pdf->download($filename);
    }


    private function getWeights()
    {
        return [
            'Total Achievements' => 0.1,
            'Approved Achievements' => 0.15,
            'Level of Achievements' => 0.15,
            'Best Ranking' => 0.15,
            'GPA' => 0.1,
            'Category Skills' => 0.18,
            'Total Skills' => 0.05,
            'Semester' => 0.03,
            'Pre-University Achievements' => 0.03,
            'Pre-University Best Rank' => 0.03,
            'Pre-University Level' => 0.03,
        ];
    }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {
    //             $sheet = $event->sheet->getDelegate();

    //             // Format header cells with background color
    //             $headerRanges = ['A6:Z6', 'A16:Z16', 'A26:Z26', 'A36:B36', 'A46:C46'];
    //             foreach ($headerRanges as $range) {
    //                 $sheet->getStyle($range)->getFill()->setFillType(Fill::FILL_SOLID)
    //                     ->getStartColor()->setARGB(Color::COLOR_YELLOW);
    //             }

    //             // Bold header text
    //             foreach ($headerRanges as $range) {
    //                 $sheet->getStyle($range)->getFont()->setBold(true);
    //             }

    //             // Format score column with green fill if high score
    //             $lastRow = 46 + count($this->results);
    //             for ($i = 47; $i <= $lastRow; $i++) {
    //                 $score = $sheet->getCell("C$i")->getValue();
    //                 if ($score >= 0.6) {
    //                     $sheet->getStyle("C$i")->getFill()->setFillType(Fill::FILL_SOLID)
    //                         ->getStartColor()->setARGB('C6EFCE');
    //                 }
    //             }

    //             // Optional: Add chart placeholder or note
    //             $sheet->setCellValue('E2', 'Note: Consider visualizing scores with a bar chart in Excel');
    //         }
    //     ];
    // }
}
