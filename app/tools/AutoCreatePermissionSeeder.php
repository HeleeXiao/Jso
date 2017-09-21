<?php
namespace App\tools;
use Illuminate\Filesystem\Filesystem;

class AutoCreatePermissionSeeder
{

    public function init()
    {
        $this->putStringToSeeder(new Filesystem());
    }

    protected function putStringToSeeder(\Illuminate\Filesystem\Filesystem $filesystem)
    {
        $string = "";
        $string .= $this->getHeader();
        foreach ($this->getPermissions() as $permission) {
            $string .= "                [
                    'id'            =>$permission->id,
                    'pid'           =>$permission->pid,
                    'name'          =>'$permission->name',
                    'name_zh'       =>'$permission->name_zh',
                    'name_jp'       =>'$permission->name_jp',
                    'display_name'  =>'$permission->display_name',
                    'description'   =>'$permission->description',
                    'status'        =>$permission->status,
                    'type'          =>$permission->type,

                ],\r\n";
        }
        $string .= $this->getFooter();
        $filesystem->put($this->getSeederConfigPath(),$string);
    }

    protected function getPermissions()
    {
        return \App\Models\Base\Permission::all();
    }

    protected function getSeederConfigPath()
    {
        return base_path() . DIRECTORY_SEPARATOR . \Config::get("seeder.entrust_seeder_path");
    }

    protected function getHeader()
    {
        return "<?php \r\n\r\n
        return [\r\n\r\n           
        ";
    }

    protected function getFooter()
    {
        return "\r\n\r\n
        ];";
    }

}