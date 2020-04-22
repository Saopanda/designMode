<?php

/**
 *  策略模式
 *  将业务可选的多种方式，独立成类
 *  在业务执行的时候，加载不同类实现不同操作
 */


/**
 * Class test
 */
class test
{
    //  操作器
    private $maker;

    public function __construct(make $maker)
    {
        $this->maker = $maker;
    }

    //  导出功能
    public function export(){
        $data = [
            'abc'=>'666',
            'abb'=>'666',
            'abs'=>'666',
        ];
        //  将内容发送给操作器
        $this->maker->domake($data);
    }

}


abstract class make
{
    //  操作器需要的参数
    protected $file_name;
    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    abstract function domake($data);
}

class jpgmake extends make
{
    function domake($data)
    {
        // TODO: Implement domake() method.
        var_dump($data);
        echo "输出了 jpg\n";
        echo "文件名为".$this->file_name;
    }
}

class pngmake extends make
{
    function domake($data)
    {
        // TODO: Implement domake() method.
        var_dump($data);
        echo "输出了 png\n";
        echo "文件名为".$this->file_name;
    }
}

$test = new test(new pngmake('abc.jpg'));

$test->export('ab');


