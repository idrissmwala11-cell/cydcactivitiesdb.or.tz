<?php

namespace App\Services;

use App\Models\FormTwoAssessment;
use Illuminate\Support\Collection;

class PublishedResultsPdf
{
    private const PAGE_WIDTH = 841.89;
    private const PAGE_HEIGHT = 595.28;
    private const MARGIN = 24.0;

    private array $pages = [];
    private array $commands = [];
    private array $imageResources = [];
    private float $y = self::PAGE_HEIGHT - self::MARGIN;
    private bool $isPrimary = false;

    public function generate(FormTwoAssessment $assessment, Collection $rows, Collection $groups): string
    {
        $this->pages = [];
        $this->commands = [];
        $this->imageResources = [];
        $this->isPrimary = $assessment->education_level === 'primary';

        $this->addPage();
        $this->drawHeader($assessment);
        $this->drawSummary($assessment, $groups);
        $this->y -= 8;
        $this->drawResultsTable($assessment, $rows);
        $this->finishPage();

        return $this->buildPdf();
    }

    private function drawHeader(FormTwoAssessment $assessment): void
    {
        $logoY = self::PAGE_HEIGHT - self::MARGIN - 52;
        $this->drawImage('Im1', public_path('logos/church-logo-1.jpeg'), 72, $logoY, 50, 50);
        $this->drawImage('Im2', public_path('logos/church-logo-2.jpeg'), self::PAGE_WIDTH - 122, $logoY, 50, 50);

        $this->textCenter(config('form_two_results.school_name'), $this->y, 13, true);
        $this->y -= 17;
        $this->textCenter(config('form_two_results.school_subtitle'), $this->y, 10, true);
        $this->y -= 15;
        $this->textCenter($this->isPrimary ? 'ORODHA KAMILI YA MATOKEO' : 'FULL RESULTS LIST', $this->y, 9);
        $this->y -= 17;
        $this->textCenter(strtoupper($assessment->name).' / '.strtoupper($assessment->class_level), $this->y, 9, true);
        $this->y -= 16;
    }

    private function drawSummary(FormTwoAssessment $assessment, Collection $groups): void
    {
        $columns = $this->isPrimary ? ['A', 'B', 'C', 'D', 'E'] : ['I', 'II', 'III', 'IV', '0', 'INC'];
        $widths = $this->isPrimary
            ? [78, 64, 64, 64, 66, 66, 66, 66, 66, 66, 91]
            : [74, 52, 52, 52, 54, 54, 54, 54, 54, 62, 58, 85];
        $x = (self::PAGE_WIDTH - array_sum($widths)) / 2;

        $this->drawFilledCell($x, $this->y, array_sum($widths), 20, '0.957 0.769 0.188');
        $this->textCenter(($this->isPrimary ? 'Msingi' : 'Secondary').' / '.$assessment->class_level.' - '.$assessment->name, $this->y - 13, 8, true);
        $this->y -= 20;

        $headers = [
            $this->isPrimary ? 'Kundi' : 'Group',
            $this->isPrimary ? 'REG' : 'REG',
            $this->isPrimary ? 'SAT' : 'SAT',
            $this->isPrimary ? 'ABS' : 'ABS',
        ];

        foreach ($columns as $column) {
            $headers[] = $this->isPrimary ? 'DARAJA '.$column : 'DIV '.$column;
        }

        $headers[] = $this->isPrimary ? 'PASS' : 'PASS';
        $headers[] = $this->isPrimary ? 'PASS %' : 'PASS %';

        $this->drawTableRow($x, $this->y, $widths, $headers, 19, 7, true, '0.071 0.095 0.145', true);
        $this->y -= 19;

        foreach (['F' => ($this->isPrimary ? 'Wasichana' : 'Girls'), 'M' => ($this->isPrimary ? 'Wavulana' : 'Boys'), 'ALL' => ($this->isPrimary ? 'Jumla' : 'Total')] as $key => $label) {
            $group = $groups[$key];
            $cells = [$label, $group['registered'], $group['sat'], $group['absent']];

            foreach ($columns as $column) {
                $cells[] = $this->isPrimary ? $group['grades'][$column] : $group['divisions'][$column];
            }

            $cells[] = $group['passed'];
            $cells[] = number_format($group['pass_rate'], 1).'%';

            $this->drawTableRow($x, $this->y, $widths, $cells, 18, 7, $key === 'ALL');
            $this->y -= 18;
        }
    }

