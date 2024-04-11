<?php

namespace App\Actions\Import\Pipes;

use App\Contracts\ImportPipe;
use App\Exceptions\FileOperationException;

class ReadIgnoreList implements ImportPipe
{
	public function handle(Processing $data, \Closure $next): Processing
	{
		if (is_readable($data->path . '/.lycheeignore')) {
			try {
				$result = file($data->path . '/.lycheeignore');
			} catch (\Throwable) {
				throw new FileOperationException('Could not read ' . $data->path . '/.lycheeignore');
			}

			$data->ignore_list = array_merge($data->ignore_list, $result);
		}

		return $next($data);
	}
}