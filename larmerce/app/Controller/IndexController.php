<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Service\QueueService;
use Hyperf\Crontab\Crontab;
use Hyperf\Di\Annotation\Inject;

class IndexController extends AbstractController
{    
    /**
     * @Inject
     * @var QueueService
     */
    protected $service;

    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();        
                
        $this->service->push([
            'group@hyperf.io',
            'https://doc.hyperf.io',
            'https://www.hyperf.io',
        ]);    
        
        // (new Crontab())->setName('Foo')->setRule('* * * * *')->setCallback([\App\Crontab\FooTask::class, 'execute'])->setMemo('这是一个示例的定时任务');

        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];        
    }
}
