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
        $list = $ql->rules([
            'title' => ['#list a', 'text'],
            'href' => ['#list a', 'href'],
        ])->queryData();
        $this->content = "";
        foreach ($list as $k => $v){
            $this->content .= $v['title']."\r";
            $_ql = QueryList::getInstance()->get("http://".self::DOMAIN.$v['href']);
            $eles = $_ql->find('#content');
            $eles->find('p:last')->remove();
            $this->content .= $eles->text()."\r";
        }
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}