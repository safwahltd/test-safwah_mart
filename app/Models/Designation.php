<?php

namespace App\Models;

use Module\HRM\Models\Leave\ApprovalAuthor\ApplicantDesignation;
use Module\HRM\Models\Leave\ApprovalAuthor\RecommenderDesignation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class Designation extends Model
{
    protected $fillable = ['created_by', 'company_id', 'updated_by', 'group_id', 'name', 'code', 'slug'];


    public static function boot()
    {
        parent::boot();
        if (!App::runningInConsole()) {
            static::creating(function ($model) {
                $model->fill([
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                    'group_id' => auth()->user()->company->group->id,
                    'company_id' => auth()->user()->company_id,
                ]);
            });
            static::updating(function ($model) {
                $model->fill([
                    'updated_by' => auth()->id(),
                ]);
            });
        }
    }

    public function applicant_designation()
    {
        return $this->hasMany(ApplicantDesignation::class, 'applicant_designation_id', 'id');
    }

    public function recommender_designation()
    {
        return $this->hasMany(RecommenderDesignation::class, 'recommender_designation_id', 'id');
    }

    public static function userDesignations()
    {
        return auth()->id() == 1 ? Designation::pluck('name', 'id') : (optional(optional(Auth::user())->designations)->pluck('name', 'id') ?? []);
    }
    
    public static function userDesignationId()
    {
        return auth()->id() == 1 ? Designation::pluck('id') : (optional(optional(Auth::user())->designations)->pluck('id') ?? []);
    }
}
