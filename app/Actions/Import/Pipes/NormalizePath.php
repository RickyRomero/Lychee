<?php

namespace App\Actions\Import\Pipes;

use App\Contracts\ImportPipe;
use App\Contracts\Models\AbstractSizeVariantNamingStrategy;
use App\Exceptions\InvalidDirectoryException;
use App\Exceptions\ReservedDirectoryException;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Safe\Exceptions\FilesystemException;
use Safe\Exceptions\StringsException;
use function Safe\realpath;

class NormalizePath implements ImportPipe
{
	public function handle(Processing $data, \Closure $next): Processing
	{
		try {
			$data->path = rtrim($data->path, '/');
			$realPath = realpath($data->path);

			if (is_dir($realPath) === false) {
				throw new InvalidDirectoryException('Given path is not a directory (' . $data->path . ')');
			}

			// Skip folders of Lychee
			// Currently we must check for each directory which might be used
			// by Lychee below `uploads/` individually, because the folder
			// `uploads/import` is a potential source for imports and also
			// placed below `uploads`.
			// This is a design error and needs to be changed, at last when
			// the media is stored remotely on a network storage such as
			// AWS S3.
			// A much better folder structure would be
			//
			// ```
			//  |
			//  +-- staging           // new directory which temporarily stores media which is not yet, but going to be added to Lychee
			//  |     +-- imports     // replaces the current `uploads/import`
			//  |     +-- uploads     // temporary storage location for images which have been uploaded via an HTTP POST request
			//  |     +-- downloads   // temporary storage location for images which have been downloaded from a remote URL
			//  +-- vault             // replaces the current `uploads/` and could be outsourced to a remote network storage
			//        +-- original
			//        +-- medium2x
			//        +-- medium
			//        +-- small2x
			//        +-- small
			//        +-- thumb2x
			//        +-- thumb
			// ```
			//
			// This way we could simply check if the path is anything below `vault`
			$disk = Storage::disk(AbstractSizeVariantNamingStrategy::IMAGE_DISK_NAME);
			if ($disk->getAdapter() instanceof LocalFilesystemAdapter) {
				if (str_starts_with($realPath, $disk->path(''))) {
					throw new ReservedDirectoryException('The given path is a reserved path of Lychee (' . $data->path . ')');
				}
			}

			return $next($data);
		} catch (FilesystemException|StringsException) {
			throw new InvalidDirectoryException('Given path is not a directory (' . $data->path . ')');
		}
	}
}