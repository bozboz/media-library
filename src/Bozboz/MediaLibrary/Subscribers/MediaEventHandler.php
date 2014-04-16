<?php namespace Bozboz\MediaLibrary\Subscribers;

use Bozboz\MediaLibrary\Fields\MediaBrowser;
use Bozboz\MediaLibrary\Models\Media;
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
			$input = Input::get('media', array());
			$relationship = Media::forModel($model);
			$current = $relationship->get();
			$currentIds = array_pluck($current, 'id');

			$toDetach = array_diff($currentIds, $input);
			$toAttach = array_diff($input, $currentIds);
			
			if ($toDetach) {
				$relationship->detach($toDetach);
			}
			if ($toAttach) {
				$relationship->attach($toAttach);
			}
		}
	}

	public function subscribe($events)
	{
		$class = get_class($this);
		$events->listen('admin.fields.built', $class . '@onFieldsBuilt');
		$events->listen('eloquent.saved: *', $class . '@onEloquentSaved');
	}

}
