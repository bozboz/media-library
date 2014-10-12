<?php namespace Bozboz\MediaLibrary\Controllers;

use Input;
use View;
use Request;
use Response;
use Redirect;
use Bozboz\Admin\Controllers\ModelAdminController;
use Bozboz\Admin\Reports\Report;
use Bozboz\MediaLibrary\Decorators\MediaAdminDecorator;

class MediaLibraryAdminController extends ModelAdminController
{
	public function __construct(MediaAdminDecorator $media)
	{
		parent::__construct($media);
	}

	public function index()
	{
		if (Request::wantsJson()) {
			return $this->ajaxJSONData();
		}
		$report = new Report($this->decorator);
		$report->overrideView('media-library::overview');
		return $report->render(array('controller' => get_class($this)));
	}

	private function ajaxJSONData()
	{
		$data = array();
		foreach($this->decorator->getListingModels() as $inst) {
			$data[] = array(
				'id' => $inst->id,
				'caption' => $inst->caption ? $inst->caption : $inst->filename,
				'filename' => $inst->getFilename('library')
			);
		}
		return Response::json(array('media' => $data, 'fieldId' => 'library'));
	}

	public function store()
	{
		$modelInstance = $this->decorator->getModel()->newInstance();
		$validation = $modelInstance->getValidator();
		$input = Input::all();
		if ($validation->passesStore($input)) {
			$modelInstance->fill($input);
			//Following needs to be worked out dynamically
			$modelInstance->metadata_type = 'Bozboz\MediaLibrary\Models\ImageMetadata';
			$modelInstance->save();
			$this->decorator->updateSyncRelations($modelInstance, $input);
			$response = Redirect::action(get_class($this) . '@index');
		} else {
			$response = Redirect::back()->withErrors($validation->getErrors())->withInput();
		}

		return $response;
	}

	public function edit($id)
	{
		$media = $this->decorator->getModel()->find($id);
		$metadata = $media->metadata;
		/* dd($metadata); //need to manually link up in database */

		return View::make('media-library::edit', array(
			'media' => $media,
			'mediaFields' => $this->decorator->buildFields($media),
			'metadata' => $metadata,
			'metadataFields' => $metadata->getDecorator()->buildFields($metadata),
			'method' => 'PUT',
			'modelName' => class_basename(get_class($this->decorator->getModel())),
			'listingAction' => get_class($this) . '@index',
		));
	}

	public function update($id)
	{
		$modelInstance = $this->decorator->getModel()->find($id);

		$validation = $this->decorator->getModel()->getValidator();
		$validation->updateUniques($modelInstance->getKey());

		$input = Input::all();

		$metadataFormValues = [];
		foreach ($input as $key => $value) {
			if (strpos($key, 'metadata') !== false) {
				$cleanKey = str_replace('metadata_', '', $key);
				$metadataFormValues[$cleanKey] = $value;
				unset($input[$key]);
			}
		}

		//ADD VALIDATION LOGIC
		$metadata = $modelInstance->metadata;
		if (is_null($metadata)) {
			$metadata = $modelInstance->metadata()->getRelated();
			$metadata = $metadata->create($metadataFormValues);
			$modelInstance->metadata()->sync([$metadata->id]);
		} else {
			$metadata->fill($metadataFormValues);
			$metadata->save();
		}

		if ($validation->passesEdit($input)) {
			$modelInstance->fill($input);
			$modelInstance->save();
			$this->decorator->updateSyncRelations($modelInstance, $input);
			$response = Redirect::action(get_class($this) . '@index');
		} else {
			$response = Redirect::back()->withErrors($validation->getErrors())->withInput();
		}

		return $response;
	}
}
