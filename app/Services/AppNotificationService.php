<?php 

namespace App\Services;

use App\Models\Company;
use Module\Garments\Models\Inventory\ArpGoodIssue;
use Module\Garments\Models\Merchandising\Order\Order;
use Module\Garments\Models\Merchandising\Order\OrderType;
use Module\Garments\Models\Merchandising\PI\Pi;
use Module\Garments\Models\Merchandising\Setup\Buyer;
use Module\Garments\Models\Merchandising\SID\Sid;
use Module\GeneralStore\Models\GoodsRequisition;
use Module\GeneralStore\Models\Purchase;
use App\Models\Department;
use App\Models\Designation;
use Module\HRM\Models\Leave\ApprovalAuthor\ApplicantDesignation;
use Module\HRM\Models\Leave\LeaveApplication;
use Module\HRM\Models\Leave\ShortLeaveApplication;
use Module\HRM\Models\Leave\ShortLeaveAuthor\SLeaveAppDesig;

class AppNotificationService 
{
    public $totalNotificationCount = 0;

    private $userDepartmentIds = [];
    private $userCompanyIds = [];
    private $userOrderTyeIds = [];
    private $userBuyerIds = [];
    private $slugs = [];

    // global
    public $news_notification_count = 0;

    // hrm
    public $leave_recommend_count = 0;
    public $leave_approve_count = 0;
    public $leave_application_count = 0;
    public $short_leave_application_count = 0;

    // general store
    public $gs_purchase_approve_count = 0;
    public $gs_requisition_approve_count = 0;


    // garmetns 
    public $order_costing_approve_count = 0;
    public $pending_adjustment_sids_count = 0;
    public $pending_arp_requisition_count = 0;
    public $sweater_yarn_approve_pending = 0;
    public $sweater_yarn_approve_pending_count = 0;


    public $mid_upgrade_count = 0;


    public function __construct()
    {
        $active_modules = session()->get('active_modules') ?? [];
        
        if (auth()->user()) {
            $this->slugs = auth()->user()->permissions()->pluck('slug')->toArray();
        }
        
        $this->userDesignationIds   = Designation::userDesignationId();
        $this->userDepartmentIds    = Department::userDepartmentId();
        $this->userCompanyIds       = Company::userCompanyId();

        if(count(array_intersect($active_modules, ["Merchandising", "Inventory", "Commercial", "Payment"]))) {
            // $this->userOrderTyeIds      = OrderType::userOrderTypesId();
            // $this->userBuyerIds         = Buyer::userBuyers()->keys();
        }

        // global
        // $this->news_notification_count = news_notifications();

        // hrm
        // if(in_array('HRM', $active_modules)) {


        //     $this->getLeaveRecommendations();

        //     $this->getShortLeaveApplications();

        //     $this->getLeaveApplications();
        // }
        


        // general store
        // if(in_array('General Store', $active_modules)) {
        //     $this->getGeneralStoreNotifications();
        // }


        // garments
        // if(count(array_intersect($active_modules, ["Merchandising", "Inventory", "Commercial", "Payment"]))) {
        //     $this->getGarmetnsNotifications();
        // }

        $this->totalNotificationCount = $this->news_notification_count

                                        + $this->leave_recommend_count
                                        + $this->leave_approve_count
                                        + $this->leave_application_count
                                        + $this->short_leave_application_count

                                        + $this->gs_purchase_approve_count
                                        + $this->gs_requisition_approve_count

                                        + $this->order_costing_approve_count
                                        + $this->pending_adjustment_sids_count
                                        + $this->pending_arp_requisition_count
                                        + $this->sweater_yarn_approve_pending_count

                                        + $this->mid_upgrade_count;
    }


