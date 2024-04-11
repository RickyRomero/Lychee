<?php

namespace App\Actions\Import\Reporter;

use App\Contracts\Reporter;
use App\DTO\BaseImportReport;
use App\DTO\ImportEventReport;
use App\Exceptions\Handler;

/**
 * This reporter, as its name suggest, does not output anything.
 *
 * If the `ImportReport` carries an exception, the exception is logged
 * via the standard mechanism of the exception handler.
 *
 * @param BaseImportReport $report the report
 *
 * @return void
 */
class SilentReporter implements Reporter
{
	public function report(BaseImportReport $report): void
	{
		if ($report instanceof ImportEventReport && $report->getException() !== null) {
			Handler::reportSafely($report->getException());
		}
	}
}
