<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Session;
use App\Models\Site;
use App\Models\Service;
use App\Models\ServiceGroup;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'root',
        'admin',
        'enabled'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function showFormNotice($errors)
    {
        if (Session::get('Msg')) {
            print('<div class="alert alert-success">' . Session::get('Msg') . '</div>');
        }
        if (Session::get('Err')) {
            print('<div class="alert alert-danger">' . Session::get('Err') . '</div>');
        }

        if ($errors->any()) {
            print '<div class="alert alert-danger"><ul>';
            foreach ($errors->all() as $error) {
                print '<li>' . $error . '</li>';
            }
            print '</ul></div>';
        }
    }
    public static function getSettings()
    {
        $site = Site::find(1);
        if (is_object($site)) {
            return $site;
        }
        return json_decode(json_encode([
            'email' => null, 'support_email' => null, 'phone' => null, 'address' => null,
            'working_hours' => null, 'facebook' => null, 'twitter' => null, 'linkedin' => null,
        ]));
    }
    public static function getOrderBillTotals($order)
    {
        $totalBills = Bill::where('order', $order)->sum('amount');
        $totalBillsPaid = Bill::where('order', $order)->where('payment_status', true)->sum('amount');
        return [$totalBills, $totalBillsPaid];
    }
    public static function getOrderPipeline($progress)
    {
        switch ($progress) {
            case 'not_assigned':
                return '<span class="badge bg-danger">Not assigned</span>';
                break;
            case 'in_progress':
                return '<span class="badge bg-warning">in progress</span>';
                break;
            case 'in_review':
                return '<span class="badge bg-info">in review</span>';
                break;
            case 'complete':
                return '<span class="badge bg-success">complete</span>';
                break;
            default:
                return '<span class="badge bg-secondary">unknown</span>';
                break;
        }
    }
    public static function getOrderBillPaid($order)
    {
        $totalBills = Bill::where('order', $order)->sum('amount');
        $totalBillsPaid = Bill::where('order', $order)->where('payment_status', true)->sum('amount');
        return intval($totalBills) == intval($totalBillsPaid);
    }
    public static function getOrderBillTotal($order)
    {
        return Bill::where('order', $order)->sum('amount');
    }
    public static function getYears()
    {
        $currentYear = intval(date('Y'));
        $needed = 5;
        $iter = 0;
        $rtn = [];
        while ($iter < $needed) {
            array_push($rtn, $currentYear - $iter);
            $iter++;
        }
        return $rtn;
    }
    public static function getServiceGroups()
    {
        $data = ServiceGroup::where('enabled', true)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
    public static function getServicesByGroup($group)
    {
        $data = Service::where('enabled', true)->where('type', $group)->get();
        if (is_object($data)) {
            return $data->toArray();
        }
        return [];
    }
    public static function getServices($case = 2)
    {
        switch ($case) {
            case 1:
                $data = Service::all();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 2:
                $data = Service::where('enabled', true)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
            case 3:
                $data = Service::where('enabled', false)->get();
                if (is_object($data)) {
                    return $data->toArray();
                }
                break;
        }
        return [];
    }
    public static function lastSixMonths()
    {
        return [
            date('Y-m') =>  date('M'),
            date('Y-m', strtotime('-1 months')) => date('M', strtotime('-1 months')),
            date('Y-m', strtotime('-2 months')) =>  date('M', strtotime('-2 months')),
            date('Y-m', strtotime('-3 months')) => date('M', strtotime('-3 months')),
            date('Y-m', strtotime('-4 months')) => date('M', strtotime('-4 months')),
            date('Y-m', strtotime('-5 months')) =>  date('M', strtotime('-5 months')),
        ];
    }
}
