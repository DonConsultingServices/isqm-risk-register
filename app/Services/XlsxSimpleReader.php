<?php

namespace App\Services;

use ZipArchive;

class XlsxSimpleReader
{
    public function read(string $xlsxPath): array
    {
        $zip = new ZipArchive();
        if ($zip->open($xlsxPath) !== true) {
            throw new \RuntimeException('Cannot open xlsx file');
        }

        $shared = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml !== false) {
            $sx = new \SimpleXMLElement($sharedXml);
            $sx->registerXPathNamespace('d', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            foreach ($sx->xpath('//d:si') as $si) {
                $text = '';
                foreach ($si->t as $t) { $text .= (string)$t; }
                if ($text === '' && isset($si->r)) {
                    foreach ($si->r as $r) { $text .= (string)$r->t; }
                }
                $shared[] = (string)$text;
            }
        }

        $sheets = [];
        // workbook to get sheet ordering and names
        $workbookXml = $zip->getFromName('xl/workbook.xml');
        $relsXml = $zip->getFromName('xl/_rels/workbook.xml.rels');
        if ($workbookXml && $relsXml) {
            $wb = new \SimpleXMLElement($workbookXml);
            $wb->registerXPathNamespace('d', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
            $rels = new \SimpleXMLElement($relsXml);
            $rels->registerXPathNamespace('r', 'http://schemas.openxmlformats.org/package/2006/relationships');
            $idToTarget = [];
            foreach ($rels->Relationship as $r) {
                $idToTarget[(string)$r['Id']] = (string)$r['Target'];
            }
            foreach ($wb->sheets->sheet as $sheet) {
                $name = (string)$sheet['name'];
                $rid = (string)$sheet->attributes('http://schemas.openxmlformats.org/officeDocument/2006/relationships')['id'];
                $target = $idToTarget[$rid] ?? null;
                if ($target && str_starts_with($target, 'worksheets/')) {
                    $xml = $zip->getFromName('xl/'.$target);
                    if ($xml) {
                        $sheets[$name] = $this->parseSheet($xml, $shared);
                    }
                }
            }
        }

        $zip->close();
        return $sheets;
    }

    private function parseSheet(string $xml, array $shared): array
    {
        $rows = [];
        $sx = new \SimpleXMLElement($xml);
        $sx->registerXPathNamespace('d', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');
        foreach ($sx->sheetData->row as $row) {
            $cells = [];
            foreach ($row->c as $c) {
                $t = (string)$c['t'];
                $v = (string)$c->v;
                if ($t === 's') {
                    $idx = (int)$v;
                    $cells[] = $shared[$idx] ?? '';
                } else {
                    $cells[] = $v;
                }
            }
            $rows[] = $cells;
        }
        return $rows;
    }
}


