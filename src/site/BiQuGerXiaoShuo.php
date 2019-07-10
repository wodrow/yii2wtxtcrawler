<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-10
 * Time: 上午10:55
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class BiQuGerXiaoShuo extends Tc
{
    const NAME = "笔趣阁小说";
    const DOMAIN = "www.biqushu.com";
    const HOME_URL = "https://www.biqushu.com/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $ls = '.mulu_list li a';
        $list = $this->ql->rules([
            'title' => [$ls, 'text'],
            'href' => [$ls, 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get($this->url.$v['href']);
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