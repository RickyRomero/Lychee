<?php

namespace App\Contracts;

use App\Actions\Import\Pipes\Processing;

/**
 * Basic definition of a ImportPipe pipe.
 *
 * handle function takes as input the list of the previous errors/information
 * and return the updated list.
 */
interface ImportPipe
{
	/**
	 * @param Processing                             $data
	 * @param \Closure(Processing $data): Processing $next
	 *
	 * @return Processing
	 */
	public function handle(Processing $data, \Closure $next): Processing;
}