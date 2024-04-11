<?php

namespace App\Actions\Import\Pipes;

use App\Contracts\ImportPipe;

class ReadDirectories implements ImportPipe
{
	public function handle(Processing $data, \Closure $next): Processing
	{
		$data->directories = $this->rglob($data->path);

		return $next($data);
	}

	private function rglob(string $pattern): array
	{
		$dirs = glob($pattern, GLOB_ONLYDIR);

		foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR) as $dir) {
			$dirs = array_merge(
				[],
				...[$dirs, $this->rglob($dir . DIRECTORY_SEPARATOR . basename($pattern), GLOB_ONLYDIR)]
			);
		}

		return $dirs;
	}
}