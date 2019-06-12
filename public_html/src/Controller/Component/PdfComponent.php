<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\View\View;

/**
 * Class PdfComponent
 *
 * @package App\Controller\Component
 * @property \App\Controller\Component\PrintComponent $Print
 */
class PdfComponent extends Component
{

	const A4_LANDSCAPE = "29.7cm*21cm";

	protected $_dirBase = "production";
	protected $_dir = '';

	protected $_tmpdir = '';
	protected $_wwwdir = '';
	protected $_wwwDirBase = WWW_ROOT;


	/**
	 * Инициализация.
	 * Создаёт папку, если такой не существует.
	 *
	 * @param array $config
	 * @return void
	 */
	public function initialize(array $config) {
		$this->_tmpdir = TMP . 'pdf' . DS;

		if (!is_dir($this->_tmpdir)) {
			mkdir($this->_tmpdir, 0755, true);
		}

		if (empty($config['dir'])) {
			$config['dir'] = '';
		}
		$this->setDir($config['dir']);

	}

	public function setDir($dir) {
		$this->_dir = $this->_dirBase . (!empty($dir) ? DS . $dir : '');
		$this->_wwwdir = $this->_wwwDirBase . $this->_dir . DS;
		return $this;
	}


	/**
	 * Сохраняет страницу $url в PDF $outfile (указывать расширение обязательно!)
	 *
	 * @param $url
	 * @param $outfile
	 * @param string $format "5in*7.5in", "10cm*20cm", "A4", "Letter"
	 * @return string
	 * @throws \Exception
	 */
	public function url2Pdf($url, $outfile, $format = "A4") {
		$arr = [];
		$stauts = 0;

		if (!file_exists(ROOT . '/vendor/PdfComponent/rastr.js')) {
			throw new \Exception('Converter script not found at ' . ROOT . '/vendor/PdfComponent/rastr.js');
		}

		exec('phantomjs ' . ROOT . '/vendor/PdfComponent/rastr.js "' . $url . '" "' . $outfile . '" ' . $format, $arr, $stauts);

		if ($stauts == 127) {
			throw new \Exception('PhantomJS not found');
		}

		if (!file_exists($outfile)) {
			throw new \Exception('PDF file not created');
		}

		return $stauts;
	}

	/**
	 * Сохраняет страницу $url в PDF и возвращает адрес сгенерированного PDF файла
	 *
	 * @param $url
	 * @param string $format
	 * @param string $filename
	 * @return string
	 */
	public function url2PdfEx($url, $format = "A4", $filename = null) {
		if (empty($filename)) {
			$filename = uniqid();
		}
		$fileFullName = $this->_wwwdir . $filename . '.pdf';
		if (file_exists($fileFullName)) {
			unlink($fileFullName);
		}
		$this->url2Pdf($url, $fileFullName, $format);
		return $fileFullName;
	}

	/**
	 * Сохраняет страницу $url в PDF и отправляет пользователю со всеми заголовками и названием $downloadName
	 *
	 * @param $url
	 * @param $downloadName
	 * @param string $format
	 * @return response
	 */
	public function sendPdfToUser($url, $downloadName, $format = "A4") {
		$name = $this->url2PdfEx($url, $format);
		$this->response->file($name, ['name' => $downloadName, 'download' => true]);
		return $this->response;
	}

	/**
	 * Текущую страницу (с layout pdf.ctp) преобразует в pdf
	 * Если хочется потестировать (посмотреть html-версию и не делать pdf), то нужно задать гет-параметр render
	 *
	 * @param string $format
	 * @param $filename
	 * @return array. Название сгенерированного файла ['full' => полный путь, 'short' => путь начиная с папки в webroot]
	 */
	public function thisPageToPDF($format = 'A4', $filename = null) {
		$controller = $this->_registry->getController();
		$view = new View($this->request);
		$view->set($controller->viewVars);
		$view->templatePath($controller->name);
		$template = $controller->viewBuilder()->template();
		if (empty($template)) {
			$template = $this->request->params['action'];
		}

		$response = $view->render($template, 'pdf');


		$render = $this->request->query('render');
		if (!empty($render)) {
			echo (string)$response;
			die;
		} else {
			$fileHTML = $this->_tmpdir . uniqid() . '.html';
			file_put_contents($fileHTML, (string)$response);
			$filePDF = $this->url2PdfEx($fileHTML, $format, $filename);
			unlink($fileHTML);
			return ['full' => $filePDF, 'short' => $this->_dir . DS . $filename . '.pdf'];
		}
	}

