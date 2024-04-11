<?php

namespace App\Actions\Import\Reporter;

use App\Contracts\Reporter;
use App\DTO\BaseImportReport;
use App\DTO\ImportEventReport;
use App\Exceptions\Handler;

/**
 * Output status update to stdout.
 *
 * The output is either sent to the CLI.
 * We print lines terminated by a newline character.
 *
 * If the `ImportReport` carries an exception, the exception is logged
 * via the standard mechanism of the exception handler.
 *
 * @param BaseImportReport $report the report
 *
 * @return void
 */
class CliReporter implements Reporter
{
	public function report(BaseImportReport $report): void
	{
		echo $report->toCLIString() . PHP_EOL;

		if ($report instanceof ImportEventReport && $report->getException() !== null) {
			Handler::reportSafely($report->getException());
		}
	}
}
