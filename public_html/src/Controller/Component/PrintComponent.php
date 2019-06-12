<?php
namespace App\Controller\Component;

use App\Lib\File;
use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\Configure;

class PrintComponent extends Component
{
	const PRINTER_ARGOX = 'Argox';            // принтер Argox для печати стикеров
	const PRINTER_ZEBRA = 'Zebra';            // принтер Zebra для упаковочных стикеров 57x60
	const PRINTER_ZEBRA_BIG = 'ZebraBig';    // принтер Zebra для упаковочных стикеров 100x150
	const PRINTER_TSP143 = 'TSP143';        // принтер чеков
	const PRINTER_STAR = 'Star';            // принтер чеков на складе
	const PRINTER_SHOP = 'Shop';            // рабочий копир

	protected static $_printers = [
		self::PRINTER_ARGOX,
		self::PRINTER_ZEBRA,
		self::PRINTER_ZEBRA_BIG,
		self::PRINTER_TSP143,
		self::PRINTER_SHOP,
		self::PRINTER_STAR,
	];

	const  PRINTER_STAR_PDF_SIZE = '72mm*200mm';

	protected $_dirBase = "production";
	protected $_dir = '';

	protected $_wwwDirBase = WWW_ROOT;
	protected $_wwwdir = '';


	/**
	 * Инициализация.
	 * Создаёт папку, если такой не существует.
	 *
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		if (empty($config['dir'])) {
			$config['dir'] = '';
		}
		$this->setDir($config['dir']);
	}

	public function setDir($dir) {
		$this->_dir = $this->_dirBase . (!empty($dir) ? DS . $dir : '');
		$this->_wwwdir = $this->_wwwDirBase . DS . $this->_dir . DS;
		return $this;
	}

	/**
	 * Зипует и печатает файлы
	 *
	 * @param array $files - файлы
	 * @param string $printer - принтер
	 * @param string $downloadName - как будет называться файл после скачивания (если будет скачивание, а не печать)
	 * @param $newFileName - как будет называться архив. По умолчанию - uniqid()
	 * @param $delete - удалять ли файлы
	 * @return \Cake\Network\Response - редирект на печать
	 */
	public function zipAndPrintFiles($files, $printer, $downloadName, $newFileName = null, $delete = true) {
		if (empty($newFileName)) {
			$newFileName = uniqid();
		}
		$newFileName .= '.zip';
		$newFileFullName = $this->_wwwdir . $newFileName;
		File::zip($files, $newFileFullName, $delete);
		return $this->printFile($this->_dir . DS . $newFileName, $printer, $downloadName);
	}

	/**
	 * Зипует и даёт ссылку на печать файла
	 *
	 * @param array $files - файлы
	 * @param string $printer - принтер
	 * @param string $downloadName - как будет называться файл после скачивания (если будет скачивание, а не печать)
	 * @param $newFileName - как будет называться архив. По умолчанию - uniqid()
	 * @param $delete - удалять ли файлы
	 * @return \Cake\Network\Response - редирект на печать
	 */
	public function zipAndReturnPrintFile($files, $printer, $downloadName, $newFileName = null, $delete = true) {
		if (empty($newFileName)) {
			$newFileName = uniqid();
		}
		$newFileName .= '.zip';
		$newFileFullName = $this->_wwwdir . $newFileName;
		File::zip($files, $newFileFullName, $delete);
		$this->response->location($this->printLink($this->_dir . DS . $newFileName, $printer));
		return $this->response;
	}

	/**
	 * Печатает файл. Для ubuntu отсылает на печать через наш asprint (делает редирект); для всего остального -
	 * скачивает
	 *
	 * @param string $fileShortName - имя файла, начиная с папки в webroot (не включая её)
	 * @param string $printer - принтер
	 * @param string $fileDownloadName - как будет называться файл после скачивания
	 * @return \Cake\Network\Response - редирект на печать
	 */
	public function printFile($fileShortName, $printer, $fileDownloadName) {
		$link = $this->printLink($fileShortName, $printer);
		if (preg_match('/linux/i', $this->request->header('User-Agent'))) {
			$this->response->location($link);
		} else {
			$this->response->file(WWW_ROOT . $fileShortName, [
				'name' => $fileDownloadName . '.zip',
				'download' => true,
			]);
		}
		return $this->response;
	}

	/**
	 * Возвращает ссылку для печати
	 *
	 * @param string $fileShortName - имя файла, начиная с папки в webroot (не включая её)
	 * @param string $printer - принтер
	 * @throws \Exception Если передан неправильный принтер
	 * @return string ссылка
	 */
	public function printLink($fileShortName, $printer) {
		if (!in_array($printer, self::$_printers)) {
			throw new \Exception('Неизвестный принтер');
		}
		$link = Configure::read('serverName') . URL_PREFIX . DS . $fileShortName;
		if (preg_match('/linux/i', $this->request->header('User-Agent'))) {
			return 'asprint://' . $link . '#' . $printer;
		} else {
			return 'http://' . $link;
		}

	}


}
