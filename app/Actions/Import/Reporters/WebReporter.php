<?php

namespace App\Actions\Import\Reporter;

use App\Contracts\Reporter;
use App\DTO\BaseImportReport;
use App\DTO\ImportEventReport;
use App\Exceptions\Handler;
use Illuminate\Database\Eloquent\JsonEncodingException;

/**
 * Output status update to web-client via {@link StreamedResponse}.
 *
 * This method reports JSON objects.
 * The outer caller precedes and terminates the whole output by `[` and
 * `]`, resp., in order to indicate the start and end of a JSON
 * array.
 * This method also inserts the commas between objects.
 *
 * If the `ImportReport` carries an exception, the exception is logged
 * via the standard mechanism of the exception handler.
 *
 * @param BaseImportReport $report the report
 *
 * @return void
 */
class WebReporter implements Reporter
{
	public function __construct(
		private bool $firstReportGiven = false
	) {
	}

	public function report(BaseImportReport $report): void
	{
		try {
			if ($this->firstReportGiven) {
				echo ',';
			}
			echo $report->toJson();
			$this->firstReportGiven = true;
			if (ob_get_level() > 0) {
				ob_flush();
			}
			flush();
		} catch (JsonEncodingException) {
			// do nothing
		}

		if ($report instanceof ImportEventReport && $report->getException() !== null) {
			Handler::reportSafely($report->getException());
		}
	}
}
