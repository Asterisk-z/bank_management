<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountInfomation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function add_balance($amount, $currency)
    {
        if ($currency == 'USD') {
            $this->usd_balance = floatval($this->usd_balance) + floatval($amount);
            $this->save();
        }

        if ($currency == 'AUD') {
            $this->aud_balance = floatval($this->aud_balance) + floatval($amount);
            $this->save();
        }
        if ($currency == 'EUR') {
            $this->eur_balance = floatval($this->eur_balance) + floatval($amount);
            $this->save();
        }

    }

    public function sub_balance($amount, $currency)
    {
        if ($currency == 'USD') {
            $this->usd_balance = floatval($this->usd_balance) - floatval($amount);
            $this->save();
        }

        if ($currency == 'AUD') {
            $this->aud_balance = floatval($this->aud_balance) - floatval($amount);
            $this->save();
        }
        if ($currency == 'EUR') {
            $this->eur_balance = floatval($this->eur_balance) - floatval($amount);
            $this->save();
        }
    }

    public function balance($currency)
    {

        if ($currency == 'USD') {
            return $this->usd_balance;
        }

        if ($currency == 'AUD') {
            return $this->aud_balance;
        }

        if ($currency == 'EUR') {
            return $this->eur_balance;
        }

    }

    public function overall_balance()
    {
        $usd_balance = $this->balance('USD');
        $aud_balance = $this->balance('AUD');
        $eur_balance = $this->balance('EUR');

        $usd_rate = Currency::where('name', 'USD')->first()->rate;
        $aud_rate = Currency::where('name', 'AUD')->first()->rate;
        $eur_rate = Currency::where('name', 'EUR')->first()->rate;

        $total = (($aud_balance / $aud_rate) * $usd_rate) + (($eur_balance / $eur_rate) * $usd_rate) + $usd_balance;

        return $total;

    }
}
