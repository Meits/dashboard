<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissions')->insert(
	      [
	        [
	            'name' => 'VIEW_ADMIN'//1
	        ],
	        [
	            'name' => 'ADD_USER'//2
	        ],
	        [
	            'name' => 'EDIT_USER'//3
	        ],
	        [
	            'name' => 'DELETE_USER'//4
	        ],
	        [
	            'name' => 'ADD_ROLEUSER'//5
	        ],
	        [
	            'name' => 'EDIT_MESS'//6
	        ],
	        [
	            'name' => 'DELETE_MESS'//7
	        ],
	        [
	            'name' => 'EDIT_COMMENTS'//8
	        ],
	        [
	            'name' => 'DELETE_COMMENTS'//9
	        ],
	        [
	            'name' => 'ADD_MESS'//10
	        ],
	        [
	            'name' => 'ADD_COMMENTS'//11
	        ]
	      ]  
        
        );
    }
}
