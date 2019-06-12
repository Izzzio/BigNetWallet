<?php
namespace App\Lib;

/**
 * Класс с функциями для работы с файлами
 */
class File
{

	/**
	 * Зипует файлы
	 *
	 * @param array $files - файлы, которые нужно зипануть
	 * @param $newFile - полное имя нового файла. если не передать, то будет DOWNLOAD_PATH . uniqid()
	 * @param bool $deleteOld - удалять ли файлы
	 *
	 * @return string. Имя файла
	 */
	public static function zip($files, $newFile = null, $deleteOld = false) {
		$files = (array)$files;

		if (!is_dir(DOWNLOAD_PATH))
			mkdir(DOWNLOAD_PATH, 0755);

		if (empty($newFile)) {
			$newFile = DOWNLOAD_PATH . uniqid();
		}
		if (!preg_match('/\.zip$/i', $newFile)) {
			$newFile .= '.zip';
		}

		$tmpDir = TMP . uniqid();
		mkdir($tmpDir);
		$zipFiles = [];
		$currentDir = getcwd();
		chdir($tmpDir);
		foreach ($files as $file) {
			$path = explode(DS, $file);
			$filename = $path[count($path) - 1];
			$zipFiles[] = $filename;
			if ($deleteOld) {
				rename($file, $filename);
			} else {
				copy($file, $filename);
			}
		}
		if (file_exists($newFile)) {
			unlink($newFile);
		}

		exec('zip -r "' . $newFile . '" "' . implode('" "', $zipFiles) . '"');
		foreach ($zipFiles as $file) {
			unlink($file);
		}
		chdir($currentDir);
		rmdir($tmpDir);
		return $newFile;
	}

    /**
     * Создаёт путь, если он не существует
     *
     * @param string $path - путь для проверки
     *
     * @return void
     */
    public static function createPathIfNotExist($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }

}