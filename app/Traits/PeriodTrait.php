<?php

namespace App\Traits;
use Carbon\CarbonPeriod;

trait PeriodTrait {

    public function _parse_months_period($dates) {
        $months = [];
        if(!empty($dates)) {
            if(!is_array($dates)) $dates = $dates->toArray();
            foreach($dates as $date) {
                if(!empty($date)) {
                    foreach (CarbonPeriod::create($date['start_production_date'], '1 month', $date['end_production_date']) as $month) {
                        $months[$month->format('Ym')] = $month->format('F Y');
                    }
                }
            }
        }
        ksort($months);
        return $months;
    }
}
