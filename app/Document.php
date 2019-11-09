<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Document
 *
 * @property int $id
 * @property int $user_id
 * @property int $document_model_id
 * @property string $title
 * @property string $content
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Collaborator[] $collaborators
 * @property-read int|null $collaborators_count
 * @property-read \App\DocumentModel $document_model
 * @property-read mixed $author
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereDocumentModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Document whereUserId($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    public function getAuthorAttribute()
    {
        return $this->user;
    }

    public function collaborators()
    {
        return $this->hasMany('App\Collaborator');
    }

    public function document_model()
    {
        return $this->belongsTo('App\DocumentModel');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
