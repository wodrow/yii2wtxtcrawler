<?php
/**
 * Created by PhpStorm.
 * User: wodrow
 * Date: 19-7-11
 * Time: 下午12:37
 */

namespace wodrow\yii2wtxtcrawler;


use QL\Ext\PhantomJs;
use QL\QueryList;
use yii\base\Component;
use yii\base\Exception;

/**
 * Class Ql
 * @package wodrow\yii2wtxtcrawler
 *
 * @property QueryList $ql
 */
class Ql extends Component
{
    public $phantomjsBinPath;

    /**
     * @return QueryList
     * @throws
     */
    public function getQl()
    {
        $ql = QueryList::getInstance();
        if ($this->phantomjsBinPath){
            if (PHP_OS != 'Linux'){
                $phantomjs = $this->phantomjsBinPath.'/phantomjs.exe';
            }else{
                $phantomjs = $this->phantomjsBinPath.'/phantomjs';
            }
            if (!file_exists($phantomjs)){
                throw new Exception("path:".$phantomjs." is not exist!");
            }
            if (!is_executable($phantomjs)){
                throw new Exception("path:".$phantomjs." is not executable! place set executable for the file");
            }
            \Yii::$classMap['JonnyW\PhantomJs\DependencyInjection\ServiceContainer'] = '@vendor/wodrow/yii2wtxtcrawler/src/rewrite/jonnyw/php-phantomjs/src/JonnyW/PhantomJs/DependencyInjection/ServiceContainer.php';
            $ql->use(PhantomJs::class, $phantomjs, 'browser');
//            $this->ql->use(PhantomJs::class, $this->phantomjs);
//            $html = $this->ql->browser('https://m.toutiao.com')->getHtml();
//            var_dump($html);
//            $data = $this->ql->browser('https://m.toutiao.com')->find('p')->texts();
//            print_r($data->all());
//            exit;
        }
        return $ql;
    }
}