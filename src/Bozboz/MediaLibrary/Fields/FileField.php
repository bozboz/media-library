<?php namespace Bozboz\MediaLibrary\Fields;

use Bozboz\Admin\Fields\Field;
use Illuminate\Support\Facades\Form;
use InvalidArgumentException;

class FileField extends Field
{
	public function getInput()
	{
		$html = '';
		if ($filename = Form::getValueAttribute('filename')) {
			$html .= sprintf('<img src="/images/thumb/media/image/%s" style="margin-bottom: 5px; display: block">', $filename);
		}
		$html .= Form::hidden($this->get('name'));
		$html .= Form::file($this->get('name'), $this->attributes);
		return $html;
	}
}
