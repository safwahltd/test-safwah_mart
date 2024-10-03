<?php

namespace App\Models;

use App\Models\Department;
use App\Models\Designation;
use Laravel\Sanctum\HasApiTokens;
use Module\Account\Models\Customer;
use Module\Inventory\Models\DeliveryMan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Module\HRM\Models\Employee\Employee;
use Module\Permission\Models\Permission;
use Module\Permission\Models\PermissionUser;
use Module\Garments\Models\Inventory\ArpGoodReceive;
use Module\Garments\Models\Merchandising\Setup\Buyer;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Module\Garments\Models\Merchandising\Order\OrderType;
use Module\Garments\Models\Merchandising\SampleDispatch\SampleDispatch;
use Module\Inventory\Models\Order;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'name', 'image', 'username', 'email', 'password', 'employee_id', 'status', 'employee_full_id', 'device_token', 'phone', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->where('id', '>', 1);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // akash methods for companies permission
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }

    // akash methods for order type permission
    public function order_types()
    {
        return $this->belongsToMany(OrderType::class)->orderBy('name');
    }

    // akash methods for buyers permission
    public function buyers()
    {
        return $this->belongsToMany(Buyer::class);
    }

    // akash methods for departments permission
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    // akash methods for designations permission
    public function designations()
    {
        return $this->belongsToMany(Designation::class);
    }

    public function delivery_man()
    {
        return $this->hasOne(DeliveryMan::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'sold_by');
    }

    // akash methods for permission
    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->where('status', 1);
    }

    // end permission methods

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function sample_dispatches()
    {
        return $this->hasMany(SampleDispatch::class, 'created_by');
    }

    public function arp_good_receives()
    {
        return $this->hasMany(ArpGoodReceive::class, 'create_by');
    }

    public static function hasAccess($slug)
    {
        $user_id = auth()->id();
        if ($user_id != 1) {
            $permission = Permission::where('slug', $slug)->first();
            if ($permission) {
                $permission_user = PermissionUser::where('permission_id', $permission->id)->where('user_id', $user_id)->first();
                if (!$permission_user) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }
        return true;
    }


    public function isLoggedIn()
    {
        return Cache::has('logged-in-users-' . $this->id) ? '<span><i class="fa fa-circle green"></i></span>' : '';
    }

    public function customer(){
        return $this->hasOne(Customer::class);
    }

    public function deliveryMan()
    {
        return $this->hasOne(DeliveryMan::class);
    }


      // PRODUCT WISE USER ASSIGN RELATION
      public function products()
      {
          return $this->belongsToMany(Product::class)->where('status', 1);
      }
}
