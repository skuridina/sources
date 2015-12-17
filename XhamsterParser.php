<?php
/**
 * Created by PhpStorm.
 * User: G74
 * Date: 26.08.14
 * Time: 13:44
 */

namespace Mobi\Models\Parsers;


class XhamsterParser extends SiteParser implements IPathProvider {

    //use ParseHelper;
    
    public function allowDirectPath()
    {
        if ($this->_mobileDetector->isMobile() && !$this->_mobileDetector->is('WindowsPhoneOS'))
        {
            return true;
        }

        return false;
    }

//    public function getDirectPath(\Mobi\Models\IVideoData $video)
//    {
////        $title = str_replace(' ', '_', strtolower($video->getTitle()));
////        $urlTpl = $this->_config['directPath'][$video->getSite()];
////        $urlTarget = str_replace(array('{videoId}', '{videoTitle}'),
////            array($video->getOriginalId(), $title), $urlTpl);
////
////        $urlInit = str_replace('play', 'movies', $urlTarget);
////
////        $page = $this->getPage($urlInit, $urlTarget);

//        $page = $this->getPage($this->_config['proxyPath'], $video->getOriginalUrl());
//        //return $this->_getInfoElement($page);
//        return $this->_getPath($page);
//    }

    public function getPage($urlInit, $urlTarget)
    {
        $page = $this->_grabber->getPage($urlTarget, 'mobile', array(), array(), '', array(), $urlInit);

        return $page;
    }

    public function _getPathFromPage($page)
    {

		$dom = $this->_GetDom($page);
		$url = $this->_getElementById($dom, 'play', 'href');

		if (strstr($url, '.mp4')) return $url;
		return null;
    }

	private function _getElementById(\DOMDocument $dom, $id, $attribute)
	{
		$tag = $dom->getElementById($id);

		if ($tag instanceof \DOMElement)
		{
			return $tag->getAttribute($attribute);
		}
		return null;
	}

	protected function _GetDom($page)
	{
		//get page
		$scraper = new \DOMDocument();

		@$scraper->loadHTML($page);

		return $scraper;
	}
//    public function getPage($urlInit, $urlTarget)
//    {
//        $cookieFilePath = $this->_grabber->getCookieFilePath($urlInit, 'mobile');
//
//        $header = array('Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
//            'Accept-Encoding:gzip,deflate,sdch',
//            'Accept-Language:en-US,en;q=0.8,ru;q=0.6',
//            'Connection:keep-alive',
//            'Host:m.xhamster.com');
//
//        $cookies = ['add' => 'm.xhamster.com	FALSE	/	FALSE	0	playCount	1',
//            'file' => $cookieFilePath];
//
//        $info = $this->_grabber->getRequestInfo($urlTarget, 'mobile', $cookies, $header, $urlInit);
//
//        if (isset($info['redirect_url']) && strstr($info['redirect_url'], '.mp4'))
//        {
//            $info = $this->_grabber->getRequestInfo($info['redirect_url'],
//                'desktop2');
//
//            if (isset($info['redirect_url']) && strstr($info['redirect_url'], '.mp4'))
//            {
//                return $info['redirect_url'];
//            }
//        }
//
//        return null;
//    }

    
} 