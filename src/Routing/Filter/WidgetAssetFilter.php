<?php
namespace Cms\Routing\Filter;

use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\Routing\DispatcherFilter;
use Cms\Widget\WidgetFactory;
use Cms\Widget\WidgetManager;

class WidgetAssetFilter extends DispatcherFilter
{

    /**
     * Tries to find the requested asset file.
     *
     * @param Event $event Event
     * @return Response
     */
    public function beforeDispatch(Event $event)
    {
        $request = $event->data['request'];

        $url = urldecode($request->url);
        if (strpos($url, '..') !== false || strpos($url, '.') === false) {
            return null;
        }

        $assetFile = $this->_getAssetFile($url);
        if ($assetFile === null || !file_exists($assetFile)) {
            return null;
        }
        $response = $event->data['response'];
        $event->stopPropagation();

        $response->modified(filemtime($assetFile));
        if ($response->checkNotModified($request)) {
            return $response;
        }

        $pathSegments = explode('.', $url);
        $ext = array_pop($pathSegments);
        $this->_deliverAsset($request, $response, $assetFile, $ext);
        return $response;
    }

    /**
     * Builds asset file path based off url
     *
     * @param string $url Asset URL
     * @return string Absolute path for asset file
     */
    protected function _getAssetFile($url)
    {
        $pattern = '/^cms\/widget\/([a-z\.]+)\/(.*)$/i';
        if (preg_match($pattern, $url, $matches)) {
            $widgetIdentifier = $matches[1];
            $assetPath = $matches[2];

            if (!WidgetManager::widgetExists($widgetIdentifier)) {
                throw new \Cake\Network\Exception\NotFoundException("Widget {$widgetIdentifier} could not be found");
            }
            $widget = WidgetFactory::identifierFactory($widgetIdentifier);
            $assetFile = $widget->getWebrootPath() . $assetPath;
            return $assetFile;
        }
    }

    /**
     * Sends an asset file to the client
     *
     * @param \Cake\Network\Request $request The request object to use.
     * @param \Cake\Network\Response $response The response object to use.
     * @param string $assetFile Path to the asset file in the file system
     * @param string $ext The extension of the file to determine its mime type
     * @return void
     */
    protected function _deliverAsset(Request $request, Response $response, $assetFile, $ext)
    {
        $compressionEnabled = $response->compress();
        if ($response->type($ext) === $ext) {
            $contentType = 'application/octet-stream';
            $agent = $request->env('HTTP_USER_AGENT');
            if (preg_match('%Opera(/| )([0-9].[0-9]{1,2})%', $agent) || preg_match('/MSIE ([0-9].[0-9]{1,2})/', $agent)) {
                $contentType = 'application/octetstream';
            }
            $response->type($contentType);
        }
        if (!$compressionEnabled) {
            $response->header('Content-Length', filesize($assetFile));
        }
        // $response->cache(filemtime($assetFile), $this->_cacheTime);
        $response->sendHeaders();
        readfile($assetFile);
        if ($compressionEnabled) {
            ob_end_flush();
        }
    }
}
