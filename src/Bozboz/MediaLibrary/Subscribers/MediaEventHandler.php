<?php namespace Bozboz\MediaLibrary\Subscribers;

use Bozboz\MediaLibrary\Fields\MediaBrowser;
use Bozboz\MediaLibrary\Models\Media;
use Bozboz\Admin\Components\Menu;
use Config, Input;

class MediaEventHandler
{
	private function isMediableModel($model)
	{
		$models = Config::get('media-library::models');
		return array_key_exists(get_class($model), $models);
	}

	public function onFieldsBuilt($fieldsObj, $model)
	{
		if ($this->isMediableModel($model)) {
			$fieldsObj[] = new MediaBrowser($model, new Media, array('name' => 'media'));
		}
	}

	public function onEloquentSaved($model)
	{
		if ($this->isMediableModel($model)) {
			$data = array();
			$media = is_array(Input::get('media'))? Input::get('media') : array();
			foreach($media as $i => $uid) {
				$data[$uid] = array('sorting' => $i);
			}
			Media::forModel($model)->sync($data);
		}
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
