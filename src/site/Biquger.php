<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-10
 * Time: 上午9:51
 */

namespace wodrow\yii2wtxtcrawler\site;


use wodrow\yii2wtxtcrawler\Tc;

class Biquger extends Tc
{
    const NAME = "笔趣阁";
    const DOMAIN = "www.biquger.com";
    const HOME_URL = "https://www.biquger.com/";

    public function crawler()
    {
        $this->ql->get($this->url);
        $html = $this->ql->getHtml();
//        preg_match("/\<title\>([^\<]+)\<\/title\>/", $html, $ms);
//        $this->title = $ms[1];
        $this->title = $this->ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
//        preg_match('/\<div\sclass\=\"box_con\"\>([\s\S]+)\<\/div\>/', $html, $ms);
//        $this->ql->html($ms[1]);
        $list = $this->ql->rules([
            'title' => ['#list dd a', 'text'],
            'href' => ['#list dd a', 'href'],
        ])
//            ->encoding('UTF-8','Windows-1258')
//            ->removeHead()
            ->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
//            $title = iconv('GBK', 'UTF-8', $title);
            $title = mb_convert_encoding($title, 'UTF-8', 'GBK');
            $this->content .= $title."\r\n\n";
            $this->ql->get($v['href']);
            $eles = $this->ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r\n\n";
            if ($this->show_log){
                var_dump($title);
            }
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}