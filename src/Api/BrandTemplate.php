<?php

namespace RewardCloud\Api;


class BrandTemplate extends ApiGeneral
{

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function list(array $params = [])
    {
        $uri = 'templates';

        $request = $this->get($uri, $params);

        return $request;
    }

    /**
     * @param  array  $params
     *
     * @return array
     */
    public function request(array $params)
    {
        $uri = 'template';

        $request = $this->get($uri, $params);

        return $request;
    }

}