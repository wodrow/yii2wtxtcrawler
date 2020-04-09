<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:33
 */

namespace wodrow\yii2wtxtcrawler;


use QL\QueryList;
use yii\base\Component;
use yii\helpers\FileHelper;

abstract class Tc extends Component implements Api
{
    public $url;
    public $title;
    public $content = "";
    public $phantomjsBinPath;

    public $t_dir;
    public $show_log;

    /**
     * @var QueryList $ql
     */
    public $ql;

    /**
     * @throws
     */
    public function init()
    {
        parent::init();
        $ql = new Ql();
        $ql->phantomjsBinPath = $this->phantomjsBinPath;
        $this->ql = $ql->ql;
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