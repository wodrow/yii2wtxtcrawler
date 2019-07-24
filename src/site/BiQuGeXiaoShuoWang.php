<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-23
 * Time: 下午2:09
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class BiQuGeXiaoShuoWang extends Tc
{
    const NAME = "笔趣阁小说网";
    const DOMAIN = "www.biqugexsw.com";
    const HOME_URL = "https://".self::DOMAIN;

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $s = '.listmain dd a';
        $list = $this->ql->rules([
            'title' => [$s, 'text'],
            'href' => [$s, 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get(self::HOME_URL.$v['href']);
            $eles = $this->ql->find('#content');
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