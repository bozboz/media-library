<?php namespace Bozboz\MediaLibrary\Validators;

use Bozboz\Admin\Services\Validators\Validator;

class ImageMetadataValidator extends Validator
{
	protected $rules = ['alt_text' => 'max:255'];
}
