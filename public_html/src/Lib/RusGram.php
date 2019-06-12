<?php
/**
 * Created by PhpStorm.
 * User: tune
 * Date: 17.11.15
 * Time: 17:00
 */

namespace App\Lib;


class RusGram
{
	/**
	 * Склонение слова по числу
	 *
	 * @param int $digit
	 * @param array $expr массив из 2х фраз в родительном педеже
	 * @param bool|false $onlyword
	 * @return string
	 */
	public static function declension($digit, $expr, $onlyword = false) {
		if (!is_array($expr))
			$expr = array_filter(explode(' ', $expr));

		if (empty($expr[2]))
			$expr[2] = $expr[1];

		$i = preg_replace('/[^0-9]+/s', '', $digit) % 100;
		if ($onlyword)
			$digit = '';
		if ($i >= 5 && $i <= 20)
			$res = $digit . ' ' . $expr[2];
		else {
			$i %= 10;
			if ($i == 1)
				$res = $digit . ' ' . $expr[0];
			elseif ($i >= 2 && $i <= 4)
				$res = $digit . ' ' . $expr[1];
			else
				$res = $digit . ' ' . $expr[2];
		}
		return trim($res);
	}
}