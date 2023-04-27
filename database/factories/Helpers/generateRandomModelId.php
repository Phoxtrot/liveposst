<?php
namespace Database\Factories\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class generateRandomModelId
{
    public static function generateRandomModelId(string $model)
    {
         // Get post Count
         $count = $model::query()->count();
         // Check if post count > 0
         if ($count<0) {
             // if not create a new instanceof Post and get the id
            return $model::factory()->create()->id;
         } else {
             return  rand(1,$count);
         }
    }
}

