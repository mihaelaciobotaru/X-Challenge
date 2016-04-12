<?php
    namespace AppBundle\Helper;

    use Symfony\Component\Validator\Constraints\Url;

    class UrlHelper extends ContainerAware
    {
        public function getRefererRoute()
        {
            $request = $this->getRequest();

            $referer = $request->headers->get('referer');
            $lastPath = substr($referer, strpos($referer, $request->getBaseUrl()));
            $lastPath = str_replace($request->getBaseUrl(), '', $lastPath);

            $matcher = $this->get('router')->getMatcher();
            $parameters = $matcher->match($lastPath);
            $route = $parameters['_route'];

            return $route;
        }
        
    }