<?php
use PHPUnit\TextUI\XmlConfiguration\Exception;
use App\Enums\StatusEnum;
function deleted_records_count($table)
{
    if(empty($table)) {
       abort('the table '.$table.' not found');
    }

    return DB::table($table)->whereNotNull('deleted_at')->count();

}

function getStatusColorClass(StatusEnum $status): string {
    return $class = match($status) {
        StatusEnum::Open => 'bg-info',
        StatusEnum::Completed => 'bg-success',
        StatusEnum::Cancelled => 'bg-danger',
        StatusEnum::Blocked => 'bg-black',
        StatusEnum::InProgress => 'bg-warning',
        default => 'bg-default'
    };
}

function isAdminUser() {
    return tap(auth()->user()->hasRole('admin'));
}
