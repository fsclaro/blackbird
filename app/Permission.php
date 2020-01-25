<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Role;

class Permission extends Model
{
    use SoftDeletes, HasSlug;

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function roles() {
        return $this->belongsToMany(Role::class, 'permission_role');
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->usingSeparator('_')
            ->doNotGenerateSlugsOnUpdate();
    }
}
