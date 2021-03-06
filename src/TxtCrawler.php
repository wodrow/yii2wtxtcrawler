<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午3:19
 */

namespace wodrow\yii2wtxtcrawler;


use wodrow\yii2wtxtcrawler\site\AiDouKanShu;
use wodrow\yii2wtxtcrawler\site\Ba1XinZHongWen;
use wodrow\yii2wtxtcrawler\site\BaBaiXiaoSHuoWang;
use wodrow\yii2wtxtcrawler\site\BaLingDianZiShuo;
use wodrow\yii2wtxtcrawler\site\BiQuDao;
use wodrow\yii2wtxtcrawler\site\BiQuGeCc;
use wodrow\yii2wtxtcrawler\site\BiQuGeCm;
use wodrow\yii2wtxtcrawler\site\Biquger;
use wodrow\yii2wtxtcrawler\site\Biquger001;
use wodrow\yii2wtxtcrawler\site\BiQuGerXiaoShuo;
use wodrow\yii2wtxtcrawler\site\Www_8jzwCom;
use wodrow\yii2wtxtcrawler\site\WwwAikantxtLa;
use wodrow\yii2wtxtcrawler\site\WwwBiquge9Cc;
use wodrow\yii2wtxtcrawler\site\WWWBiQuGeTw;
use wodrow\yii2wtxtcrawler\site\BiQuGeXiaoShuoWang;
use wodrow\yii2wtxtcrawler\site\BiQuGuan;
use wodrow\yii2wtxtcrawler\site\BiQuKan;
use wodrow\yii2wtxtcrawler\site\BiQuWo;
use wodrow\yii2wtxtcrawler\site\BiQuYun;
use wodrow\yii2wtxtcrawler\site\BiXiaWenXue;
use wodrow\yii2wtxtcrawler\site\BookTxt;
use wodrow\yii2wtxtcrawler\site\BookTxtCom;
use wodrow\yii2wtxtcrawler\site\BoQuGe;
use wodrow\yii2wtxtcrawler\site\Bqk;
use wodrow\yii2wtxtcrawler\site\BqgInfo;
use wodrow\yii2wtxtcrawler\site\CdzdgwBqg;
use wodrow\yii2wtxtcrawler\site\Ddxs;
use wodrow\yii2wtxtcrawler\site\DingDiann;
use wodrow\yii2wtxtcrawler\site\DuShuWang66;
use wodrow\yii2wtxtcrawler\site\HuaWenZaiXian;
use wodrow\yii2wtxtcrawler\site\KanShuLa;
use wodrow\yii2wtxtcrawler\site\KBiQuGe;
use wodrow\yii2wtxtcrawler\site\LieWenWang;
use wodrow\yii2wtxtcrawler\site\PingYueGeCom;
use wodrow\yii2wtxtcrawler\site\QuanBenXiaoShuoWang;
use wodrow\yii2wtxtcrawler\site\QuanShuWang;
use wodrow\yii2wtxtcrawler\site\QuanShuWang4;
use wodrow\yii2wtxtcrawler\site\QuanXiaoShuo;
use wodrow\yii2wtxtcrawler\site\ThirdZm;
use wodrow\yii2wtxtcrawler\site\TianTianZhongWen;
use wodrow\yii2wtxtcrawler\site\Txt68;
use wodrow\yii2wtxtcrawler\site\WWWBiqusaCom;
use wodrow\yii2wtxtcrawler\site\WWWBisogeCom;
use wodrow\yii2wtxtcrawler\site\WwwLvsetxtCom;
use wodrow\yii2wtxtcrawler\site\WwwTongshuNet;
use wodrow\yii2wtxtcrawler\site\XBiQuGeWCom;
use wodrow\yii2wtxtcrawler\site\Xbqg;
use wodrow\yii2wtxtcrawler\site\Xbqg6;
use wodrow\yii2wtxtcrawler\site\XiaoShuoShuWang;
use wodrow\yii2wtxtcrawler\site\YouShenXiaoShuoWang;
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
            Biquger001::DOMAIN => Biquger001::class,
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
            QuanXiaoShuo::DOMAIN => QuanXiaoShuo::class, //
            BaBaiXiaoSHuoWang::DOMAIN => BaBaiXiaoSHuoWang::class,
            XiaoShuoShuWang::DOMAIN => XiaoShuoShuWang::class,
            TianTianZhongWen::DOMAIN => TianTianZhongWen::class,
            BiQuKan::DOMAIN => BiQuKan::class,
            BiQuWo::DOMAIN => BiQuWo::class,
            KBiQuGe::DOMAIN => KBiQuGe::class,
            DuShuWang66::DOMAIN => DuShuWang66::class,
            LieWenWang::DOMAIN => LieWenWang::class,
            KanShuLa::DOMAIN => KanShuLa::class,
            YouShenXiaoShuoWang::DOMAIN => YouShenXiaoShuoWang::class,
            HuaWenZaiXian::DOMAIN => HuaWenZaiXian::class,
            CdzdgwBqg::DOMAIN => CdzdgwBqg::class,
            Ba1XinZHongWen::DOMAIN => Ba1XinZHongWen::class,
            BiQuDao::DOMAIN => BiQuDao::class,
            BiQuGeXiaoShuoWang::DOMAIN => BiQuGeXiaoShuoWang::class,
            BoQuGe::DOMAIN => BoQuGe::class,
            BiQuGuan::DOMAIN => BiQuGuan::class,
            BiQuGeCc::DOMAIN => BiQuGeCc::class,
            BiQuGeCm::DOMAIN => BiQuGeCm::class,
            BiQuYun::DOMAIN => BiQuYun::class,
            DingDiann::DOMAIN => DingDiann::class,
            BookTxt::DOMAIN => BookTxt::class,
            XBiQuGeWCom::DOMAIN => XBiQuGeWCom::class,
            PingYueGeCom::DOMAIN => PingYueGeCom::class,
            BookTxtCom::DOMAIN => BookTxtCom::class,
            WWWBiQuGeTw::DOMAIN => WWWBiQuGeTw::class,
            WWWBisogeCom::DOMAIN => WWWBisogeCom::class,
            WWWBiqusaCom::DOMAIN => WWWBiqusaCom::class,
            Www_8jzwCom::DOMAIN => Www_8jzwCom::class,
            WwwTongshuNet::DOMAIN => WwwTongshuNet::class,
            WwwLvsetxtCom::DOMAIN => WwwLvsetxtCom::class,
            WwwAikantxtLa::DOMAIN => WwwAikantxtLa::class,
            WwwBiquge9Cc::DOMAIN => WwwBiquge9Cc::class,
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