<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSystemUsersToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $string = file_get_contents(base_path() . "/data/users.json");
        $items = json_decode($string, true);
        foreach ($items as $item) {
            $email = $item['email'];
            $user = User::findEmail($email)->first();
            if (is_null($user)) {
                $user = new User();
                $user->email = $email;
                $user->password = $item['password'];
                $user->name = $item['name'];
                $user->is_manager = $item['is_manager'];
                $user->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $string = file_get_contents(base_path() . "/data/users.json");
        $items = json_decode($string, true);
        foreach ($items as $item) {
            $email = $item['email'];
            $user = User::findEmail($email)->first();
            if ($user) {
                $user->delete();
            }
        }
    }
}
