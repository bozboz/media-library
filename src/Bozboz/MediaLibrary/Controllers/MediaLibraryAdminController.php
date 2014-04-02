<?php namespace Bozboz\MediaLibrary\Controllers;

use Bozboz\Admin\Controllers\ModelAdminController;
use Bozboz\MediaLibrary\Decorators\MediaAdminDecorator;

class MediaLibraryAdminController extends ModelAdminController
{
	public function __construct(MediaAdminDecorator $media)
	{
		parent::__construct($media);
	}
}
