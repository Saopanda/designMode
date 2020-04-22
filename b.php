<?php
/**
 *  观察者模式 自己实现
 *  核心
 *  将非核心业务代码独立成类，按需引入
 *  业务执行后，可让多个模块跟随运行
 */


//  被观察者 接口
interface obsable
{
    //  绑定 限制为 obsserver观察者，保证在通知时可以执行观察者的 update方法
     function attach(obsserver $obs);
    //  解绑
     function detach(obsserver $obs);
    //  通知
     function notify();
}

//  观察者接口
interface obsserver
{
    //  update 限制为 obsable被观察者
    public function update(obsable $data);
}

//  观察者抽象
abstract class testobs implements obsserver
{
    //  实例化的时候，要把被观察者传进来，把自己绑定到被观察者身上
    //  限制为与自己对应的 test被观察者
    public function __construct(test $test)
    {
        //  得到被观察者，把自己向其绑定
        $test->attach($this);
    }

    public function update(obsable $data){
        $this->doupdate($data);
    }
    //  具体操作由其自己实现 限制为与自己对应的 test被观察者
    abstract public function doupdate(test $data);

}

//  被观察者实现
class test implements obsable
{
    protected $obsserver = [];

    public function __construct()
    {
    }

    public function attach(obsserver $obs){
        $this->obsserver[] = $obs;
    }

    public function detach(obsserver $testobs){
        $this->obsserver = array_filter($this->obsserver,function($a)use($testobs){
            return !($a == $testobs);
        });
    }
    public function notify()
    {
        foreach ($this->obsserver as $k =>$v){
            $v->update($this);
        }
    }

    //  业务逻辑
    public function test($data=null){
        echo '业务 SUCCESS'.PHP_EOL;
        $this->num = $data;
        $this->notify();
    }
}

//  具体观察者
class didiobs extends testobs
{
    function doupdate(test $data)
    {
        echo 'didi更新了'.PHP_EOL;
        echo '拿到值'.$data->num.PHP_EOL;
    }
}

class echoobs extends testobs
{
    function doupdate(test $data)
    {
        echo 'echo更新了'.PHP_EOL;
        echo '拿到值'.$data->num.PHP_EOL;

    }
}

class xiangobs  extends testobs
{
    function doupdate(test $data)
    {
        echo 'xiang更新了'.PHP_EOL;
        echo '拿到值'.$data->num.PHP_EOL;
    }
}

$test = new test;

new didiobs($test);
new echoobs($test);
new xiangobs($test);

$test->test('123');


