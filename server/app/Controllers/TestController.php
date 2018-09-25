<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers;

use App\Models\Logic\IndexLogic;
use Swoft\App;
use Swoft\Core\Coroutine;
use Swoft\Bean\Annotation\Inject;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\View\Bean\Annotation\View;
use Swoft\Core\Application;
use Swoft\Http\Message\Server\Request;

/**
 * 控制器demo
 * @Controller(prefix="/test")
 */
class TestController
{

    /**
     * 别名注入
     *
     * @Inject("httpRouter")
     *
     * @var \Swoft\Http\Server\Router\HandlerMapping
     */
    private $router;

    /**
     * 别名注入
     *
     * @Inject("application")
     *
     * @var Application
     */
    private $application;


    /**
     * 注入逻辑层
     * @Inject()
     *
     * @var IndexLogic
     */
    private $logic;

    /**
     * 定义一个route,支持get和post方式，处理uri=/demo2/index
     *
     * @RequestMapping(route="index", method={RequestMethod::GET, RequestMethod::POST})
     *
     * @param Request $request
     *
     * @return array
     */
    public function index(Request $request)
    {
        // 获取所有GET参数
        $get = $request->query();
        // 获取name参数默认值defaultName
        $getName = $request->query('name', 'defaultName');
        // 获取所有POST参数
        $post = $request->post();
        // 获取name参数默认值defaultName
        $postName = $request->post('name', 'defaultName');
        // 获取所有参，包括GET或POST
        $inputs = $request->input();
        // 获取name参数默认值defaultName
        $inputName = $request->input('name', 'defaultName');

        return compact('get', 'getName', 'post', 'postName', 'inputs', 'inputName');
    }

    

    /**
     * 定义一个route,支持get,以"/"开头的定义，直接是根路径，处理uri=/index2
     * @RequestMapping(route="/index2", method=RequestMethod::GET)
     */
    public function index2()
    {
        Coroutine::create(function () {
            App::trace('this is child trace' . Coroutine::id());
            Coroutine::create(function () {
                App::trace('this is child child trace' . Coroutine::id());
            });
        });

        return 'success';
    }

    /**
     * @RequestMapping(route="test/index3", method=RequestMethod::GET)
     */
    public function index3()
    {
        Coroutine::create(function () {
            App::trace('this is child trace' . Coroutine::id());
            Coroutine::create(function () {
                App::trace('this is child child trace' . Coroutine::id());
            });
        });

        return 'test_index3';
    }
}