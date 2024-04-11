<?php

namespace App\Actions\Import\Pipes;

class Processing
{
	public string $path;
	public ImportParameters $params;
	/** @var array<string,array<int,string>> */
	public array $ignore_list = [];
	/** @var array<int,string> */
	public array $directories = [];

	public function __construct(
	) {
	}
}
