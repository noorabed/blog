<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->truncate();

             //post
        $createpost = new permission();
        $createpost ->name ="Post-Create";
        $createpost ->for ="post";
        $createpost ->save();

        $updatepost = new permission();
        $updatepost ->name ="Post-Update";
        $updatepost ->for ="post";
        $updatepost ->save();

        $deletepost = new permission();
        $deletepost ->name ="Post-Delete";
        $deletepost ->for ="post";
        $deletepost ->save();

        $viewpost = new permission();
        $viewpost ->name ="Post-View";
        $viewpost ->for ="post";
        $viewpost ->save();
       // category
        $createcategory = new permission();
        $createcategory ->name ="Category-Create";
        $createcategory ->for ="category";
        $createcategory ->save();

        $updatecategory = new permission();
        $updatecategory ->name ="category-Update";
        $updatecategory ->for ="category";
        $updatecategory ->save();

        $deletecategory = new permission();
        $deletecategory ->name ="Category-Delete";
        $deletecategory ->for ="category";
        $deletecategory ->save();

        $viewcategory = new permission();
        $viewcategory ->name ="Category-View";
        $viewcategory ->for ="category";
        $viewcategory ->save();
        //tag
        $createtag = new permission();
        $createtag ->name ="Tag-Create";
        $createtag ->for ="tag";
        $createtag ->save();

        $updatetag = new permission();
        $updatetag ->name ="Tag-Update";
        $updatetag ->for ="tag";
        $updatetag ->save();

        $deletetag = new permission();
        $deletetag ->name ="Tag-Delete";
        $deletetag ->for ="tag";
        $deletetag ->save();

        $viewtag= new permission();
        $viewtag ->name ="Tag-View";
        $viewtag ->for ="tag";
        $viewtag ->save();

        //user
        $createuser = new permission();
        $createuser ->name ="User-Create";
        $createuser ->for ="user";
        $createuser ->save();

        $updateuser = new permission();
        $updateuser ->name ="User-Update";
        $updateuser ->for ="user";
        $updateuser ->save();

        $deleteuser = new permission();
        $deleteuser->name ="User-Delete";
        $deleteuser ->for ="user";
        $deleteuser->save();

        $viewuser= new permission();
        $viewuser ->name ="user-View";
        $viewuser->for ="user";
        $viewuser ->save();
        //setting


        //attach role permissions
        $admin=Role::whereName('admin')->first();
        $author=Role::whereName('author')->first();
        $editor=Role::whereName('editor')->first();
        $writer=Role::whereName('writer')->first();

        $admin->permissions()->attach([$createpost->id,$updatepost->id,$deletepost->id,$viewpost->id,$createcategory->id,$updatecategory->id,$deletecategory->id,$viewcategory->id]);
      // $admin->detachPermissions([$createpost,$updatepost,$deletepost,$viewpost]);

        $author->permissions()->attach([$createpost->id,$updatepost->id,$deletepost->id,$viewpost->id]);
   //     $author->detachPermissions([$createpost,$updatepost,$deletepost,$viewpost]);

        $editor->permissions()->attach([$updatepost->id,$deletepost->id]);
     //   $editor->detachPermissions([$updatepost,$deletepost]);

        $writer->permissions()->attach([$createpost->id,$updatepost->id]);
     //   $writer->detachPermissions([$createpost,$updatepost]);

    }
}
