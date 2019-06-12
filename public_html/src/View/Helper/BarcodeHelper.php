<?php
namespace App\View\Helper;

use Cake\View\Helper;
use TCPDFBarcode;

class BarcodeHelper extends Helper {

	/**
	 * Генерирует HTML-код для штрих-кода
	 * @param string $code
	 * @param string $type
	 * @param int $width
	 * @param int $height
	 * @param string $color
	 * @return string
	 */
	public function html($code, $type = 'C128B', $width = 2, $height = 100, $color = 'black') {
		$generator = new TCPDFBarcode($code, $type);
		return $generator->getBarcodeHTML($width, $height, $color);
	}

}