<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:model {model} {--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("Model to be created Start...");
        $this->index();
        $this->line("Model to be created End!");

    }

    /**
     *
     */
    public function index()
    {

        $auther='???@jtrips.com';
        $modelName= $this->argument('model');
        $table = $this->option('table');
        $val = $table;
        $res = DB::select("SHOW FULL COLUMNS FROM ".$val);
        //写入文件
        $text = "<?php\r\n\r\n";
        $text.='namespace App\Models\Base;'."\r\n\r\n";
        $text.='use Illuminate\Database\Eloquent\Model;'."\r\n";
        $text.='use Sofa\Eloquence\Eloquence;'."\r\n";
        $text.='use Sofa\Eloquence\Mappable;'."\r\n\r\n";
        $text.='/**'."\r\n".' * @Class '.ucfirst(camel_case($val))."\r\n";
        $text.=' * @package App\Models\Base'."\r\n";
        $text.=' * @User: '.$auther."\r\n";
        foreach($res as $oneval){
            $key_table = '';
            switch ($oneval->Field){
                default:
                    $key_table = camel_case($oneval->Field);
                    break;
            }
            $text.=" * @property string $".$key_table." ". $oneval->Comment ."\r\n";
        }
        $text.=" *\r\n */\r\n\r\n"."class ".$modelName." extends Model"."\r\n{\r\n".'    use Eloquence, Mappable;'
            ."\r\n\r\n".'    protected $table = \''.$table.'\';'."\r\n\r\n".'    protected $maps = ['."\r\n";
        foreach($res as $oneval){
            $nbsp = '';
            for($i = 0;$i < (15 - strlen(camel_case($oneval->Field)));$i++ ){
                $nbsp .= ' ';
            }
            $rnbsp = '';
            for($i = 0;$i < (15 - strlen($oneval->Field));$i++ ){
                $rnbsp .= ' ';
            }
            switch ($oneval->Field){
                default:
                    $key_table = camel_case($oneval->Field);
                    break;
            }
            if(in_array($oneval->Field,['id','created_at','updated_at'])){
                continue;
            }
            if($key_table == $oneval->Field){
                continue;
            }
            $text .= "        '" . $key_table
                . "'$nbsp=> '" . $oneval->Field . "',$rnbsp//"
                . $oneval->Comment . "\r\n";

        }
        $text.="    ];\r\n\r\n}";
        $myfile = fopen(\Config::get('repository.directory_model_path').'Base'.DIRECTORY_SEPARATOR
            .$modelName.".php", "w") or die("Unable to open file!");
        fwrite($myfile, $text);
        fclose($myfile);
    }
}
