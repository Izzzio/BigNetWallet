<?php

namespace App\Lib;

class Csv
{
	/**
	 * Читает csv файл и возвращает массив
	 *
	 * @param $csv_fl
	 * @param string $delimiter
	 * @param bool $skip_empty_lines
	 * @param bool $trim_fields
	 * @return array
	 */
	public function parseCsv($csv_fl, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true) {
		$result = [];
		ini_set('auto_detect_line_endings', true);
		$handle = fopen($csv_fl, 'r');
		if (!$handle) {
			return [];
		}
		while (($data = fgetcsv($handle, null, $delimiter)) !== false) {
			$result[] = $data;
		}
		ini_set('auto_detect_line_endings', false);
		return $result;
	}

	/**
	 * Формируем ассоциативный массив из CSV файла, первая строка - имена элементов массива
	 *
	 * @param $csv_fl
	 * @param string $delimiter
	 * @param bool|true $skip_empty_lines
	 * @param bool|true $trim_fields
	 * @return array|bool
	 */
	public function createAssocArrayFromCsv($csv_fl, $delimiter = ",", $skip_empty_lines = true, $trim_fields = true) {
		$lines = $this->parseCsv($csv_fl, $delimiter, $skip_empty_lines, $trim_fields);
		if (count($lines) < 2) {
			return false;
		}

		$names = $lines[0];
		unset($lines[0]);

		$result = [];
		foreach ($lines as $ln) {
			$ins = [];
			foreach ($names as $k => $nm) {
				$ins[$nm] = $ln[$k];
			}

			$result[] = $ins;
		}

		return $result;
	}

}