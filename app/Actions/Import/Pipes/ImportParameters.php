<?php

namespace App\Actions\Import\Pipes;

use App\Actions\Album\Create as AlbumCreate;
use App\Actions\Import\Reporter\CliReporter;
use App\Actions\Import\Reporter\SilentReporter;
use App\Actions\Import\Reporter\WebReporter;
use App\Actions\Photo\Create as PhotoCreate;
use App\Actions\Photo\Strategies\ImportMode;
use App\Assets\Features;
use App\Contracts\Reporter;

class ImportParameters
{
	public readonly Reporter $reporter;

	public function __construct(
		public ImportMode $importMode,
		public PhotoCreate $photoCreate,
		public AlbumCreate $albumCreate,
		public int $memLimit = 0,
		public bool $memWarningGiven = false,
		private bool $firstReportGiven = false,
		bool $enableCLIFormatting = false,
	) {
		$this->reporter = $enableCLIFormatting ? new CliReporter()
			: Features::when('livewire', fn () => new SilentReporter(), fn () => new WebReporter());
	}
}
