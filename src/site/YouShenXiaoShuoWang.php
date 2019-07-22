<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-22
 * Time: 下午1:30
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class YouShenXiaoShuoWang extends Tc
{
    const NAME = "游神小说网";
    const DOMAIN = "www.youshend.com";
    const HOME_URL = "https://www.youshend.com/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $list = $this->ql->rules([
            'title' => ['#main dd a', 'text'],
            'href' => ['#main dd a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get($this->url.$v['href']);
            $eles = $this->ql->find('#BookText');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r\n\n";
            if ($this->show_log){
                var_dump($title);
//                var_dump($eles->text());
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}