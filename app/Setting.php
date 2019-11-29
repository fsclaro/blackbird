<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes, HasSlug;

    protected $table = 'settings';

    protected $fillable = [
        'description',
        'name',
        'content',
        'type',
        'dataenum',
        'helper',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('description')
            ->saveSlugsTo('name')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('_')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getSetting($setting)
    {
        $param = $this->where('name', $setting);

        dd($param);
    }
}
