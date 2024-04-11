<?php

namespace App\Actions\Import\Pipes;

use App\Contracts\ImportPipe;

class FilterIgnoreList implements ImportPipe
{
	public function handle(Processing $data, \Closure $next): Processing
	{
		return $next($data);
	}

	/**
	 * Check if file is in the ignore list.
	 *
	 * @param array<int,string> $ignore_list
	 * @param string            $filename
	 *
	 * @return bool
	 */
	private function checkIgnore(array $ignore_list, string $filename): bool
	{
		$ignore_file = false;

		foreach ($ignore_list as $value_ignore) {
			if ($this->check_file_matches_pattern(basename($filename), $value_ignore)) {
				$ignore_file = true;
				break;
			}
		}

		return $ignore_file;
	}

	/**
	 * @param string $pattern
	 * @param string $filename
	 *
	 * @return bool
	 */
	private function check_file_matches_pattern(string $pattern, string $filename): bool
	{
		// This function checks if the given filename matches the pattern allowing for
		// star as wildcard (as in *.jpg)
		// Example: '*.jpg' matches all jpgs

		$pattern = preg_replace_callback('/([^*])/', fn (array $a) => preg_quote($a[1], '/'), $pattern);
		$pattern = str_replace('*', '.*', $pattern);

		return preg_match('/^' . $pattern . '$/i', $filename) === 1;
	}
}