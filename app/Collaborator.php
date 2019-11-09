<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Collaborator
 *
 * @property int $id
 * @property int $user_id
 * @property int $document_model_id
 * @property int|null $document_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Document|null $document
 * @property-read \App\DocumentModel $documentModel
 * @property-read mixed $editor
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereDocumentModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Collaborator whereUserId($value)
 * @mixin \Eloquent
 */
class Collaborator extends Model
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

    public function getEditorAttribute()
    {
        return $this->user;
    }

    public function document()
    {
        return $this->belongsTo('App\Document');
    }

    public function documentModel()
    {
        return $this->belongsTo('App\DocumentModel');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
