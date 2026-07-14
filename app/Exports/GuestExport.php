<?php

namespace App\Exports;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class GuestExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths, WithEvents
{
    use Exportable;

    private int $row = 0;

    /** Rows reserved above the table for the letterhead ("kop"), including the spacer row. */
    private const KOP_ROWS = 5;

    public function __construct(
        private Builder $query,
    ) {}

    public function collection()
    {
        return $this->query->get();
    }

    /**
     * Previously there was no WithHeadings, so the sheet had no dedicated
     * header row — the first physical row (row 1) was already data (No. 1),
     * and the AfterSheet event then overwrote that same row with the column
     * titles. That's why "No" only became visible starting from 2. Using
     * WithHeadings puts the header on its own row and lets data start clean.
     */
    public function headings(): array
    {
        return ['No', 'Waktu Kunjungan', 'Instansi', 'Tujuan', 'Jumlah Personil', 'Nama PIC', 'No. HP'];
    }

    public function map($guest): array
    {
        $this->row++;

        return [
            $this->row,
            \App\Helpers\DateHelper::formatDateTime($guest->tanggal_kunjungan, $guest->jam_kunjungan),
            $guest->instansi,
            $guest->tujuan,
            $guest->jumlah_personil,
            $guest->nama_pic ?? '-',
            $guest->no_hp ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 30,
            'C' => 30,
            'D' => 40,
            'E' => 15,
            'F' => 20,
            'G' => 20,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // At this point Laravel Excel already wrote the heading row
                // at row 1 and the data starting at row 2. Push everything
                // down to make room for the letterhead, matching the Word export.
                $sheet->insertNewRowBefore(1, self::KOP_ROWS);

                $this->drawKop($sheet);

                $headerRow = self::KOP_ROWS + 1;
                $dataStart = $headerRow + 1;
                $lastDataRow = $headerRow + $this->row;

                $sheet->getStyle("A{$headerRow}:G{$headerRow}")->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'B3202E']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CCCCCC']]],
                ]);
                $sheet->getRowDimension($headerRow)->setRowHeight(28);

                if ($this->row > 0) {
                    $sheet->getStyle("A{$dataStart}:G{$lastDataRow}")->applyFromArray([
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'EEEEEE']]],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);

                    for ($i = $dataStart; $i <= $lastDataRow; $i++) {
                        if (($i - $headerRow) % 2 === 0) {
                            $sheet->getStyle("A{$i}:G{$i}")->applyFromArray([
                                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FBEAEA']],
                            ]);
                        }
                        $sheet->getRowDimension($i)->setRowHeight(22);
                    }

                    $sheet->getStyle("A{$dataStart}:A{$lastDataRow}")->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                    $sheet->getStyle("E{$dataStart}:E{$lastDataRow}")->applyFromArray([
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    ]);
                }

                $sheet->freezePane("A{$dataStart}");
                $sheet->setAutoFilter("A{$headerRow}:G{$lastDataRow}");
            },
        ];
    }

    private function drawKop(Worksheet $sheet): void
    {
        $logoPath = public_path('img/logo.png');

        if (file_exists($logoPath)) {
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setPath($logoPath);
            $drawing->setHeight(50);
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(5);
            $drawing->setOffsetY(5);
            $drawing->setWorksheet($sheet);
        }

        $sheet->mergeCells('B1:G1');
        $sheet->setCellValue('B1', 'SD Indo Tionghoa Tarakan');
        $sheet->getStyle('B1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'B3202E']],
        ]);

        $sheet->mergeCells('B2:G2');
        $sheet->setCellValue('B2', 'Buku Tamu Digital');
        $sheet->getStyle('B2')->applyFromArray([
            'font' => ['size' => 11, 'color' => ['rgb' => '6B5C5C']],
        ]);

        $sheet->mergeCells('B3:G3');
        $sheet->setCellValue('B3', 'Data per: ' . DateHelper::formatIndonesian(now()));
        $sheet->getStyle('B3')->applyFromArray([
            'font' => ['size' => 9, 'color' => ['rgb' => '999999']],
        ]);

        // Row 4: thin colored rule under the letterhead, row 5 left blank as a spacer.
        $sheet->mergeCells('A4:G4');
        $sheet->getStyle('A4:G4')->applyFromArray([
            'borders' => ['bottom' => ['borderStyle' => Border::BORDER_THICK, 'color' => ['rgb' => 'B3202E']]],
        ]);

        foreach ([1, 2, 3] as $r) {
            $sheet->getRowDimension($r)->setRowHeight(18);
        }
    }

    public function styles(Worksheet $sheet): array
    {
        return [];
    }
}