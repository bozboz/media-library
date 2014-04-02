<?php namespace Bozboz\MediaLibrary\Fields;

use Bozboz\Admin\Fields\Field;
use Bozboz\MediaLibrary\Models\Media;
use Eloquent, Form;

class MediaBrowser extends Field
{
	private $factory;

	public function __construct(Eloquent $factory, $params = array())
	{
		$this->factory = $factory;
		parent::__construct($params);
	}

	public function getInput($params)
	{
		$currentValues = $this->getCurrentValues();
		$html = '<ul>';
		foreach (Media::all() as $i => $media) {
			$id = $media->id;
			$name = $this->get('name');
			$image = sprintf('<img src="/images/%s" width="150">', $media->filename);
			$selected = in_array($media->id, $currentValues);
			$input = Form::checkbox($name . '[]', $media->id, $selected, array('id' => 'media-' . $media->id));
			$html .= "<li data-id='$id'><label for='media-{$media->id}'>$image</label>{$input}</li>";
		}
		
		$html .= '</ul>';

		return $html;
	}

	public function getCurrentValues()
	{
		$id = Form::getValueAttribute('id');
		$instance = $this->factory->find($id);
		$current = Media::forModel($instance)->get();
		return array_pluck($current, 'id');
	}
}
