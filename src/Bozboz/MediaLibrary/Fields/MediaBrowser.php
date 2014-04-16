<?php namespace Bozboz\MediaLibrary\Fields;

use Bozboz\Admin\Fields\Field;
use Bozboz\MediaLibrary\Models\Media;
use Eloquent, Form;

class MediaBrowser extends Field
{
	private $modelFactory;
	private $mediaFactory;

	public function __construct(Eloquent $modelFactory, Media $mediaFactory, $params = array())
	{
		$this->modelFactory = $modelFactory;
		$this->mediaFactory = $mediaFactory;
		parent::__construct($params);
	}

	public function getInput($params)
	{
		$currentValues = $this->getCurrentValues();
		$items = array();

		foreach ($this->mediaFactory->all() as $i => $media) {
			$items[] = sprintf($this->getListItemHTML(),
				$media->id,
				$media->id,
				$media->filename,
				Form::checkbox(
					$this->get('name') . '[]',
					$media->id,
					in_array($media->id, $currentValues),
					array('id' => 'media-' . $media->id)
				)
			);
		}

		return '<ul>' . implode(PHP_EOL, $items) . '</ul>';
	}

	public function getListItemHTML()
	{
		return '
		<li data-id="%d">
			<label for="media-%d"><img src="/images/%s" width="150"></label>
			%s
		</li>';
	}

	/**
	 * Get the IDs of Media this model is related to.
	 *
	 * @return array Media IDs related to the model being created/edited
	 */
	public function getCurrentValues()
	{
		$id = Form::getValueAttribute('id');
		$instance = $this->modelFactory->find($id);

		if (empty($instance)) { //new model
			return array();
		} else {
			$current = $this->mediaFactory->forModel($instance)->get();
			return array_pluck($current, 'id');
		}
	}
}
