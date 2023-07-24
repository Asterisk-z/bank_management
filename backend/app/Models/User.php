<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        "two_factor_expires_at" => 'datetime',
        "otp_expires_at" => 'datetime',
    ];

    public function account_details()
    {
        return $this->hasOne(AccountInfomation::class);
    }

    public function deposit_requests()
    {
        return $this->hasMany(DepositRequest::class)->orderBy('id', 'desc');
    }

    public function payment_requests()
    {
        return $this->hasMany(PaymentRequest::class)->with('user')->orderBy('id', 'desc');
    }

    public function received_requests()
    {
        return $this->hasMany(PaymentRequest::class, 'benefactor')->with('user')->orderBy('id', 'desc');
    }

    public function support_tickets()
    {
        return $this->hasMany(SupportTicket::class, 'user_id')->orderBy('id', 'desc');
    }

    public function otps()
    {
        return $this->hasOne(OtpCode::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id')->orderBy('id', 'desc');
    }

    public function loans()
    {
        return $this->hasMany(Loan::class, 'borrower_id')->with('loan_product')->orderBy('id', 'desc');
    }

    public function fixed_deposits()
    {
        return $this->hasMany(FixedDeposit::class, 'user_id')->with('plan')->orderBy('id', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    public function generateTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(30);
        $this->save();
    }

    public function resetTwoFactorCode()
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function generateOTP()
    {
        $this->timestamps = false;
        $this->otp = rand(100000, 999999);
        $this->otp_expires_at = now()->addMinutes(5);
        $this->save();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
