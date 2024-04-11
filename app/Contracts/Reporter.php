<?php

namespace App\Contracts;

use App\DTO\BaseImportReport;

interface Reporter
{
	public function report(BaseImportReport $report): void;
}