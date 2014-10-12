<?php namespace Bozboz\MediaLibrary\Decorators;

use Bozboz\Admin\Decorators\ModelAdminDecorator;
use Bozboz\MediaLibrary\Models\ImageMetaData;
use Bozboz\Admin\Fields\TextField;

class ImageMetadataAdminDecorator extends ModelAdminDecorator
{
	public function __construct(ImageMetaData $metaData)
	{
		parent::__construct($metaData);
	}

	public function getLabel($instance)
	{
		return null;
	}

	public function getColumns($instance)
	{
		return null;
	}

	public function getFields($instance)
	{
		return [
			new TextField([
				'name' => 'metadata_alt_text',
				'label' => 'Alt Text',
			])
		];
	}
}