    private function drawResultsTable(FormTwoAssessment $assessment, Collection $rows): void
    {
        $widths = $this->isPrimary
            ? [42, 125, 84, 28, 350, 45, 45, 45, 42]
            : [42, 113, 76, 28, 330, 43, 43, 35, 43, 34];
        $headers = $this->isPrimary
            ? ['Na.', 'Jina la Mwanafunzi', 'FCP', 'Jinsi', 'Masomo na Alama', 'Jumla', 'Wastani', 'Daraja', 'Nafasi']
            : ['Na.', "Candidate's Name", 'FCP', 'Sex', 'Subject Marks', 'Total', 'Average', 'Points', 'Division', 'Position'];
        $x = (self::PAGE_WIDTH - array_sum($widths)) / 2;

        $drawHeader = function () use ($x, $widths, $headers): void {
            $this->drawTableRow($x, $this->y, $widths, $headers, 20, 6.5, true, '0.071 0.095 0.145', true);
            $this->y -= 20;
        };

        $drawHeader();

        foreach ($rows as $row) {
            $subjectMarks = collect($row['subjects'])
                ->filter(fn ($item) => $item['mark'] !== null || $item['isAbsent'])
                ->map(function ($item): string {
                    $markText = $item['isAbsent']
                        ? 'ABS'
                        : rtrim(rtrim(number_format($item['mark'], 2, '.', ''), '0'), '.');

                    return $item['subject']->abbreviation.' '.$markText.'-'.$item['grade'];
                })
                ->join('  ');

            $cells = [
                $row['display_number'],
                $row['student']->candidate_name,
                $row['student']->fcp_name ?: '-',
                $row['student']->sex,
                $subjectMarks !== '' ? $subjectMarks : '-',
                number_format($row['total'], 2),
                $row['average'] !== null ? number_format($row['average'], 2) : 'ABS',
            ];

            if ($this->isPrimary) {
                $cells[] = $row['overall_grade'] ?? 'ABS';
            } else {
                $cells[] = $row['points'] ?? '-';
                $cells[] = $row['division'];
            }

            $cells[] = $row['rank'] ?? '-';

            $wrapped = [];
            $maxLines = 1;
            foreach ($cells as $index => $cell) {
                $lines = $this->wrapText((string) $cell, $widths[$index] - 7, $index === 4 ? 5.5 : 6.2);
                $wrapped[] = $lines;
                $maxLines = max($maxLines, count($lines));
            }

            $height = max(19, 9 + ($maxLines * 7.2));
            if ($this->y - $height < self::MARGIN) {
                $this->addPage();
                $this->drawHeader($assessment);
                $drawHeader();
            }

            $this->drawWrappedRow($x, $this->y, $widths, $wrapped, $height, 6.2);
            $this->y -= $height;
        }
    }

    private function drawTableRow(float $x, float $topY, array $widths, array $cells, float $height, float $fontSize, bool $bold = false, ?string $fill = null, bool $whiteText = false): void
    {
        $wrapped = array_map(fn ($cell, $index) => $this->wrapText((string) $cell, $widths[$index] - 6, $fontSize), $cells, array_keys($cells));
        $this->drawWrappedRow($x, $topY, $widths, $wrapped, $height, $fontSize, $bold, $fill, $whiteText);
    }

    private function drawWrappedRow(float $x, float $topY, array $widths, array $wrappedCells, float $height, float $fontSize, bool $bold = false, ?string $fill = null, bool $whiteText = false): void
    {
        $left = $x;
        foreach ($widths as $index => $width) {
            if ($fill) {
                $this->commands[] = "{$fill} rg {$left} ".($topY - $height)." {$width} {$height} re f";
            }

            $this->commands[] = "0 0 0 RG {$left} ".($topY - $height)." {$width} {$height} re S";
            $lineY = $topY - 8;
            foreach ($wrappedCells[$index] as $line) {
                if ($lineY < $topY - $height + 4) {
                    break;
                }

                $this->text($left + 3, $lineY, $line, $fontSize, $bold, $whiteText ? '1 1 1' : '0 0 0');
                $lineY -= $fontSize + 1.4;
            }

            $left += $width;
        }
    }

    private function wrapText(string $text, float $maxWidth, float $fontSize): array
    {
        $words = preg_split('/\s+/', trim($text)) ?: [];
        $lines = [];
        $line = '';

        foreach ($words as $word) {
            $candidate = trim($line.' '.$word);
            if ($line !== '' && $this->textWidth($candidate, $fontSize) > $maxWidth) {
                $lines[] = $line;
                $line = $word;
            } else {
                $line = $candidate;
            }
        }

        if ($line !== '') {
            $lines[] = $line;
        }

        return $lines ?: ['-'];
    }

