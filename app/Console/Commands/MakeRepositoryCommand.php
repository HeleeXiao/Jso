<?php

namespace App\Console\Commands;

use Config;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
//use Illuminate\Support\Composer;

/**
 * Class MakeRepositoryCommand
 * @package App\Console\Commands
 * @auther <Helee>
 */
class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zmake:repository {repository} {--model=} {--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command such as [ php artisan zmake:repository your-repository-name --model=your-model-name --table=your-table-name ] 
                        - Make a repository and interface,DB,Cache . ::: If you want to continue generating models,In the next question, respond to "yes" ';

    /**
     * @var
     */
    protected $repository;

    /**
     * @var
     */
    protected $model;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();

        $this->files    = $filesystem;
    }

    /**
     * Execute the console command.
     * @return bool
     * @auther <Helee>
     */
    public function handle()
    {
        $argument       = $this->argument('repository');
        $this->repository    = $this->option('model') ? : "";
        $option         = $this->option('model');
        $this->model    = $this->option('model');
        $table    = $this->option('table');
        if(!$argument || !$table || !$option)
        {
            $this->info('arguments Defect.......php artisan make:repository XXX [--model=] [--table=] , Do it again !');
            return false;
        }

        //自动生成RepositoryInterface和Repository文件
        $this->writeRepositoryAndInterface($argument, $option);
        //重新生成autoload.php文件
        //$this->composer->dumpAutoloads();
    }

    /**
     * @param $repository
     * @param $model
     * @auther <Helee>
     */
    private function writeRepositoryAndInterface($repository, $model)
    {
        if($this->createRepository($repository, $model)){

            /**
             * 创建模型Command
             */
            $confirm = $this->confirm('Repository has been generated. Do you want to continue generating its Model?');
            if($confirm){
                $this->call('create:model',[
                    'model' => $this->getModelName() ,
                    '--table' => $this->option('table')
                ]);
                //若生成成功,则输出信息
                $this->info('Success to make a '.$this->getModelName().' Repository and a '
                    .$this->getModelName().'DBRepository and '.$this->getModelName()
                    .'CacheInterface and '.$this->getModelName().'Model');
            }else{
                //若生成成功,则输出信息
                $this->info('Success to make a '.$this->getModelName().' Repository and a '
                    .$this->getModelName().'DBRepository and '.$this->getModelName()
                    .'CacheInterface, BUT not make a'.$this->getModelName().'Model');
            }

        }else{
            $this->info('fail to make a '.$this->getModelName());
        }
    }

    /**
     * @param $repository
     * @param $model
     * @return int|null
     * @auther <Helee>
     */
    private function createRepository($repository, $model)
    {
        // getter/setter 赋予成员变量值
        $this->setRepository($repository);
        $this->setModel($model);
        // 创建文件存放路径, RepositoryInterface放在app/Repositories,Repository个人一般放在app/Repositories/Eloquent里
        $this->createDirectory();
        // 生成两个文件
        return $this->createClass();
    }

    /**
     * @return bool
     */
    private function createDirectory()
    {
        //检查DB,Model,Cache,Interface路径是否存在,不存在创建一个,并赋予775权限
        try {
//            $directory = $this->getModelDirectory();
//            if (!$this->files->isDirectory($directory)) {
//                $this->files->makeDirectory($directory, 0755, true);
//            }
            $directory = $this->getDBDirectory();
            if (!$this->files->isDirectory($directory)) {
                $this->files->makeDirectory($directory, 0755, true);
            }
            $directory = $this->getCacheDirectory();
            if (!$this->files->isDirectory($directory)) {
                $this->files->makeDirectory($directory, 0755, true);
            }
            $directory = $this->getInterfaceDirectory();
            if (!$this->files->isDirectory($directory)) {
                $this->files->makeDirectory($directory, 0755, true);
            }
        }catch (\Exception $e)
        {
            $this->info("Error to info : ".$e->getMessage());
        }
    }

    /**
     * @return mixed
     */
    private function getModelDirectory()
    {
        return Config::get('repository.directory_model_path').ucfirst(camel_case($this->model));
    }

    /**
     * @return int|null
     */
    private function createClass()
    {
        //渲染模板文件,替换模板文件中变量值
        $templates = $this->templateStub();
        $class     = null;
        foreach ($templates as $key => $template) {
            //根据不同路径,渲染对应的模板文件
            $class = $this->files->put($this->getPath($key), $template);
        }
        return $class;
    }

    /**
     * 模板文件对应的路径
     * @param $class
     * @return null|string
     */
    private function getPath($class)
    {
        $path = null;
        switch($class){
            case 'Model':
                $path = $this->getModelDirectory().DIRECTORY_SEPARATOR.$this->getModelName().'.php';
                break;
            case 'DB':
                $path = $this->getDBDirectory().DIRECTORY_SEPARATOR.$this->getDBName().'.php';
                break;
            case 'Cache':
                $path = $this->getCacheDirectory().DIRECTORY_SEPARATOR.$this->getCacheName().'.php';
                break;
            case 'Interface':
                $path = $this->getInterfaceDirectory().DIRECTORY_SEPARATOR.$this->getInterfaceName().'.php';
                break;
        }
        return $path;
    }

    /**
     * @return mixed
     */
    private function getDBDirectory()
    {
        return Config::get('repository.directory_db_path').$this->getModelName();
    }

    /**
     * @return mixed
     */
    private function getCacheDirectory()
    {
        return Config::get('repository.directory_cache_path').$this->getModelName();
    }

    /**
     * @return mixed
     */
    private function getInterfaceDirectory()
    {
        return Config::get('repository.directory_interface_path').$this->getModelName();
    }

    /**
     * 根据输入的repository变量参数,是否需要加上'Repository'
     * @return mixed|string
     */
    private function getRepositoryName()
    {
        $repositoryName = $this->getRepository();
        if( strrpos($repositoryName, 'Repository') === false ){
            $repositoryName .= 'Repository';
        }
        return $repositoryName;
    }

    /**
     * @return string
     */
    private function getInterfaceName()
    {
        return $this->getRepositoryName();
    }
    /**
     * @return string
     */
    private function getDBName()
    {
        return $this->getModelName().'DBRepository';
    }
    /**
     * @return string
     */
    private function getCacheName()
    {
        return $this->getModelName().'CacheRepository';
    }

    /**
     * @return mixed
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param mixed $repository
     */
    public function setRepository($repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return array
     */
    private function templateStub()
    {
        // 获取模板文件
        $stubs        = $this->getStub();
        $renderStubs  = [];
        $propertyString = $this->getProperty();
        foreach ($stubs as $key => $stub) {
            // 获取需要替换的模板文件中变量
            $templateData = $this->getTemplateData($key);
            // 进行模板渲染
            $renderStubs[$key] = $this->getRenderStub( $templateData, $stub ,$propertyString );
        }

        return $renderStubs;
    }

    /**
     * @return array
     */
    private function getStub()
    {
        $stubs = [
            'DB'  => $this->files->get(resource_path('stubs'.DIRECTORY_SEPARATOR.'Repository').DIRECTORY_SEPARATOR.'DB'.DIRECTORY_SEPARATOR.'repository.stub'),
            'Interface' => $this->files->get(resource_path('stubs'.DIRECTORY_SEPARATOR.'Repository').DIRECTORY_SEPARATOR.'Interface'.DIRECTORY_SEPARATOR.'repository.stub'),
            'Cache' => $this->files->get(resource_path('stubs'.DIRECTORY_SEPARATOR.'Repository').DIRECTORY_SEPARATOR.'Cache'.DIRECTORY_SEPARATOR.'repository.stub'),
        ];

        return $stubs;
    }

    /**
     * @return array
     */
    private function getTemplateData($action)
    {
        switch ($action){
            case "DB":
                return $this->getDBTemplateData();
            break;
            case "Cache":
                return $this->getCacheTemplateData();
            break;
            case "Interface":
                return $this->getInterfaceTemplateData();
            break;
        }
    }

    /**
     * @return array
     */
    private function getCacheTemplateData()
    {
        $repositoryNamespace      = Config::get('repository.repository_cache_namespace').$this->getModelName();
        $modelNamespace           = Config::get("repository.model_name_space").$this->getModelName();
        $className                = $this->getCacheName();
        $modelName                = $this->getModelName();

        $templateVar = [
            'className'           => $className,
            'modelNamespace'      => $modelNamespace,
            'repositoryNamespace' => $repositoryNamespace,
            'ModelName'           => $modelName,
            'ModelNames'          => $this->getModelName(),
            'LowerModelName'      => '$'.strtolower($this->getModelName()),
            'Prefix'              => $this->option('table'),
        ];

        return $templateVar;
    }
    /**
     * @return array
     */
    private function getDBTemplateData()
    {
        $repositoryNamespace      = Config::get('repository.repository_db_namespace').$this->getModelName();
        $modelNamespace           = Config::get("repository.model_name_space").$this->getModelName();
        $className                = $this->getDBName();
        $interfaceName            = $this->getInterfaceName();
        $modelName                = $this->getModelName();

        $templateVar = [
            'className'           => $className,
            'interfaceName'       => $interfaceName,
            'modelNamespace'      => $modelNamespace,
            'repositoryNamespace' => $repositoryNamespace,
            'ModelName'           => $modelName,
            'LowerModelName'      => '$'.strtolower($this->getModelName()),
        ];

        return $templateVar;
    }
    /**
     * @return array
     */
    private function getInterfaceTemplateData()
    {
        $repositoryNamespace      = Config::get('repository.repository_interface_namespace').$this->getModelName();
        $modelNamespace           = Config::get("repository.model_name_space").$this->getModelName();
        $className                = $this->getInterfaceName();
        $interfaceName            = $this->getInterfaceName();
        $modelName                = $this->getModelName();

        $templateVar = [
            'className'           => $className,
            'interfaceName'       => $interfaceName,
            'modelNamespace'      => $modelNamespace,
            'repositoryNamespace' => $repositoryNamespace,
            'ModelName'           => $modelName,
            'LowerModelName'      => '$'.strtolower($this->getModelName()),
        ];

        return $templateVar;
    }

    /**
     * @param $templateData
     * @param $stub
     * @return mixed
     */
    private function getRenderStub($templateData, $stub ,$propertyString)
    {
        foreach ($templateData as $search => $replace) {
            $stub = str_replace('$'.$search, $replace, $stub);
        }
        return str_replace('$propertyString', $propertyString, $stub);
    }

    /**
     * Model Name
     * @return mixed|string
     */
    private function getModelName()
    {
        $modelName = $this->getModel();
        if(isset($modelName) && !empty($modelName)){
            $modelName = ucfirst($modelName);
        }else{
            // 若option选项没写,则根据repository来生成Model Name
            $modelName = $this->getModelFromRepository();
        }

        return $modelName;
    }

    /**
     * Model Name
     * @return string
     */
    private function getModelFromRepository()
    {
        $repository = strtolower($this->getRepository());
        $repository = str_replace('repository', '', $repository);
        return ucfirst($repository);
    }

    /**
     * @return string
     * @auther <Helee>
     */
    private function getProperty()
    {
        $query = \DB::select("SHOW FULL COLUMNS FROM ". $this->option('table'));
        $propertyString = "";
        foreach($query as $filedArray){
            $propertyString .=" * @property string $". camel_case($filedArray->Field) ." ". $filedArray->Comment ."\r\n";
        }

        return $propertyString.' */';
    }

}
