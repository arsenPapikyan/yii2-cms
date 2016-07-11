<?php

namespace yii2mod\cms\components;

use yii\web\UrlRule;
use yii2mod\cms\models\CmsModel;

/**
 * Class PageUrlRule
 * @package yii2mod\cms\components
 */
class PageUrlRule extends UrlRule
{
    /**
     * @var string the pattern used to parse and create the path info part of a URL.
     */
    public $pattern = '<\w+>';

    /**
     * @var string the route to the controller action
     */
    public $route = 'site/page';

    /**
     * Parse request
     *
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     *
     * @return boolean
     */
    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        // get path without '/' in end
        $url = preg_replace("#/$#", "", $pathInfo);
        // find page by url in db
        $page = (new CmsModel())->findPage($url);
        // redirect to page
        if (!empty($page)) {
            $params['pageAlias'] = $url;
            $params['pageId'] = $page->id;
            return [$this->route, $params];
        }

        return parent::parseRequest($manager, $request);
    }
}