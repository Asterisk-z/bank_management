<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountInfomation extends Model
{
    use HasFactory;

    public function add_balance($amount, $currency)
    {
        if ($currency == 'USD') {
            $this->usd_balance = intval($this->usd_balance) + intval($amount);
            $this->save();
        }

        if ($currency == 'AUD') {
            $this->aud_balance = intval($this->aud_balance) + intval($amount);
            $this->save();
        }
        if ($currency == 'EUR') {
            $this->eur_balance = intval($this->eur_balance) + intval($amount);
            $this->save();
        }

    }

    public function sub_balance($amount, $currency)
    {
        if ($currency == 'USD') {
            $this->usd_balance = intval($this->usd_balance) - intval($amount);
            $this->save();
        }

        if ($currency == 'AUD') {
            $this->aud_balance = intval($this->aud_balance) - intval($amount);
            $this->save();
        }
        if ($currency == 'EUR') {
            $this->eur_balance = intval($this->eur_balance) - intval($amount);
            $this->save();
        }
    }

    public function balance($currency)
    {

        if ($currency == 'USD') {
            return $this->usd_balance;
        }

        if ($currency == 'AUD') {
            return $this->usd_balance;
        }

        if ($currency == 'EUR') {
            return $this->usd_balance;
        }

    }
}
