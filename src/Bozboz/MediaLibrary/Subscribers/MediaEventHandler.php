<?php namespace Bozboz\MediaLibrary\Subscribers;

use Bozboz\MediaLibrary\Fields\MediaBrowser;
use Bozboz\MediaLibrary\Models\Media;
use Bozboz\Admin\Components\Menu;
use Config, Input;

class MediaEventHandler
{
	public function onFieldsBuilt($fieldsObj, $model)
	{
		if ($this->isMediableModel($model)) {
			$fieldsObj[] = new MediaBrowser($model, new Media, [
				'name' => 'media',
				'aliases' => $this->getModelAliases($model)
			]);
		}
	}

	public function onEloquentSaved($model)
	{
		if ($this->isMediableModel($model) && $this->inputHasMediaData()) {
			$sync = array();
			$media = is_array(Input::get('media'))? Input::get('media') : array();
			foreach($media as $i => $data) {
				if (array_key_exists('id', $data)) {

					$sync[$data['id']] = ['sorting' => $i];
					if (!empty($data['alias'])) {
						$sync[$data['id']]['alias'] = $data['alias'];
					}
				}
			}
			Media::forModel($model)->sync($sync);
		}
	}

	/**
	 * Determine whether user came from a form containing
	 * a "media" input.
	 */
	private function inputHasMediaData()
	{
		return !is_null(Input::get('media'));
	}

	private function isMediableModel($model)
	{
		$models = Config::get('media-library::models');
		return array_key_exists(get_class($model), $models);
	}

	private function getModelAliases($model)
	{
		return Config::get('media-library::models.' . get_class($model));
	}

	public function onRenderMenu(Menu $menu)
	{
		$menu['Media Library'] = route('admin.media.index');
	}

	public function subscribe($events)
	{
		$class = get_class($this);
		$events->listen('admin.fields.built', $class . '@onFieldsBuilt');
		$events->listen('eloquent.saved: *', $class . '@onEloquentSaved');
		$events->listen('admin.renderMenu', $class . '@onRenderMenu');
	}

}
