<?php namespace Bozboz\MediaLibrary\Controllers;

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
		$report = new Report($this->decorator);
		$report->overrideView('media-library::overview');
		return $report->render(array('controller' => get_class($this)));
	}
}
