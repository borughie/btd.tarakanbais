<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Guest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\Style\Table;
use Symfony\Component\HttpFoundation\Response;

class GuestExportController extends Controller
{
    public function index(Request $request): Response
    {
        $guests = $this->getFilteredGuests($request)->get();

        $phpWord = new PhpWord();

        // Portrait, small consistent margins (in twips, 1440 = 1 inch).
        // 600 twip ≈ 0.42" on every side — the old setMargins(80,...) call
        // wasn't a real PhpWord method, so the section was actually falling
        // back to the (much larger) 1" default margins.
        $section = $phpWord->addSection([
            'orientation' => 'portrait',
            'marginTop' => 600,
            'marginBottom' => 600,
            'marginLeft' => 600,
            'marginRight' => 600,
        ]);

        $logoPath = public_path('img/logo.png');

        // 'cellBorderTop/Bottom/Left/Right' => 'none' aren't real PhpWord
        // style keys, so they were silently ignored — the vertical line you
        // saw between the logo cell and the text cell was the table's
        // default inside-vertical border. borderSize only zeroes the outer
        // edge, so the inside borders need to be zeroed explicitly too.
        $headerTable = $section->addTable([
            'width' => 100 * 50,
            'unit' => TblWidth::PERCENT,
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'insideHBorderSize' => 0,
            'insideVBorderSize' => 0,
            'cellMargin' => 0,
        ]);

        $headerTable->addRow(900);
        $cellLogo = $headerTable->addCell(1200);
        if (file_exists($logoPath)) {
            $cellLogo->addImage($logoPath, [
                'width' => 50,
                'height' => 50,
            ]);
        }

        $cellInfo = $headerTable->addCell(13500);
        $cellInfo->addText('SD Indo Tionghua Tarakan', [
            'bold' => true,
            'size' => 16,
            'color' => 'B3202E',
        ]);
        $cellInfo->addText('Buku Tamu Digital', [
            'size' => 12,
            'color' => '6B5C5C',
        ]);
        $cellInfo->addText('Data per: ' . DateHelper::formatIndonesian(now()), [
            'size' => 10,
            'color' => '999999',
        ]);

        $section->addParagraphStyle('Separator', [
            'borderBottom' => ['color' => 'B3202E', 'size' => 6, 'space' => 1],
            'spacingAfter' => 200,
        ]);
        $section->addText('', 'Separator');

        // The old table set 'width' => 100 * 50 without 'unit' => pct, so
        // PhpWord read it as 5000 twips (~3.5") instead of 100% — that's why
        // the seven columns were squeezed on top of each other. Adding the
        // unit fixes it, and 'layout' => LAYOUT_FIXED stops Word from
        // auto-shrinking columns to fit long text.
        $table = $section->addTable([
            'borderSize' => 6,
            'borderColor' => 'B3202E',
            'cellMargin' => 60,
            'width' => 100 * 50,
            'unit' => TblWidth::PERCENT,
            'layout' => Table::LAYOUT_FIXED,
        ]);

        $headerStyle = ['bold' => true, 'color' => 'FFFFFF', 'size' => 9];
        $cellStyle = ['size' => 9];

        // Widths for portrait mode (~9,000 twip content width after margins)
        $columnWidths = [
            'No' => 600,
            'Waktu' => 1600,
            'Instansi' => 2000,
            'Tujuan' => 2500,
            'Personil' => 800,
            'PIC' => 1500,
            'No. HP' => 1500,
        ];

        $table->addRow();
        foreach ($columnWidths as $header => $width) {
            $table->addCell($width, ['bgColor' => 'B3202E'])->addText($header, $headerStyle);
        }

        foreach ($guests as $i => $guest) {
            $table->addRow();
            $table->addCell($columnWidths['No'], $cellStyle)->addText((string) ($i + 1));
            $table->addCell($columnWidths['Waktu'], $cellStyle)->addText(DateHelper::formatIndonesian($guest->created_at));
            $table->addCell($columnWidths['Instansi'], $cellStyle)->addText($guest->instansi);
            $table->addCell($columnWidths['Tujuan'], $cellStyle)->addText($guest->tujuan);
            $table->addCell($columnWidths['Personil'], $cellStyle)->addText((string) $guest->jumlah_personil);
            $table->addCell($columnWidths['PIC'], $cellStyle)->addText($guest->nama_pic ?? '-');
            $table->addCell($columnWidths['No. HP'], $cellStyle)->addText($guest->no_hp ?? '-');
        }

        $section->addTextBreak();
        $section->addText('Total: ' . $guests->count() . ' tamu', ['bold' => true, 'size' => 10]);

        $fileName = 'buku-tamu-' . now()->format('Y-m-d-His');
        $tempPath = storage_path("app/{$fileName}.docx");

        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempPath);

        return response()->download($tempPath, "{$fileName}.docx", [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ])->deleteFileAfterSend(true);
    }

    public function excel(Request $request): Response
    {
        $guests = $this->getFilteredGuests($request);

        $fileName = 'buku-tamu-' . now()->format('Y-m-d-His');

        return Excel::download(new \App\Exports\GuestExport($guests), "{$fileName}.xlsx");
    }

    public function pdf(Request $request): Response
    {
        $guests = $this->getFilteredGuests($request)->get();

        $pdf = Pdf::loadView('exports.guest-pdf', [
            'guests' => $guests,
            'total' => $guests->count(),
            'filter' => $request->only(['search', 'date_from', 'date_to']),
        ]);

        $fileName = 'buku-tamu-' . now()->format('Y-m-d-His');

        return $pdf->download("{$fileName}.pdf");
    }

    private function getFilteredGuests(Request $request)
    {
        $query = Guest::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('instansi', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query->latest();
    }
}