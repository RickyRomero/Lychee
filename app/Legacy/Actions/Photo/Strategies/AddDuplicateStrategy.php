<?php

/**
 * SPDX-License-Identifier: MIT
 * Copyright (c) 2017-2018 Tobias Reich
 * Copyright (c) 2018-2025 LycheeOrg.
 */

namespace App\Legacy\Actions\Photo\Strategies;

use App\Exceptions\ModelDBException;
use App\Exceptions\PhotoResyncedException;
use App\Exceptions\PhotoSkippedException;
use App\Models\Photo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

final class AddDuplicateStrategy extends AbstractAddStrategy
{
	/**
	 * @throws PhotoSkippedException
	 * @throws ModelDBException
	 * @throws ModelNotFoundException
	 */
	public function do(): Photo
	{
		$has_been_re_synced = false;

		// At least update the existing photo with additional metadata if
		// available
		if ($this->parameters->import_mode->shall_resync_metadata) {
			$this->hydrateMetadata();
			if ($this->photo->isDirty()) {
				Log::notice(__METHOD__ . ':' . __LINE__ . ' Updating metadata of existing photo.');
				$this->photo->save();
				$has_been_re_synced = true;
			}
		}

		if ($this->parameters->import_mode->shall_skip_duplicates) {
			if ($has_been_re_synced) {
				throw new PhotoResyncedException();
			} else {
				throw new PhotoSkippedException();
			}
		} else {
			// Duplicate the existing photo, this will also duplicate all
			// size variants without actually duplicating physical files
			$existing = $this->photo;
			$this->photo = $existing->replicate();
			// Adopt settings of duplicated photo acc. to target album
			$this->photo->is_starred = $this->parameters->is_starred;
			$this->setParentAndOwnership();
			$this->photo->save();
		}

		return $this->photo;
	}
}
