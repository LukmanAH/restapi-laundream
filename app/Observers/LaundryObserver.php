<?php

namespace App\Observers;

use App\Models\Laundry;
use App\Models\OperationalHour;

class LaundryObserver
{
    public function created(Laundry $laundry)
    {
        $days = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu'
        ];

        foreach ($days as $day) {
            OperationalHour::create([
                'laundry_id' => $laundry->id,
                'day' => $day,
                'open' => '08:00',
                'close' => '17:00'
            ]);
        }
    }

    public function updated(Laundry $laundry)
    {
        //
    }

    public function deleted(Laundry $laundry)
    {
        //
    }

    public function restored(Laundry $laundry)
    {
        //
    }

    public function forceDeleted(Laundry $laundry)
    {
        //
    }
}
