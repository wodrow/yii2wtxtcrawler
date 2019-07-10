<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-8
 * Time: 下午6:31
 */

namespace wodrow\yii2wtxtcrawler\site;


use QL\QueryList;
use wodrow\yii2wtxtcrawler\Tc;

class Xbqg extends Tc
{
    const NAME = "新笔趣阁";
    const DOMAIN = "www.xbiquge.la";
    const HOME_URL = "http://www.xbiquge.la/";

    /**
     * @return array|mixed
     */
    public function crawler()
    {
        $ql = $this->ql->get($this->url);
        $this->title = $ql->find('title')->text();
        if ($this->show_log)var_dump($this->title);
        $list = $ql->rules([
            'title' => ['#list a', 'text'],
            'href' => ['#list a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $title = $v['title'];
            $this->content .= $title."\r\n\n";
            $_ql = QueryList::getInstance()->get("http://".self::DOMAIN.$v['href']);
            $eles = $_ql->find('#content');
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