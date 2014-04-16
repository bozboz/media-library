<?php namespace Bozboz\MediaLibrary\Decorators;

use Bozboz\Admin\Decorators\ModelAdminDecorator;
use Bozboz\MediaLibrary\Models\Media;
use Illuminate\Config\Repository;

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
			'image' => sprintf('<img src="/images/%s" width="150">', $instance->filename)
		);
	}

	public function getLabel($instance)
	{

	}

	public function getFields()
	{
		return array(
			new \Bozboz\Admin\Fields\SelectField(
				array(
					'name' => 'type',
					'options' => $this->config->get('media-library::allowed_media_types')
				)
			),
			new \Bozboz\Admin\Fields\FileField(array('name' => 'filename'))
		);
	}
}
