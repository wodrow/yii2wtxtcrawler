<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:33
 */

namespace wodrow\yii2wtxtcrawler;


use QL\QueryList;
use QL\Ext\PhantomJs;
use yii\base\Component;
use yii\base\Exception;
use yii\helpers\FileHelper;

abstract class Tc extends Component implements Api
{
    public $url;
    public $title;
    public $content = "";
    public $phantomjs;

    public $t_dir;
    public $show_log;

    /**
     * @var QueryList $ql
     */
    public $ql;

    public function init()
    {
        parent::init();
        $this->ql = QueryList::getInstance();
    }

    public function initBrowser()
    {
//        $this->ql->use(PhantomJs::class, $this->>phantomjs, 'browser');
        $this->ql->use(PhantomJs::class, $this->phantomjs);
//        $html = $this->ql->browser('https://m.toutiao.com')->getHtml();
//        var_dump($html);
//        $data = $this->ql->browser('https://m.toutiao.com')->find('p')->texts();
//        print_r($data->all());
//        exit;
    }

    /**
     * 生成txt
     * @throws
     */
    public function generate()
    {
        $this->t_dir = \Yii::getAlias($this->t_dir);
        if (!is_dir($this->t_dir)){
            FileHelper::createDirectory($this->t_dir);
        }
        $f_p = $this->t_dir."/{$this->title}.txt";
        if (!file_exists($f_p)){
            file_put_contents($f_p, $this->content);
        }
    }

    /**
     * 获取url的域名
     * @param string $url
     * @return string
     */
    public static function getDomain($url)
    {
        preg_match('/[\w]+\:\/\/([^\/]+)[\S]+/', $url, $domain);
        return $domain[1];
    }
}