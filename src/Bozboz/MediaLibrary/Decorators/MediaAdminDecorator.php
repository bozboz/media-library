<?php namespace Bozboz\MediaLibrary\Decorators;

use Bozboz\Admin\Decorators\ModelAdminDecorator;
use Bozboz\MediaLibrary\Models\Media;
use Illuminate\Config\Repository;
use Bozboz\Admin\Fields\SelectField;
use Bozboz\Admin\Fields\FileField;

class MediaAdminDecorator extends ModelAdminDecorator
{
	private $config;

	public function __construct(Media $media, Repository $config)
	{
		$this->config = $config;
		parent::__construct($media);
	}

	public function getColumns($instance)
	{
		return array(
			'id' => $instance->id,
			'image' => sprintf('<img src="%s" width="150">', $instance->getFilename('thumb'))
		);
	}

	public function getLabel($instance)
	{

	}

	public function getFields()
	{
		return array(
			new SelectField(array('name' => 'type', 'options' => $this->config->get('media-library::allowed_media_types', array(
				'image' => 'Image',
				'pdf' => 'PDF'
			)))),
			new FileField(array('name' => 'filename'))
		);
	}
}