    private function getGarmetnsNotifications()
    {
        // $this->order_costing_approve_count = Order::whereIn('order_type_id', $this->userOrderTyeIds)
        //                                                 ->whereIn('buyer_id', $this->userBuyerIds)
        //                                                 ->where('delete', false)
        //                                                 ->where('cancel', null)
        //                                                 ->where('ship', null)
        //                                                 ->whereHas('order_costing', function ($q) {  // un aproved
        //                                                     $q->where(function($qr) {
        //                                                         $qr->where('approved_status', 0)
        //                                                         ->orWhereNull('approved_status');
        //                                                     });
        //                                                 })->count();

        // $this->pending_adjustment_sids_count = Sid::where('mid_adjust', 0)
        //                     ->whereIn('order_type_id', $this->userOrderTyeIds)
        //                     ->whereIn('buyer_id', $this->userBuyerIds)
        //                     ->count();

        // $this->pending_arp_requisition_count = ArpGoodIssue::where('approve_status', null)
        //                                         ->orWhere('approve_status', 0)
        //                                         ->count();

        // $notifications = Notification::when(auth()->id() != 1, function ($q) {
        //                                     $q->whereIn('slug', $this->slugs)
        //                                     ->whereIn('company_id', $this->userCompanyIds)
        //                                     ->whereIn('order_type_id', $this->userOrderTyeIds)
        //                                     ->whereIn('buyer_id', $this->userBuyerIds);
        //                                 })
        //                                 ->whereNull('employee_id')
        //                                 ->get();

        // $this->sweater_yarn_approve_pending = collect($notifications->where('slug', 'yarn.good.issues.approve'));
        // $this->sweater_yarn_approve_pending_count = $this->sweater_yarn_approve_pending->count();

        // $this->mid_upgrade_count = Notification::where('type', 'Mid Upgrade')->whereIn('buyer_id', $this->userBuyerIds)->count();
    }


    private function getGeneralStoreNotifications()
    {
        $this->gs_purchase_approve_count = Purchase::whereIn('company_id', $this->userCompanyIds)
                                                    ->where('is_approved', 0)
                                                    ->count();


        $this->gs_requisition_approve_count = GoodsRequisition::whereIn('company_id', $this->userCompanyIds)
                                                                ->whereIn('department_id', $this->userDepartmentIds)
                                                                ->where('is_approved', 0)
                                                                ->count();

    }
    
    
    private function getLeaveRecommendations()
    {

        $userDesignationId = optional(optional(auth()->user()->employee)->active_employment)->designation_id;
        $userDepartmentId = optional(optional(auth()->user()->employee)->active_employment)->department_id;
        $userCompanyId = optional(optional(auth()->user()->employee)->active_employment)->company_id;

        $applicantDesig = ApplicantDesignation::with(['recommender_infos' => function($q) use($userCompanyId, $userDepartmentId, $userDesignationId) {
                                                    $q->where('recommender_company_id', $userCompanyId)
                                                    ->where('recommender_department_id', $userDepartmentId)
                                                    ->where('recomNoticeender_designation_id', $userDesignationId); 
                                                }])->whereHas('recommender_infos', function($q) use($userCompanyId, $userDepartmentId, $userDesignationId) {
                                                   $q->where('recommender_company_id', $userCompanyId)
                                                   ->where('recommender_department_id', $userDepartmentId)
                                                   ->where('recommender_designation_id', $userDesignationId); 
                                                })
                                                ->get();



        $company_ids = $applicantDesig->map(function($item) {
            return $item->company_id;
        });

        $department_ids = $applicantDesig->map(function($item) {
            return optional($item->applicant_department)->department_id;
        });
        
        $designation_ids = $applicantDesig->map(function($item) {
            return $item->designation_id;
        });

        $new_department_ids = [];
        
        foreach($department_ids as $department_id) {
            if($department_id != null) {
                $new_deparment_ids[] = $department_id;
            }
        }


        $this->leave_recommend_count = LeaveApplication::
        
            when(auth()->id() != 1, function($qr) use($company_ids, $new_department_ids, $designation_ids) {
                $qr->whereHas('employee', function ($q) use($company_ids, $new_department_ids, $designation_ids) {
                    $q->whereIn('company_id', $company_ids)
                    ->when(count($new_department_ids) > 0, function($q) use($new_department_ids) {
                        $q->whereIn('department_id', $new_department_ids)
                        ->orWhere('department_id', null);
                    })
                    ->whereIn('designation_id', $designation_ids);
                });
            })
            ->where('recommended_by', '=', null)
            ->where('cancel', 0)
            
            ->count();

            
    }

