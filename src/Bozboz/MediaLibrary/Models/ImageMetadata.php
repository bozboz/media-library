<?php namespace Bozboz\MediaLibrary\Models;

use Bozboz\Admin\Models\Base;
use Bozboz\MediaLibrary\Validators\ImageMetadataValidator;
use Bozboz\MediaLibrary\Decorators\ImageMetadataAdminDecorator;

class ImageMetadata extends Base
{
	public $timestamps = false;

	protected $table = 'media_image_metadata';

	protected $fillable = ['alt_text'];

	public function media()
	{
		return $this->morphOne('Media', 'metadata');
	}

	public function getValidator()
	{
		return new ImageMetadataValidator();
	}

	public function getDecorator()
	{
		return new ImageMetadataAdminDecorator($this);
	}
}
