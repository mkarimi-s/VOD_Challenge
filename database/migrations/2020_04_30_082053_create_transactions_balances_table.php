<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $query = <<<QUERY
CREATE OR REPLACE VIEW transactions_balances AS      
    SELECT user_id, (SUM(`amount`)) as balance
FROM transactions
    
    group by user_id
    
QUERY;
        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW transactions_balances');
    }
}
