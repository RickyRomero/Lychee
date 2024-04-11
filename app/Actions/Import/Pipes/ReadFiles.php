<?php

namespace App\Actions\Import\Pipes;

use App\Contracts\ImportPipe;

class ReadDirectories implements ImportPipe
{
	public function handle(Processing $data, \Closure $next): Processing
	{
		$this->recurse($data->path, $data);

		return $next($data);
	}

	private function recurse(string $path, Processing $data)
	{
		$paths = [];
		foreach (new \DirectoryIterator($path) as $fileInfo) {
			if ($fileInfo->isDot() || !$fileInfo->isDir()) {
				continue;
			}
			$paths[] = $path . DIRECTORY_SEPARATOR . $fileInfo->getFilename();
		}

		$data->directories = array_merge($data->directories, $paths);
		foreach ($paths as $path_recursion) {
			$this->recurse($path_recursion, $data);
		}
	}
}