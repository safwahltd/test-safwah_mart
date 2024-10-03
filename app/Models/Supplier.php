<?php

namespace App\Models;

use Module\Garments\Models\Commercial\BBLC\BBLC;
use App\Models\Country;
use App\Models\Group;
use Module\Garments\Models\Inventory\ArpWorkOrder;
use Module\Garments\Models\Inventory\KnitYarnWorkOrder;
use Module\Garments\Models\Inventory\SubcontractWorkOrder;
use Module\Garments\Models\Inventory\SupplierPi;
use Module\Garments\Models\Inventory\SweaterYarnWorkOrder;
use Module\Garments\Models\Inventory\WovenFabricWorkOrder;
use App\Models\SupplierType;
use App\Traits\AutoCreatedUpdated;
use App\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Module\Garments\Models\KnittingDyeing\GFabricIssue;
use Module\Garments\Models\KnittingDyeing\KnittingDyeingIssue;
use Module\Garments\Models\Payment\CashPayment;

class Supplier extends Model
{
    use AutoCreatedUpdated;

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function supplier_type(): BelongsTo
    {
        return $this->belongsTo(SupplierType::class);
    }

    public function supplier_pis(): HasMany
    {
        return $this->hasMany(SupplierPi::class);
    }

    public function bblcs(): HasMany
    {
        return $this->hasMany(BBLC::class);
    }

    public function regularBBLCs()
    {
        return $this->hasMany(BBLC::class, 'supplier_id')->where('is_regular', 1);
    }

    public function irregularBBLCs()
    {
        return $this->hasMany(BBLC::class, 'supplier_id')->where('is_regular', 0);
    }

    public function cashPayments(): HasMany
    {
        return $this->hasMany(CashPayment::class);
    }

    public function arpWorkOrders(): HasMany
    {
        return $this->hasMany(ArpWorkOrder::class);
    }

    public function sweaterYarnWorkOrders(): HasMany
    {
        return $this->hasMany(SweaterYarnWorkOrder::class);
    }

    public function knitYarnWorkOrders(): HasMany
    {
        return $this->hasMany(KnitYarnWorkOrder::class);
    }

    public function subcontractWorkOrders(): HasMany
    {
        return $this->hasMany(SubcontractWorkOrder::class);
    }

    public function wovenFabricWorkOrders(): HasMany
    {
        return $this->hasMany(WovenFabricWorkOrder::class);
    }

    public function knittingDyeingIssues(): HasMany
    {
        return $this->hasMany(KnittingDyeingIssue::class, 'supplier_id', 'id');
    }

    public function dyeingIssues(): HasMany
    {
        return $this->hasMany(GFabricIssue::class, 'supplier_id', 'id');
    }


    // supplier type scope


    public function scopeGeneral_store($query)
    {
        $query->where('supplier_type_id', 1);
    }

    public function scopeArp($query)
    {
        $query->where('supplier_type_id', 2);
    }

    public function scopeKnit_yarn($query)
    {
        $query->where('supplier_type_id', 3);
    }

    public function scopeKnitting_dyeing($query)
    {
        $query->where('supplier_type_id', 4);
    }

    public function scopeSubcontract($query)
    {
        $query->where('supplier_type_id', 6);
    }

    public function scopeSweater_yarn($query)
    {
        $query->where('supplier_type_id', 7);
    }

    public function scopeWoven_favbric($query)
    {
        $query->where('supplier_type_id', 8);
    }
}
