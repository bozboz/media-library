<?php namespace Bozboz\MediaLibrary\Models;

use Eloquent, Input, Config;
use Bozboz\MediaLibrary\Validators\MediaValidator;
use Bozboz\MediaLibrary\Exceptions\InvalidConfigurationException;
use Bozboz\Admin\Models\Base;

class Media extends Base
{
	protected $table = 'media';
	protected $fillable = array('filename', 'type', 'caption');
	private $dynamicRelations = array();

	public function mediable()
	{
		return $this->morphTo();
	}

	public function getValidator()
	{
		return new MediaValidator;
	}

	public function setFilenameAttribute($value)
	{
		if (Input::hasFile('filename')) {
			$file = Input::file('filename');
			$destinationPath = public_path() . '/media/' . strtolower($this->type) . '/';
			$uploadSuccess = $file->move($destinationPath, $file->getClientOriginalName());
			$this->attributes['filename'] = $file->getClientOriginalName();
		} else {
			$this->attributes['filename'] = $value;
		}
	}

	/**
	 * Accessor method to retrieve all media on a model
	 *
	 * @param $model Eloquent
	 * @return Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public static function forModel(Eloquent $model)
	{
		return $model->morphToMany(get_class(), 'mediable')->withPivot('alias')->orderBy('sorting');
	}

	public function scopeAlias($query, $alias)
	{
		$query->where('alias', '=', $alias);
	}

	public function getFilename($size = null)
	{
		if (!is_null($size)) {
			$prefix = '/images/' . $size;
		} else {
			$prefix = '';
		}
		return $prefix . '/media/' . strtolower($this->type) . '/' . $this->filename;
	}

	public function getFilepath($type, $size)
	{
		return strtolower(sprintf('/images/%s/media/%s', $size, $type));
	}
}
