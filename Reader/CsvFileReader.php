<?php

class CsvFileReader
{
    public function read(string $path): array
    {
        $data = [];

        $file = fopen($path, 'r');

        if (!$file) {
            throw new Exception();
        }

        $header = fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $data[] = $row;
        }

        fclose($file);

        return [$header, $data];
    }
}
