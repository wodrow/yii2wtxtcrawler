<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:19
 */

namespace wodrow\yii2wtxtcrawler;


use wodrow\yii2wtxtcrawler\site\Xbqg;
use wodrow\yii2wtxtcrawler\site\Xbqg6;
use wodrow\yii2wtxtcrawler\wiki\Lgqm;
use yii\base\Exception;

class TxtCrawler
{
    /**
     * @var Tc $tc
     */
    protected $tc;

    public $t_dir = "@runtime/txt";
    public $generate = 0;

    /**
     * @param $url
     * @param int $generate 是否生成txt
     * @return array
     * @throws
     */
    public function makeTxt($url)
    {
        $domain = Tc::getDomain($url);
        switch ($domain){
            case Lgqm::DOMAIN:
                $this->tc = new Lgqm();
                break;
            case Xbqg::DOMAIN:
                $this->tc = new Xbqg();
                break;
            case Xbqg6::DOMAIN:
                $this->tc = new Xbqg6();
                break;
            default:
                throw new Exception("没有找到该域名的解析组件");
                break;
        }
        $this->tc->url = $url;
        $data = $this->tc->crawler();
        if ($this->generate){
            $this->tc->t_dir = $this->t_dir;
            $this->tc->generate();
        }
        return $data;
    }
}