    private function drawFilledCell(float $x, float $topY, float $width, float $height, string $fill): void
    {
        $this->commands[] = "{$fill} rg {$x} ".($topY - $height)." {$width} {$height} re f";
        $this->commands[] = "0 0 0 RG {$x} ".($topY - $height)." {$width} {$height} re S";
    }

    private function drawImage(string $name, string $path, float $x, float $y, float $width, float $height): void
    {
        if (! isset($this->imageResources[$name])) {
            $image = $this->loadJpegImage($path);

            if ($image === null) {
                return;
            }

            $this->imageResources[$name] = $image;
        }

        $this->commands[] = "q {$width} 0 0 {$height} {$x} {$y} cm /{$name} Do Q";
    }

    private function loadJpegImage(string $path): ?array
    {
        if (! is_file($path)) {
            return null;
        }

        $info = @getimagesize($path);
        $data = @file_get_contents($path);

        if (! is_array($info) || $data === false || ($info[2] ?? null) !== IMAGETYPE_JPEG) {
            return null;
        }

        return [
            'width' => (int) $info[0],
            'height' => (int) $info[1],
            'data' => $data,
        ];
    }

    private function textCenter(string $text, float $y, float $size, bool $bold = false): void
    {
        $x = (self::PAGE_WIDTH - $this->textWidth($text, $size)) / 2;
        $this->text($x, $y, $text, $size, $bold);
    }

    private function text(float $x, float $y, string $text, float $size, bool $bold = false, string $color = '0 0 0'): void
    {
        $font = $bold ? 'F2' : 'F1';
        $this->commands[] = "{$color} rg BT /{$font} {$size} Tf 1 0 0 1 {$x} {$y} Tm (".$this->escapeText($text).") Tj ET";
    }

    private function textWidth(string $text, float $size): float
    {
        return strlen($this->normalizeText($text)) * $size * 0.48;
    }

    private function normalizeText(string $text): string
    {
        $converted = @iconv('UTF-8', 'Windows-1252//TRANSLIT//IGNORE', $text);

        return $converted === false ? $text : $converted;
    }

    private function escapeText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\\(', '\\)', ' ', ' '],
            $this->normalizeText($text)
        );
    }

    private function addPage(): void
    {
        if ($this->commands !== []) {
            $this->finishPage();
        }

        $this->commands = [];
        $this->y = self::PAGE_HEIGHT - self::MARGIN;
    }

    private function finishPage(): void
    {
        if ($this->commands !== []) {
            $this->pages[] = implode("\n", $this->commands)."\n";
            $this->commands = [];
        }
    }

    private function buildPdf(): string
    {
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '',
        ];
        $imageObjects = [];

        foreach ($this->imageResources as $name => $image) {
            $objectNumber = count($objects) + 1;
            $imageObjects[$name] = $objectNumber;
            $objects[] = "<< /Type /XObject /Subtype /Image /Width {$image['width']} /Height {$image['height']} /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ".strlen($image['data'])." >>\nstream\n{$image['data']}\nendstream";
        }

        $pageObjectNumbers = [];

        foreach ($this->pages as $index => $content) {
            $pageObject = count($objects) + 1;
            $contentObject = $pageObject + 1;
            $pageObjectNumbers[] = $pageObject;
            $xObjects = collect($imageObjects)
                ->map(fn (int $objectNumber, string $name): string => "/{$name} {$objectNumber} 0 R")
                ->implode(' ');
            $xObjectResource = $xObjects !== '' ? " /XObject << {$xObjects} >>" : '';

            $objects[] = '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 '.self::PAGE_WIDTH.' '.self::PAGE_HEIGHT.'] /Resources << /Font << /F1 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica /Encoding /WinAnsiEncoding >> /F2 << /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold /Encoding /WinAnsiEncoding >> >>'.$xObjectResource.' >> /Contents '.$contentObject.' 0 R >>';
            $objects[] = "<< /Length ".strlen($content)." >>\nstream\n{$content}endstream";
        }

        $objects[1] = '<< /Type /Pages /Kids ['.implode(' ', array_map(fn ($number) => "{$number} 0 R", $pageObjectNumbers)).'] /Count '.count($this->pages).' >>';

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[] = strlen($pdf);
            $pdf .= ($index + 1)." 0 obj\n{$object}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $pdf .= "xref\n0 ".(count($objects) + 1)."\n";
        $pdf .= "0000000000 65535 f \n";

        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= str_pad((string) $offsets[$i], 10, '0', STR_PAD_LEFT)." 00000 n \n";
        }

        $pdf .= "trailer\n<< /Size ".(count($objects) + 1)." /Root 1 0 R >>\nstartxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }
}
