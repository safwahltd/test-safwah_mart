<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Module\HRM\Models\Employee\Employee;

class Department extends Model
{
    protected $fillable = ['created_by', 'updated_by', 'company_id', 'group_id', 'name', 'code', 'slug'];

    public static function boot()
    {
        parent::boot();
        if (!App::runningInConsole()) {
            static::creating(function ($model) {
                $model->fill([
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                    'group_id' => auth()->user()->company->group_id,
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


    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'id');
    }

    public static function userDepartments()
    {
        return auth()->id() == 1 ? Department::pluck('name', 'id') : (optional(optional(Auth::user())->departments)->pluck('name', 'id') ?? []);
    }
    
    public static function userDepartmentId()
    {
        return auth()->id() == 1 ? Department::pluck('id') : (optional(optional(Auth::user())->departments)->pluck('id') ?? []);
    }
}
