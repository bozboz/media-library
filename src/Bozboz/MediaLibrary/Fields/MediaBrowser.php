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

	public function getInput()
	{
		$currentValues = $this->getCurrentValues();
		$items = array();

		foreach ($this->mediaFactory->all() as $i => $media) {
			$items[] = sprintf($this->getListItemHTML(),
				$media->id,
				Form::checkbox(
					$this->get('name') . '[]',
					$media->id,
					in_array($media->id, $currentValues),
					array('class'=> 'media-is-used', 'id' => 'media-' . $media->id)
				),
				$media->id,
				$media->getFilename('library'),
				$media->caption ? $media->caption : $media->filename
			);
		}

		return '<ul class="js-mason secret-list">' . implode(PHP_EOL, $items) . '</ul>';
	}

	public function getListItemHTML()
	{
		return '
		<li class="masonry-item masonry-item-inline-media" data-id="%d">
			%s
			<label for="media-%d">
				<img src="%s" width="150">
				<p class="icons">%s</p>
			</label>
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