    private function getLeaveApplications()
    {

        $userDesignationId = optional(optional(auth()->user()->employee)->active_employment)->designation_id;
        $userDepartmentId = optional(optional(auth()->user()->employee)->active_employment)->department_id;
        $userCompanyId = optional(optional(auth()->user()->employee)->active_employment)->company_id;

        $applicantDesig = ApplicantDesignation::with(['recommender_infos' => function($q) use($userCompanyId, $userDepartmentId, $userDesignationId) {
                                                    $q->where('approval_company_id', $userCompanyId)
                                                    ->where('approval_department_id', $userDepartmentId)
                                                    ->where('approval_designation_id', $userDesignationId); 
                                                }])->whereHas('recommender_infos', function($q) use($userCompanyId, $userDepartmentId, $userDesignationId) {
                                                    $q->where('approval_company_id', $userCompanyId)
                                                    ->where('approval_department_id', $userDepartmentId)
                                                    ->where('approval_designation_id', $userDesignationId); 
                                                })
                                                ->get();


        $company_ids = $applicantDesig->map(function($item) {
            return $item->company_id;
        });


        $department_ids = $applicantDesig->map(function($item) {
            return optional($item->applicant_department)->department_id;
        });
        
        $designation_ids = $applicantDesig->map(function($item) {
            return $item->designation_id;
        });

        $new_department_ids = [];
        
        foreach($department_ids as $department_id) {
            if($department_id != null) {
                $new_deparment_ids[] = $department_id;
            }
        }


        $this->leave_approve_count = LeaveApplication::where('recommended_by', '!=', "")
                                       
                                        ->when(auth()->id() != 1, function($qr) use($company_ids, $new_department_ids, $designation_ids) {
                                            $qr->whereHas('employee', function ($q) use($company_ids, $new_department_ids, $designation_ids) {
                                                $q->whereIn('company_id', $company_ids)
                                                ->when(count($new_department_ids) > 0, function($q) use($new_department_ids) {
                                                    $q->whereIn('department_id', $new_department_ids)
                                                    ->orWhere('department_id', null);
                                                })
                                                ->whereIn('designation_id', $designation_ids);
                                            });
                                        })
                                        
                                        ->where('approved_by', null)
                                        ->where('cancel', 0)
                                        ->count();

        // $this->leave_application_count = Notification::whereNotNull('employee_id')->where('employee_id', auth()->user()->employee_id)->count();
    }

    private function getShortLeaveApplications()
    {

        $userDesignationId = optional(optional(auth()->user()->employee)->active_employment)->designation_id;
        $userCompanyId = optional(optional(auth()->user()->employee)->active_employment)->company_id;

        $applicantDesig = SLeaveAppDesig::whereHas('s_leave_companies',function ($q) use($userCompanyId, $userDesignationId){
                                $q->whereHas('s_leave_recom_desigs',function ($sQ) use($userDesignationId){
                                    $sQ->where('recommender_designation_id', $userDesignationId);
                                })->where('company_id',$userCompanyId);
                            })->pluck('applicant_designation_id');

                        $applicantCompany = SLeaveAppDesig::whereHas('s_leave_companies',function ($q) use($userCompanyId,$userDesignationId){
                                $q->whereHas('s_leave_recom_desigs',function ($sQ) use($userDesignationId){
                                    $sQ->where('recommender_designation_id', $userDesignationId);
                                })->where('company_id', $userCompanyId);
                            })->pluck('company_id');


        $this->short_leave_application_count = ShortLeaveApplication::whereHas('employee',function ($q) use ($applicantCompany, $applicantDesig){
                                $q->whereIn('company_id', $applicantCompany)->whereIn('designation_id',$applicantDesig);
                            })
                            ->distinct()
                            ->where('seen_by', '=', null)
                            ->count();
    }
    



    // pi revice and mid upgrade
    public function makeMidUpgradeNotification($export_pi_id)
    {
        $pi = Pi::where('id', $export_pi_id)->first();

        $mid = optional(optional(optional(optional($pi->activePiNumber)->pi)->sid)->midSid)->mid;

        // if ($mid) {
        //     $Notification = Notification::firstOrCreate([
        //         'source_id' => $mid->id,
        //         'type'      => 'Mid Upgrade',
        //     ],[
        //         'buyer_id'  => $mid->buyer_id,
        //         'slug'      => 'route.will.be-define',
        //     ]);
        // }
    }
}