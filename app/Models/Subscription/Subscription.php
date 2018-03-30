<?php
namespace App\Models\Subscription;

use Illuminate\Database\Eloquent\Model;
use App\Models\Notififications\Notification;

class Subscription extends Model
{
    protected $table = 'event.subscription';
    protected $fillable = ['subscriber_id', 'event_type_id'];

    public function notificationPreference()
    {
        return $this->belongsTo(Notification::class, 'subscriber_id');
    }

    /**
     * Mass (bulk) insert or ignore on duplicate
     *
     * - https://gist.github.com/RuGa/5354e44883c7651fd15c#file-massinsertorupdate-php
     *
     * @param  array  $rows [
     *                          ['id'=>1,'value'=>10],
     *                          ['id'=>2,'value'=>60]
     *                      ];
     *
     * @return boolean
     */
    public static function createManyOrIgnore(array $rows)
    {
        $table = with(new self)->getTable();

        $first = reset($rows);

        $columns = implode(
            ',',
            array_map(function ($value) {
                return "$value";
            }, array_keys($first))
        );

        $values = implode(',', array_map(function ($row) {
                return '('.implode(
                    ',',
                    array_map(function ($value) {
                        return gettype($value) == 'string' ? '"' . str_replace('"', '""', $value) . '"' : $value;
                    }, $row)
                ).')';
        }, $rows));

        $sql = "INSERT INTO {$table}({$columns}) VALUES {$values} ON CONFLICT ({$columns}) DO NOTHING";

        return \DB::statement($sql);
    }
}
