<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:19
 */

namespace wodrow\yii2wtxtcrawler;


use wodrow\yii2wtxtcrawler\site\AiDouKanShu;
use wodrow\yii2wtxtcrawler\site\BaBaiXiaoSHuoWang;
use wodrow\yii2wtxtcrawler\site\BaLingDianZiShuo;
use wodrow\yii2wtxtcrawler\site\Biquger;
use wodrow\yii2wtxtcrawler\site\BiQuGerXiaoShuo;
use wodrow\yii2wtxtcrawler\site\BiQuKan;
use wodrow\yii2wtxtcrawler\site\BiXiaWenXue;
use wodrow\yii2wtxtcrawler\site\Bqk;
use wodrow\yii2wtxtcrawler\site\BqgInfo;
use wodrow\yii2wtxtcrawler\site\Ddxs;
use wodrow\yii2wtxtcrawler\site\QuanBenXiaoShuoWang;
use wodrow\yii2wtxtcrawler\site\QuanShuWang;
use wodrow\yii2wtxtcrawler\site\QuanShuWang4;
use wodrow\yii2wtxtcrawler\site\QuanXiaoShuo;
use wodrow\yii2wtxtcrawler\site\ThirdZm;
use wodrow\yii2wtxtcrawler\site\TianTianZhongWen;
use wodrow\yii2wtxtcrawler\site\Txt68;
use wodrow\yii2wtxtcrawler\site\Xbqg;
use wodrow\yii2wtxtcrawler\site\Xbqg6;
use wodrow\yii2wtxtcrawler\site\XiaoShuoShuWang;
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
    public $is_inconsole = 0;
    public $show_log = 0;
    public $url;

    public function getTcs()
    {
        return [
            Lgqm::DOMAIN => Lgqm::class,
            Biquger::DOMAIN => Biquger::class,
            Bqk::DOMAIN => Bqk::class,
            BqgInfo::DOMAIN => BqgInfo::class,
            Xbqg::DOMAIN => Xbqg::class,
            Xbqg6::DOMAIN => Xbqg6::class,
            Txt68::DOMAIN => Txt68::class,
            ThirdZm::DOMAIN => ThirdZm::class,
            Ddxs::DOMAIN => Ddxs::class,
            AiDouKanShu::DOMAIN => AiDouKanShu::class,
            QuanShuWang::DOMAIN => QuanShuWang::class,
            QuanShuWang4::DOMAIN => QuanShuWang4::class,
            QuanBenXiaoShuoWang::DOMAIN => QuanBenXiaoShuoWang::class,
            BaLingDianZiShuo::DOMAIN => BaLingDianZiShuo::class,
            BiXiaWenXue::DOMAIN => BiXiaWenXue::class,
            BiQuGerXiaoShuo::DOMAIN => BiQuGerXiaoShuo::class,
//            QuanXiaoShuo::DOMAIN => QuanXiaoShuo::class,
            BaBaiXiaoSHuoWang::DOMAIN => BaBaiXiaoSHuoWang::class,
            XiaoShuoShuWang::DOMAIN => XiaoShuoShuWang::class,
            TianTianZhongWen::DOMAIN => TianTianZhongWen::class,
            BiQuKan::DOMAIN => BiQuKan::class,
        ];
    }

    /**
     * @return array
     * @throws
     */
    public function makeTxt()
    {
        if (!$this->url){
            throw new Exception("url must");
        }
        if ($this->is_inconsole){
            $this->show_log = 1;
        }
        $domain = Tc::getDomain($this->url);
        $tcs = $this->getTcs();
        if (!in_array($domain, array_flip($tcs))){
            throw new Exception("没有找到该域名的解析组件");
        }
        foreach ($tcs as $k => $v){
            if ($domain == $k){
                $this->tc = new $v;
            }
        }
        $this->tc->url = $this->url;
        $this->tc->show_log = $this->show_log;
        $data = $this->tc->crawler();
        if ($this->generate){
            $this->tc->t_dir = $this->t_dir;
            $this->tc->generate();
        }
        return $data;
    }
}