	/**
	 * Текущую страницу преобразует в pdf и возвращает ссылку
	 *
	 * @param string $format
	 * @param $filename
	 * @return string
	 */
	public function thisPageToPDFLink($format = 'A4', $filename = null) {
		$filename = $this->thisPageToPDF($filename, $format)['short'];
		$link = URL_PREFIX . DS . $filename;
		return $link;
	}

	/**
	 * Текущую страницу преобразует в pdf и отдаёт пользователю
	 *
	 * @param $downloadName
	 * @param string $format
	 * @return \Cake\Network\Response
	 */
	public function thisPageToPDFLoad($downloadName, $format = 'A4') {
		if (!strpos($downloadName, '.')) {
			$downloadName .= '.pdf';
		}
		$filePdf = $this->thisPageToPDF($format)['full'];
		$this->response->file($filePdf, ['name' => $downloadName, 'download' => true]);
		return $this->response;
	}

	/**
	 * Текущую страницу преобразует в pdf и печатает
	 *
	 * @param string $downloadName - название файла после скачивания (если он будет скачиваться, а не печататься)
	 * @param $zipDir - куда положить архив, который нужен для печати
	 * @param $zipName - Название архива
	 * @param bool $delete - Удалять ли пдфку
	 * @param string $printer - Какой принтер использовать
	 * @param string $format
	 * @return \Cake\Network\Response - редирект на печать
	 */
	public function thisPageToPDFPrint(
		$downloadName, $zipDir = null, $zipName = null, $format = 'A4', $printer = PrintComponent::PRINTER_SHOP) {
		$filePdf = $this->thisPageToPDF($format, $zipName);
		$controller = $this->_registry->getController();
		$controller->loadComponent('Print');
		return $controller->Print->setDir($zipDir)->zipAndPrintFiles($filePdf['full'], $printer, $downloadName, $zipName, true);
	}

	/**
	 * Текущую страницу преобразует в pdf и дает ссылку для печати
	 *
	 * @param string $downloadName - название файла после скачивания (если он будет скачиваться, а не печататься)
	 * @param $zipDir - куда положить архив, который нужен для печати
	 * @param $zipName - Название архива
	 * @param bool $delete - Удалять ли пдфку
	 * @param string $printer - Какой принтер использовать
	 * @param string $format
	 * @return \Cake\Network\Response - редирект на печать
	 */
	public function thisPageToPDFPrintLink(
		$downloadName, $zipDir = null, $zipName = null, $format = 'A4', $printer = PrintComponent::PRINTER_SHOP) {
		$filePdf = $this->thisPageToPDF($format, $zipName);
		$controller = $this->_registry->getController();
		$controller->loadComponent('Print');
		return $controller->Print->setDir($zipDir)->zipAndReturnPrintFile($filePdf['full'], $printer, $downloadName, $zipName, true);
	}

	/**
	 * Преобразует HTML код в PDF документ (еще и за собой убирает!)
	 *
	 * @param $html
	 * @param $outfile
	 * @param string $format
	 * @return string
	 */
	public function html2Pdf($html, $outfile, $format = 'A4') {
		$fileHTML = $this->_tmpdir . '/HTML_' . uniqid() . '.html';
		file_put_contents($fileHTML, (string)$html);
		$pdf = $this->url2Pdf($fileHTML, $outfile, $format);
		unlink($fileHTML);
		return $pdf;
	}

	/**
	 * Чистилка временных папок. Выбирает файлы в папке $dirPath по щаблону $exp с временем жизни больше $lifetime
	 *
	 * @param $dirPath
	 * @param string $exp
	 * @param int $lifetime
	 */
	public function cleanupTempDir($dirPath, $exp = '.*\.pdf', $lifetime = 300) {
		$dir = new Folder($dirPath);
		$files = $dir->find($exp);
		foreach ($files as $file) {
			//Если файл старше 5ти минут (300 секунд)
			if (time() - filemtime($dir->pwd() . DS . $file) >= $lifetime) {
				unlink($dir->pwd() . DS . $file); //удаляем
			}
		}
	}

}
